<?php

namespace App\Controllers;

use App\Core\App;

class SeriesController
{
    public function index($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        // $result = App::get('programs-repository')->getOneProgram($user['id'], $_GET['id']);
        $series = App::get('series-repository')->getSeriesByUser($user['id']);

        return view('series/index', compact('series'));
    }

    public function create($user)
    {

        // Redirect if the user is not logged
        if (empty($user) || !isset($_GET['idSession'])) {
            return redirect('');
        }

        $series = App::get('series-repository')->getSeriesById($user['id'], $_GET['idSession']);
        $exercices = App::get('exercices-repository')->getExercicesBySession($user['id'], $_GET['idSession']);
        return view('series/create', compact('series', 'exercices'));
    }

    public function store($user)
    {
        // Redirect if the user is not logged
        if (empty($user) || !isset($_POST['exercice'])) {
            return redirect('');
        }
        $time = NULL;
        $repetition = NULL;
        if (isset($_POST['repetition'])) {
            $repetition = htmlspecialchars($_POST['repetition']);
        } else {
            $time = htmlspecialchars($_POST['time']);
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
