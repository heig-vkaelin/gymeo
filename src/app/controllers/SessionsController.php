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
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $sessions = App::get('sessions-repository')->getSessionsUser($user['id']);

        return view('sessions/index', compact('sessions'));
    }

    public function show($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        // Vérification que l'id de la séance est bien passé en paramètre
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            return redirect('sessions');
        }

        $idSession = intval($_GET['id']);

        $sessions = App::get('sessions-repository')->getSession($user['id'], $idSession);

        return view('sessions/show', compact('sessions'));
    }

    public function create($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $programs = App::get('programs-repository')->getLightProgramsOfUser($user['id']);

        return view('sessions/create', compact('programs'));
    }

    public function store($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $programId = intval(htmlspecialchars($_POST['program'] ?? 0));
        $session = App::get('sessions-repository')->createSession($programId);

        return redirect('series/create?idSession=' . $session);
    }

    /**
     * Termine la séance d'un utilisateur
     */
    public function end($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $sessionId = intval(htmlspecialchars($_POST['sessionid'] ?? 0));
        App::get('sessions-repository')->endSession($user, $sessionId);

        return redirect('series');
    }
}
