<?php

namespace App\Controllers;

use App\Core\App;

class SeriesController
{
    public function seriesOfSession($user)
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

        return view('series/seriesOfSession', compact('series'));
    }
}
