<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Controller gérant les Programmes
 */

namespace App\Controllers;

use App\Core\App;
use Exception;

class ProgramsController
{
    // Temps de pause par défaut entre 2 séries d'exercice
    const DEFAULT_BREAK_TIME = 30;

    /**
     * Liste les programmes de l'utilisateur connecté
     *
     * @param object $user potentiel utilisateur connecté
     */
    public function index($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $programs = App::get('programs-repository')->getAllProgramsOfUser($user['id']);

        return view('programs/index', compact('programs'));
    }

    /**
     * Affiche les détails d'un programme (sa liste d'exercices)
     *
     * @param object $user potentiel utilisateur connecté
     */
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

    /**
     * Formulaire permettant de créer un nouveau programme
     *
     * @param object $user potentiel utilisateur connecté
     */
    public function create($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $exercices = App::get('exercices-repository')->getAllExercices();

        return view('programs/create', compact('exercices'));
    }

    /**
     * Supprime un programme
     *
     * @param object $user potentiel utilisateur connecté
     */
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

    /**
     * Enregistre un nouveau programme dans la base de données
     *
     * @param object $user potentiel utilisateur connecté
     */
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

        foreach ($_POST['exercices'] as $index => $id) {
            $exerciceIndex = array_search($id, array_column($exercices, 'id'));
            $exercice = $exercices[$exerciceIndex];
            $data = [];
            $data['idExercice'] = intval($id);
            $data['nbSeries'] = $exercice['nbsériesconseillé'];
            $data['breakTime'] = self::DEFAULT_BREAK_TIME;
            $data['order'] = $index + 1;
            $exercicesPopulated[] = $data;
        }

        $programName = htmlspecialchars($_POST['programName']);

        $idProgram = App::get('programs-repository')->createProgram(
            $user['id'],
            $programName,
            $exercicesPopulated
        );

        if ($idProgram)
            return redirect('programs/edit?idProgram=' . $idProgram);

        return redirect('programs/create');
    }

    /**
     * Formulaire permettant de modifier un programme
     *
     * @param object $user potentiel utilisateur connecté
     */
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

    /**
     * Enregistre les modifications apportées à un programme dans la base de données
     *
     * @param object $user potentiel utilisateur connecté
     */
    public function update($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        $idProgram = htmlspecialchars($_POST['idprogramme'][0]);

        // Tri des exercices par ordre
        $exercices = [];
        for ($i = 0; $i < count($_POST['idexercice']); $i++) {
            $exercices[] = [
                'idExercice' => htmlspecialchars($_POST['idexercice'][$i]),
                'idProgram' => $idProgram,
                'nbSeries' => htmlspecialchars($_POST['nbséries'][$i]),
                'breakTime' => htmlspecialchars($_POST['tempspause'][$i]),
                'order' => htmlspecialchars($_POST['ordre'][$i]),
            ];
        }
        usort($exercices, function ($a, $b) {
            return $a['order'] - $b['order'];
        });

        try {
            App::get('database')->beginTransaction();

            // Supprime les états potentiels des exercices
            App::get('programs-repository')->deleteExercicesFromProgram($user['id'], $idProgram);

            // Modifie chaque exercice lié au programme 
            foreach ($exercices as $exercice) {
                App::get('programs-repository')->addExerciceToProgram($exercice);
            }

            App::get('database')->commit();
        } catch (Exception $e) {
            if (App::get('database')->inTransaction())
                App::get('database')->rollback();
            return redirect('programs/edit?idProgram=' . $idProgram);
        }

        return redirect('program?id=' . $idProgram);
    }
}
