<?php

/**
 * ETML
 * Author: Valentin Kaelin
 * Date: 21.11.2019
 * Description: Controller for all the Teachers' nicknames related routes
 */

namespace App\Controllers;

use App\Core\App;

class NicknamesController
{
  /**
   * Store a new teacher's nickname
   */
  public function store($user)
  {
    // Redirect if the user is not logged or is not admin
    if (empty($user) || $user['role'] !== 'Admin') {
      return redirect('');
    }

    $idTeacher = htmlspecialchars($_POST['idTeacher'] ?? '');
    $idUser = htmlspecialchars($_POST['idUser'] ?? '');
    $nickname = htmlspecialchars($_POST['nickname'] ?? '');
    $origin = htmlspecialchars($_POST['origin'] ?? '');

    // Validation
    $errors = $this->validateNickname($idTeacher, $idUser, $nickname, $origin);

    //No errors: store in db and redirect
    if (!$errors) {
      App::get('database')->createNickname([
        'idTeacher' => $idTeacher,
        'idUser' => $idUser,
        'nickname' => $nickname,
        'origin' => $origin,
      ]);
      redirect("teachers?id={$idTeacher}");
    }
    // Errors: redirect to edit view
    else {
      redirect("teachers/edit?id={$idTeacher}");
    }
  }

  /**
   * Update a selected teacher's nickname
   */
  public function update($user)
  {
    // Redirect if the user is not logged or is not admin
    if (empty($user) || $user['role'] !== 'Admin') {
      return redirect('');
    }

    $idTeacher = htmlspecialchars($_POST['idTeacher'] ?? '');
    $idUser = htmlspecialchars($_POST['idUser'] ?? '');
    $nickname = htmlspecialchars($_POST['nickname'] ?? '');
    $origin = htmlspecialchars($_POST['origin'] ?? '');

    // Validation
    $errors = $this->validateNickname($idTeacher, $idUser, $nickname, $origin);

    //No errors: update in db and redirect
    if (!$errors) {
      App::get('database')->updateNickname([
        'idTeacher' => $idTeacher,
        'idUser' => $idUser,
        'nickname' => $nickname,
        'origin' => $origin,
      ]);
      redirect("teachers?id={$idTeacher}");
    }
    // Errors: redirect to edit view
    else {
      redirect("teachers/edit?id={$idTeacher}");
    }
  }

  /**
   * Helper to validate a nickname entered by an admin
   */
  private function validateNickname($idTeacher, $idUser, $nickname, $origin)
  {
    if (empty($idTeacher) || empty($idUser) || empty($nickname) || empty($origin)) {
      return true;
    }
    if (strlen($origin) > 255 || strlen($nickname) > 50) {
      return true;
    }
    if (
      !preg_match('/^[a-zA-Z0-9- àâçéèêëîïôûùüÿñæœ\']+$/', $nickname) ||
      !preg_match('/^[a-zA-Z0-9- àâçéèêëîïôûùüÿñæœ\'\.,]+$/', $origin)
    ) {
      return true;
    }

    return false;
  }
}
