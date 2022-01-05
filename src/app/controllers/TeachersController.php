<?php

/**
 * ETML
 * Author: Valentin Kaelin
 * Date: 26.11.2019
 * Description: Controller for all the Teachers related routes
 */

namespace App\Controllers;

use App\Core\App;

class TeachersController
{
  /**
   * Show the list of teachers.
   */
  public function index()
  {
    $teachers = App::get('database')->getAllTeacher();

    return view('teachers/index', compact('teachers'));
  }

  /**
   * Show details of a selected teacher
   */
  public function show($user)
  {
    // Redirect if the user is not logged
    if (empty($user)) {
      return redirect('');
    }

    if (!isset($_GET['id'])) {
      return redirect('');
    }

    $result = App::get('database')->getOneTeacher($_GET['id']);

    return view('teachers/show', ['teacher' => $result[0], 'allRows' => $result]);
  }

  /**
   * Show form to create a new teacher
   */
  public function create($user)
  {
    // Redirect if the user is not logged or is not admin
    if (empty($user) || $user['role'] !== 'Admin') {
      return redirect('');
    }

    $sections = App::get('database')->getAllSections();

    return view('teachers/create', compact('sections'));
  }

  /**
   * Store a new teacher
   */
  public function store($user)
  {
    // Redirect if the user is not logged or is not admin
    if (empty($user) || $user['role'] !== 'Admin') {
      return redirect('');
    }

    $firstName = htmlspecialchars($_POST['firstName'] ?? '');
    $lastName = htmlspecialchars($_POST['lastName'] ?? '');
    $gender = !empty($_POST['gender']) ? htmlspecialchars($_POST['gender']) : 'Z';
    $sections = $_POST['sections'] ?? [];
    $nickname =  htmlspecialchars($_POST['nickname'] ?? '');
    $origin =  htmlspecialchars($_POST['origin'] ?? '');

    // Validation
    $errors = $this->verifyTeacherInfos($firstName, $lastName, $gender, $sections, $nickname, $origin);

    // Validation: fields not empty
    if (empty($firstName) || empty($lastName) || empty($gender) || empty($sections) || empty($nickname) || empty($origin)) {
      array_push($errors, 'Tous les champs doivent être remplis.');
    }

    // No errors: store in db and redirect to homepage
    if (empty($errors)) {
      App::get('database')->createTeacher([
        'firstName' => $firstName,
        'lastName' => $lastName,
        'gender' => $gender,
        'sections' => $sections,
        'nickname' => $nickname,
        'origin' => $origin,
      ]);
      redirect('');
    }
    // Errors: display errors to user
    else {
      $sections = App::get('database')->getAllSections();
      return view('teachers/create', [
        'sections' => $sections,
        'errors' => $errors
      ]);
    }
  }

  /**
   * Show page with form to edit a teacher
   */
  public function edit($user)
  {
    // Redirect if the user is not logged or is not admin
    if (empty($user) || $user['role'] !== 'Admin') {
      return redirect('');
    }

    if (!isset($_GET['id'])) {
      return redirect('');
    }

    $sections = App::get('database')->getAllSections();
    $result = App::get('database')->getOneTeacher($_GET['id']);
    $nicknameKey = array_search($_SESSION['user']['id'], array_column($result, 'idUser'));
    $alreadyNamedByUser = $nicknameKey !== false;
    $nickname = $alreadyNamedByUser ? $result[$nicknameKey] : null;

    return view('teachers/edit', [
      'teacher' => $result[0],
      'sections' => $sections,
      'nickname' => $nickname,
      'alreadyNamedByUser' => $alreadyNamedByUser
    ]);
  }

