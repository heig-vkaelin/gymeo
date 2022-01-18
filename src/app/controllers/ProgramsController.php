<?php

namespace App\Controllers;

use App\Core\App;

class ProgramsController
{
    // Temps de pause par défaut entre 2 séries d'exercice
    const DEFAULT_BREAK_TIME = 30;

    public function index($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        // $programs = App::get('programs-repository')->getAllprograms($user['id']);
        $programs = [];

        return view('programs/index', compact('programs'));
    }

    public function show($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        if (!isset($_GET['id'])) {
            return redirect('');
        }

        // $result = App::get('programs-repository')->getOneProgram($user['id'], $_GET['id']);
        $program = (object)[];

        return view('programs/show', compact('program'));
    }

    public function create($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        $exercices = App::get('exercices-repository')->TMP_getAllExercices();

        return view('programs/create', compact('exercices'));
    }

    public function store($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        // Récupération du nombre de séries conseillées comme valeurs par défaut
        $exercices = App::get('exercices-repository')->TMP_getAllExercices();
        $exercicesPopulated = [];

        foreach ($_POST['exercices'] as $index => $id) {
            $exerciceIndex = array_search($id, array_column($exercices, 'id'));
            $exercice = $exercices[$exerciceIndex];
            $data = (object)null;
            $data->id = $id;
            $data->nbSériesConseillé = $exercice['nbsériesconseillé'];
            $data->ordre = $index + 1;
            $data->tempsPause = self::DEFAULT_BREAK_TIME; // 30s par défaut

            // if ($exercice['tempsexécutionconseillé']) {
            //     $data->recommandation = $exercice['tempsexécutionconseillé'];
            //     $data->recommandationLabel = 'tempsexécutionconseillé';
            // } else {
            //     $data->recommandation = $exercice['nbrépétitionsconseillé'];
            //     $data->recommandationLabel = 'nbrépétitionsconseillé';
            // }
            $exercicesPopulated[] = $data;
        }

        dd($exercicesPopulated);

        // TODO: insert program + insert many programme_exercice

        $programName = htmlspecialchars($_POST['programName'] ?? '');
        // $lastName = htmlspecialchars($_POST['lastName'] ?? '');
        // $gender = !empty($_POST['gender']) ? htmlspecialchars($_POST['gender']) : 'Z';
        // $sections = $_POST['sections'] ?? [];
        // $nickname =  htmlspecialchars($_POST['nickname'] ?? '');
        // $origin =  htmlspecialchars($_POST['origin'] ?? '');

        // App::get('programs-repository')->createProgram([
        //     'programName' => $programName,
        //     // 'lastName' => $lastName,
        // ]);
        redirect('programs');
    }
}
