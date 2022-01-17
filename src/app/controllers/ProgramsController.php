<?php

namespace App\Controllers;

use App\Core\App;

class ProgramsController
{
    public function index($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        // $programs = App::get('programs-repository')->getAllprograms($user['id']);
        $programs = [];

        return view('programs/index', compact('programs'));
    }

    public function show($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        if (!isset($_GET['id'])) {
            return redirect('');
        }

        // $result = App::get('programs-repository')->getOneProgram($user['id'], $_GET['id']);
        $program = (object)[];

        return view('programs/show', compact('program'));
    }

    public function create($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        $exercices = App::get('exercices-repository')->TMP_getAllExercices();

        return view('programs/create', compact('exercices'));
    }

    public function store($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        $programName = htmlspecialchars($_POST['programName'] ?? '');
        // $lastName = htmlspecialchars($_POST['lastName'] ?? '');
        // $gender = !empty($_POST['gender']) ? htmlspecialchars($_POST['gender']) : 'Z';
        // $sections = $_POST['sections'] ?? [];
        // $nickname =  htmlspecialchars($_POST['nickname'] ?? '');
        // $origin =  htmlspecialchars($_POST['origin'] ?? '');

        // App::get('programs-repository')->createProgram([
        //     'programName' => $programName,
        //     // 'lastName' => $lastName,
        // ]);
        redirect('programs');
    }
}
