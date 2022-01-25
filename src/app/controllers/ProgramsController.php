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

        $programs = App::get('programs-repository')->getAllProgramsOfUser($user['id']);

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

        $exercices = App::get('exercices-repository')->getAllExercices();

        return view('programs/create', compact('exercices'));
    }

    public function delete($user)
    {
        // Redirect if the user is not logged or if no exerices are sent
        if (
            empty($user)
        ) {
            return redirect('');
        }

        if (!isset($_GET['id'])) {
            return redirect('');
        }


        App::get('programs-repository')->deleteProgram(
            $user['id'],
            $_GET['id']
        );

        redirect('programs');
    }

    public function store($user)
    {
        // Redirect if the user is not logged or if no exerices are sent
        if (
            empty($user) || !isset($_POST['exercices']) ||
            count($_POST['exercices']) == 0
        ) {
            return redirect('');
        }

        // Récupération du nombre de séries conseillées comme valeurs par défaut
        $exercices = App::get('exercices-repository')->getAllExercices();
        $exercicesPopulated = [];

        foreach ($_POST['exercices'] as $index => $id) {
            $exerciceIndex = array_search($id, array_column($exercices, 'id'));
            $exercice = $exercices[$exerciceIndex];
            $data = (object)null;
            $data->id = intval($id);
            $data->nbSériesConseillé = $exercice['nbsériesconseillé'];
            $data->ordre = $index + 1;
            $data->tempsPause = self::DEFAULT_BREAK_TIME; // 30s par défaut
            $exercicesPopulated[] = $data;
        }

        $programName = htmlspecialchars($_POST['programName'] ?? '');

        $idProgram = App::get('programs-repository')->createProgram(
            $user['id'],
            $programName,
            $exercicesPopulated
        );

        return redirect('programs/edit?idProgram=' . $idProgram);
    }

    public function edit($user)
    {
        // Redirect if the user is not logged or if program is not set
        if (empty($user) || !isset($_GET['idProgram'])) {
            return redirect('');
        }

        $program = App::get('programs-repository')->getProgram($user['id'], htmlspecialchars($_GET['idProgram']));

        return view('programs/edit', compact('program'));
    }

    public function update($user)
    {
        if (empty($user)) {
            return redirect('');
        }

        for ($i = 0; $i < count($_POST['idexercice']); $i++) {
            App::get('programs-repository')->confirmProgramExercice(
                htmlspecialchars($_POST['idexercice'][$i]),
                htmlspecialchars($_POST['idprogramme'][$i]),
                htmlspecialchars($_POST['nbséries'][$i]),
                htmlspecialchars($_POST['tempspause'][$i]),
                htmlspecialchars($_POST['ordre'][$i])
            );
        }

        // TODO: redirect sur la page show une fois créée
        return redirect('programs');
    }
}