  /**
   * Update a selected teacher
   */
  public function update($user)
  {
    // Redirect if the user is not logged or is not admin
    if (empty($user) || $user['role'] !== 'Admin') {
      return redirect('');
    }

    $firstName = htmlspecialchars($_POST['firstName'] ?? '');
    $lastName = htmlspecialchars($_POST['lastName'] ?? '');
    $gender = htmlspecialchars($_POST['gender'] ?? 'Z');
    $sections = $_POST['sections'] ?? [];
    $idTeacher =  htmlspecialchars($_POST['idTeacher'] ?? '');

    $errors = $this->verifyTeacherInfos($firstName, $lastName, $gender, $sections);

    // Validation: fields not empty
    if (empty($firstName) || empty($lastName) || empty($gender) || empty($sections)) {
      array_push($errors, 'Tous les champs doivent être remplis.');
    }

    // No errors: update in db and redirect
    if (empty($errors)) {
      App::get('database')->updateTeacher([
        'idTeacher' => $idTeacher,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'gender' => $gender,
        'sections' => $sections,
      ]);
      redirect('');
    }
    // Errors: display errors to user
    else {
      $sections = App::get('database')->getAllSections();
      $result = App::get('database')->getOneTeacher($idTeacher);
      $nicknameKey = array_search($_SESSION['user']['id'], array_column($result, 'idUser'));
      $alreadyNamedByUser = $nicknameKey !== false;
      $nickname = $alreadyNamedByUser ? $result[$nicknameKey] : null;
      return view('teachers/edit', [
        'sections' => $sections,
        'teacher' => $result[0],
        'nickname' => $nickname,
        'alreadyNamedByUser' => $alreadyNamedByUser,
        'errors' => $errors
      ]);
    }
  }

  /**
   * Delete a selected teacher
   */
  public function delete($user)
  {
    // Redirect if the user is not logged or is not admin
    if (empty($user) || $user['role'] !== 'Admin') {
      return redirect('');
    }

    if (!isset($_GET['id'])) {
      return redirect('');
    }

    App::get('database')->deleteOneTeacher($_GET['id']);

    redirect('');
  }

  /**
   * A user can vote for a teacher
   */
  public function vote($user)
  {
    // Redirect if the user is not logged
    if (empty($user)) {
      return redirect('');
    }

    $idTeacher = htmlspecialchars($_POST['idTeacher'] ?? '');
    $oldVotes = htmlspecialchars($_POST['oldVotes'] ?? '');

    // User input validation
    if (
      empty($idTeacher) || (empty($oldVotes) && $oldVotes !== '0') ||
      $user['votes'] > 2
    ) {
      return redirect('');
    }

    App::get('database')->voteForATeacher([
      'idTeacher' => $idTeacher,
      'votes' => ($oldVotes + 1),
    ]);

    return redirect('');
  }

  /**
   * Validate the user inputs when creating or updating a Teacher
   */
  private function verifyTeacherInfos($firstName, $lastName, $gender, $sections, $nickname = null, $origin = null)
  {
    $errors = [];

    // Verification on creation (with nickname)
    if ($nickname) {
      if (strlen($origin) > 255) {
        array_push($errors, 'L\'origine du surnom ne doit pas faire plus de 255 caractères.');
      }

      if (strlen($nickname) > 50) {
        array_push($errors, 'Le surnom ne doit pas faire plus de 50 caractères.');
      }

      // Validation: alphanumeric fields
      if (
        !preg_match('/^[a-zA-Z0-9- àâçéèêëîïôûùüÿñæœ\']+$/', $firstName) ||
        !preg_match('/^[a-zA-Z0-9- àâçéèêëîïôûùüÿñæœ\']+$/', $lastName) ||
        !preg_match('/^[a-zA-Z0-9- àâçéèêëîïôûùüÿñæœ\']+$/', $nickname) ||
        !preg_match('/^[a-zA-Z0-9- àâçéèêëîïôûùüÿñæœ\'\.,]+$/', $origin)
      ) {
        array_push($errors, 'Le prénom, le nom, le surnom et son origine doivent être alphanumériques.');
      }
    }
    // Verification on update (no nickname)
    else {
      // Validation: alphanumeric fields
      if (
        !preg_match('/^[a-zA-Z0-9- àâçéèêëîïôûùüÿñæœ\']+$/', $firstName) ||
        !preg_match('/^[a-zA-Z0-9- àâçéèêëîïôûùüÿñæœ\']+$/', $lastName)
      ) {
        array_push($errors, 'Le prénom et le nom doivent être alphanumériques.');
      }
    }

    // Validation: string length
    if (strlen($firstName) > 50 || strlen($lastName) > 50) {
      array_push($errors, 'Le prénom et le nom ne doivent pas faire plus de 50 caractères.');
    }

    // Validation: gender exists
    $gender = strtoupper($gender[0]);
    $acceptedGenders = ['H', 'F', 'A'];
    if (!in_array($gender, $acceptedGenders)) {
      array_push($errors, 'Genre invalide.');
    }

    // Validation: section(s) exist(s)
    foreach ($sections as $section) {
      if (!App::get('database')->checkSectionExists(htmlspecialchars($section))) {
        array_push($errors, 'Section(s) invalide(s).');
        break;
      }
    }

    return $errors;
  }
}
