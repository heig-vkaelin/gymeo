<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Controller gérant les Exercices
 */

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
        if (!empty($_GET)) {
            if (isset($_GET['location']) && $_GET['location'] != '-1')
                $location = htmlspecialchars($_GET['location']);
            if (isset($_GET['muscle']) && $_GET['muscle'] != '-1')
                $muscle = htmlspecialchars($_GET['muscle']);
            if (isset($_GET['material']) && $_GET['material'] != '-1')
                $material = filter_var($_GET['material'], FILTER_VALIDATE_BOOLEAN);
        }

        $exercices = App::get('exercices-repository')->getFilteredExercices(
            $location,
            $material,
            $muscle
        );

        return view('exercices/index', compact('exercices', 'locations', 'muscles'));
    }

    public function show()
    {
        // Redirection si l'id de l'exercice n'est pas envoyé
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
