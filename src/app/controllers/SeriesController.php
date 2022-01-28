<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Controller gérant les Séries
 */

namespace App\Controllers;

use App\Core\App;

class SeriesController
{
    /**
     * Affiche la l'historique des séries réalisées par un utilisateur
     *
     * @param object $user potentiel utilisateur connecté
     */
    public function index($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $series = App::get('series-repository')->getSeriesByUser($user['id']);

        return view('series/index', compact('series'));
    }

    /**
     * Formulaire permettant d'ajouter une série à la séance en cours
     *
     * @param object $user potentiel utilisateur connecté
     */
    public function create($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user) || !isset($_GET['id'])) {
            return redirect('');
        }

        $idSession = htmlspecialchars($_GET['id']);

        // Redirection sur la séance en cours, si ce n'est pas celle accédée
        if (isset($user['currentSession']) && $user['currentSession'] != $idSession) {
            return redirect('series/create?id=' . $user['currentSession']);
        }

        $session = App::get('sessions-repository')->getSession($user['id'], $idSession);

        if ($session) {
            $exercices = App::get('exercices-repository')->getExercicesBySession($user['id'], $idSession);

            // Stocke la séance en cours dans la session
            $_SESSION['user']['currentSession'] = $idSession;

            return view('series/create', compact('session', 'exercices'));
        }
        return redirect('sessions');
    }

    /**
     * Enregistre la nouvelle série dans la base de données
     *
     * @param object $user potentiel utilisateur connecté
     */
    public function store($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }
        if ($_POST['exercice'] == NULL || $_POST['timeRep'] == NULL) {
            return redirect('series/create?id=' . $_POST['idSession']);
        }
        // Soit le nombre de répétitions soit le temps est utilisé
        $time = NULL;
        $repetition = NULL;
        $exercice = App::get('exercices-repository')->getOneExercice($_POST['exercice']);

        if (isset($exercice["nbrépétitionsconseillé"])) {
            $repetition = htmlspecialchars($_POST['timeRep']);
        } else {
            $time = htmlspecialchars($_POST['timeRep']);
        }

        App::get('series-repository')->createSerie(
            htmlspecialchars($_POST['idSession']),
            htmlspecialchars($_POST['exercice']),
            $repetition,
            $time,
            htmlspecialchars($_POST['weight'])
        );

        return redirect('series/create?id=' . $_POST['idSession']);
    }
}
