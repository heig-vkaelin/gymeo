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
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            return redirect('exercices');
        }

        $id = intval($_GET['id']);
        $exercice = App::get('exercices-repository')->getOneExercice($id);

        if ($exercice)
            return view('exercices/show', compact('exercice'));
        
        return redirect('exercices');
    }
}
