<?php

namespace App\Controllers;

use App\Core\App;

class ExercicesController
{
    public function index()
    {
        if (!isset($_GET['id'])) {
            return redirect('');
        }

        // $exercices = App::get('exercices-repository')->getAllExercices();
        $exercices = [];

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
