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
    /**
     * Historique des séances d'un utilisateur
     *
     * @param object $user potentiel utilisateur connecté
     */
    public function index($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $sessions = App::get('sessions-repository')->getSessionsOfUser($user['id']);

        return view('sessions/index', compact('sessions'));
    }

    /**
     * Affiche les détails d'une séance réalisée par un utilisateur
     *
     * @param object $user potentiel utilisateur connecté
     */
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

    /**
     * Formulaire permettant de démarrer une nouvelle séance
     *
     * @param object $user potentiel utilisateur connecté
     */
    public function create($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        // Redirection si l'utilisateur a déjà une séance en cours
        if (isset($user['currentSession'])) {
            return redirect('series/create?id=' . $user['currentSession']);
        }

        $programs = App::get('programs-repository')->getLightProgramsOfUser($user['id']);

        return view('sessions/create', compact('programs'));
    }

    /**
     * Enregistre une nouvelle séance dans la base de données
     *
     * @param object $user potentiel utilisateur connecté
     */
    public function store($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        // Redirection si l'utilisateur a déjà une séance en cours
        if (isset($user['currentSession'])) {
            return redirect('series/create?id=' . $user['currentSession']);
        }

        $programId = intval(htmlspecialchars($_POST['program'] ?? 0));
        $idSession = App::get('sessions-repository')->createSession($programId);

        // Stocke la séance en cours dans la session
        $_SESSION['user']['currentSession'] = $idSession;

        return redirect('series/create?id=' . $idSession);
    }

    /**
     * Termine la séance d'un utilisateur
     *
     * @param object $user potentiel utilisateur connecté
     */
    public function end($user)
    {
        // Redirection si l'utilisateur n'est pas connecté ou si l'id de
        // la séance à terminer n'est pas envoyé
        if (empty($user) || !isset($_POST['idSession'])) {
            return redirect('');
        }
        $idSession = intval(htmlspecialchars($_POST['idSession']));

        // Vérification que la séance ne soit pas déjà finie et qu'elle ait au moins une série
        $currentSession = App::get('sessions-repository')->getNbSeriesOfCurrentSession(
            $user['id'],
            htmlspecialchars($_POST['idSession'])
        );

        if ($currentSession['nbséries'] <= 0) {
            return redirect('series/create?id=' . $idSession);
        }

        App::get('sessions-repository')->endSession($idSession);

        // Suppression de la séance en cours dans la session
        unset($_SESSION['user']['currentSession']);

        return redirect('session?id=' . $idSession);
    }
}
