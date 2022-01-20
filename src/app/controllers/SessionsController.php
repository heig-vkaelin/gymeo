<?php

namespace App\Controllers;

use App\Core\App;

class SessionsController
{
    public function index($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        // $result = App::get('programs-repository')->getOneProgram($user['id'], $_GET['id']);
        $sessions = App::get('sessions-repository')->getSessionsUser($user['id']);

        return view('sessions/index', compact('sessions'));
    }
    public function create($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        $programs = App::get('programs-repository')->getAllProgramsOfUser($user['id']);

        return view('sessions/create', compact('programs'));
    }

    public function store($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }
        $programid = intval(htmlspecialchars($_POST['program'] ?? 0));
        $serie = App::get('sessions-repository')->createSession($programid);
        return view('series/create', compact('serie'));

        //  Récupération du nombre de séries conseillées comme valeurs par défaut
        // $exercices = App::get('exercices-repository')->TMP_getAllExercices();
        // $exercicesPopulated = [];
    }
}
