<?php

namespace App\Repositories;

use PDO;

class SeriesRepository extends Repository
{
    public function getSeriesBySession($userid, $seanceid)
    {
        $query = "
            SELECT
                série.nbrépétitions, série.tempsexécution, série.poids, exercice.nom AS nomexercice
            FROM
                série
            INNER JOIN
                séance ON
                série.idséance = séance.id
            INNER JOIN
                programme ON
                séance.idprogramme = programme.id
            INNER JOIN
                exercice ON
                série.idexercice = exercice.id
            WHERE
                séance.id = :seanceid AND
                programme.idutilisateur = :userid

            ";
            

        $this->prepareExecute($query, [
            'seanceid' => [
                'value' => $seanceid,
                'type' => PDO::PARAM_INT
            ],
            'userid' => [
                'value' => $userid,
                'type' => PDO::PARAM_INT
            ]
        ]);

        return $this->fetchAll();

        //Récupérer les séances avec les ids de programmes puis return le résultat
    }

    public function getSeriesByUser($userid)
    {
        $query = "
            SELECT
                série.nbrépétitions, série.tempsexécution, série.poids, exercice.nom AS nomexercice, séance.datedébut, séance.datefin
            FROM
                série
            INNER JOIN
                séance ON
                série.idséance = séance.id
            INNER JOIN
                programme ON
                séance.idprogramme = programme.id
            INNER JOIN
                exercice ON
                série.idexercice = exercice.id
            WHERE
                programme.idutilisateur = :userid

            ";
            

        $this->prepareExecute($query, [
            'userid' => [
                'value' => $userid,
                'type' => PDO::PARAM_INT
            ]
        ]);

        $series = $this->fetchAll();

        $orderedByExercice = [];

        foreach($series as $serie){
            // On stock 2x le nom exercice !!!
            //IL FAUT ORDER PAR DATE ET INDIQUER LA DATE
            $orderedByExercice[$serie['nomexercice']][] = $serie;
        }

        return $orderedByExercice;

        //Récupérer les séances avec les ids de programmes puis return le résultat
    }
}
