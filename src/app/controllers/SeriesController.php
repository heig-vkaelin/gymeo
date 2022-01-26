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
    public function index($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $series = App::get('series-repository')->getSeriesByUser($user['id']);

        return view('series/index', compact('series'));
    }

    public function create($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user) || !isset($_GET['idSession'])) {
            return redirect('');
        }

        $idSession = htmlspecialchars($_GET['idSession']);
        $series = App::get('series-repository')->getSeriesById($user['id'], $idSession);
        $exercices = App::get('exercices-repository')->getExercicesBySession($user['id'], $idSession);

        return view('series/create', compact('series', 'exercices'));
    }

    public function store($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }
        if ($_POST['exercice'] != NULL || $_POST['timeRep'] != NULL) {
            return redirect('series/create?idSession=' . $_POST['idSession']);
        }
        // Soit le nombre de répétitions soit le temps est utilisé
        $time = NULL;
        $repetition = NULL;
        $exercice = App::get('exercices-repository')->getOneExercice($_POST['exercice']);
        if (isset($exercice["nbrépétitions"])) {
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

        return redirect('series/create?idSession=' . $_POST['idSession']);
    }
}
