<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Controller gérant les Programmes
 */

namespace App\Controllers;

use App\Core\App;

class ProgramsController
{
    // Temps de pause par défaut entre 2 séries d'exercice
    const DEFAULT_BREAK_TIME = 30;

    public function index($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $programs = App::get('programs-repository')->getAllProgramsOfUser($user['id']);

        return view('programs/index', compact('programs'));
    }

    public function show($user)
    {
        // Redirection si l'utilisateur n'est pas connecté ou que l'id du programme
        // à afficher n'est pas envoyé
        if (empty($user) || !isset($_GET['id'])) {
            return redirect('');
        }

        $program = App::get('programs-repository')->getProgram($user['id'], htmlspecialchars($_GET['id']));

        return view('programs/show', compact('program'));
    }

    public function create($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $exercices = App::get('exercices-repository')->getAllExercices();

        return view('programs/create', compact('exercices'));
    }

    public function delete($user)
    {
        // Redirection si l'utilisateur n'est pas connecté ou que l'id du programme
        // à supprimer n'est pas envoyé
        if (empty($user) || !isset($_GET['id'])) {
            return redirect('');
        }

        App::get('programs-repository')->deleteProgram(
            $user['id'],
            htmlspecialchars($_GET['id'])
        );

        redirect('programs');
    }

    public function store($user)
    {
        // Redirection si l'utilisateur n'est pas connecté ou si aucun exercice
        // n'est envoyé
        if (
            empty($user) ||
            trim($_POST['programName']) == '' ||
            !isset($_POST['exercices']) ||
            count($_POST['exercices']) == 0
        ) {
            return redirect('');
        }

        // Récupération du nombre de séries conseillées comme valeurs par défaut
        $exercices = App::get('exercices-repository')->getAllExercices();
        $exercicesPopulated = [];


        // TODO: ne pas leur filer un ordre de base => champ à foutre NULLABLE

        foreach ($_POST['exercices'] as $index => $id) {
            $exerciceIndex = array_search($id, array_column($exercices, 'id'));
            $exercice = $exercices[$exerciceIndex];
            $data = (object)null;
            $data->id = intval($id);
            $data->nbSériesConseillé = $exercice['nbsériesconseillé'];
            $data->ordre = $index + 1;
            $data->tempsPause = self::DEFAULT_BREAK_TIME;
            $exercicesPopulated[] = $data;
        }

        $programName = htmlspecialchars($_POST['programName']);

        $idProgram = App::get('programs-repository')->createProgram(
            $user['id'],
            $programName,
            $exercicesPopulated
        );

        return redirect('programs/edit?idProgram=' . $idProgram);
    }

    public function edit($user)
    {
        // Redirection si l'utilisateur n'est pas connecté ou si l'id
        // du programme à modifier n'est pas envoyé
        if (empty($user) || !isset($_GET['idProgram'])) {
            return redirect('');
        }

        $program = App::get('programs-repository')->getProgram($user['id'], htmlspecialchars($_GET['idProgram']));

        return view('programs/edit', compact('program'));
    }

    public function update($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $idProgram = htmlspecialchars($_POST['idprogramme'][0]);

        // TODO: on ordre les exos par "ordre" pour le trigger

        // Modifie chaque exercice lié au programme 
        for ($i = 0; $i < count($_POST['idexercice']); $i++) {
            App::get('programs-repository')->confirmProgramExercice(
                htmlspecialchars($_POST['idexercice'][$i]),
                $idProgram,
                htmlspecialchars($_POST['nbséries'][$i]),
                htmlspecialchars($_POST['tempspause'][$i]),
                htmlspecialchars($_POST['ordre'][$i])
            );
        }

        return redirect('program?id=' . $idProgram);
    }
}
