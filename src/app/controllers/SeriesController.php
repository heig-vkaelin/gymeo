<?php

namespace App\Controllers;

use App\Core\App;

class SeriesController
{
    public function show($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            return redirect('exercices');
        }

        $id = intval($_GET['id']);

        // $result = App::get('programs-repository')->getOneProgram($user['id'], $_GET['id']);
        $series = App::get('series-repository')->getSeriesBySession($user['id'], $id);

        return view('series/show', compact('series'));
    }

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
        $exercices = App::get('exercices-repository')->getAllExercices();

        return view('series/create', compact('series', 'exercices'));
    }
}
