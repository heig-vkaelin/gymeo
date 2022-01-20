<?php

namespace App\Repositories;

use PDO;

class SeriesRepository extends Repository
{
    public function getSeriesBySession($userid, $programmid)
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
                programme.id = :programmid AND
                programme.idutilisateur = :userid

            ";
            

        $this->prepareExecute($query, [
            'programmid' => [
                'value' => $programmid,
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
}
