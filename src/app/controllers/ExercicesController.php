<?php

namespace App\Controllers;

use App\Core\App;

class ExercicesController
{
    public function index()
    {
        $exercices = App::get('exercices-repository')->TMP_getAllExercices();

        return view('exercices/index', compact('exercices'));
    }

    public function show()
    {
        if (!isset($_GET['id'])) {
            return redirect('');
        }

        // $result = App::get('exercices-repository')->getOneExercice($_GET['id']);
        $exercice = (object)[];

        return view('exercices/show', compact('exercice'));
    }
}
