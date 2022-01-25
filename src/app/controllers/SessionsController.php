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

        $programs = App::get('programs-repository')->getAllProgramsOfUser(htmlspecialchars($user['id']));
        return view('sessions/create', compact('programs'));
    }

    public function store($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }
        $programid = intval(htmlspecialchars($_POST['program'] ?? 0));
        $session = App::get('sessions-repository')->createSession($programid);
        return redirect('series/create?idSession=' . $session);
        //return view('series/create', compact('session'));

        //  Récupération du nombre de séries conseillées comme valeurs par défaut
        // $exercices = App::get('exercices-repository')->TMP_getAllExercices();
        // $exercicesPopulated = [];
    }

    public function end($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }
        $sessionid = intval(htmlspecialchars($_POST['sessionid'] ?? 0));
        App::get('sessions-repository')->endSession($user, $sessionid);
        return redirect('series');
        //return view('series/create', compact('session'));

        //  Récupération du nombre de séries conseillées comme valeurs par défaut
        // $exercices = App::get('exercices-repository')->TMP_getAllExercices();
        // $exercicesPopulated = [];
    }
}
