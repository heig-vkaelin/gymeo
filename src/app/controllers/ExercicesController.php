<?php

namespace App\Controllers;

use App\Core\App;

class ExercicesController
{
    public function index()
    {
        $locations = App::get('exercices-repository')->getAllLocations();
        $muscles = App::get('exercices-repository')->getAllMuscles();

        $location = NULL;
        $muscle = NULL;
        $material = NULL;

        // Recherche avec des filtres appliqués
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['location']) && $_POST['location'] != '-1')
                $location = $_POST['location'];
            if (isset($_POST['muscle']) && $_POST['muscle'] != '-1')
                $muscle = $_POST['muscle'];
            if (isset($_POST['material']) && $_POST['material'] != '-1')
                $material = filter_var($_POST['material'], FILTER_VALIDATE_BOOLEAN);
        }

        $exercices = App::get('exercices-repository')->getAllExercices(
            $location,
            $material,
            $muscle
        );

        return view('exercices/index', compact('exercices', 'locations', 'muscles'));
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
