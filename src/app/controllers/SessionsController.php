<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Controller gérant les Séances
 */

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

        $sessions = App::get('sessions-repository')->getSessionsUser($user['id']);

        return view('sessions/index', compact('sessions'));
    }

    public function show($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            return redirect('sessions');
        }

        $id = intval($_GET['id']);

        $sessions = App::get('sessions-repository')->getSession($user['id'], $id);

        return view('sessions/show', compact('sessions'));
    }

    public function create($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        $programs = App::get('programs-repository')->getLightProgramsOfUser($user['id']);
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
