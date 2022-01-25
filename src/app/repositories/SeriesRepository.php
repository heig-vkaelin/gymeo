<?php

namespace App\Repositories;

use PDO;

class SeriesRepository extends Repository
{
    public function getSeriesBySession($userId, $sessionId)
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
                séance.id = :sessionId AND
                programme.idutilisateur = :userId
        ";

        $this->prepareExecute($query, [
            'sessionId' => [
                'value' => $sessionId,
                'type' => PDO::PARAM_INT
            ],
            'userId' => [
                'value' => $userId,
                'type' => PDO::PARAM_INT
            ]
        ]);

        return $this->fetchAll();
    }

    public function getSeriesByUser($userId)
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
                programme.idutilisateur = :userId
            ORDER BY séance.datedébut DESC;
        ";

        $this->prepareExecute($query, [
            'userId' => [
                'value' => $userId,
                'type' => PDO::PARAM_INT
            ]
        ]);

        $series = $this->fetchAll();

        $orderedByExercice = [];

        foreach ($series as $serie) {
            // TODO: IL FAUT ORDER PAR DATE ET INDIQUER LA DATE
            $orderedByExercice[$serie['nomexercice']][] = $serie;
        }

        return $orderedByExercice;
    }

    public function getSeriesById($userid, $sessionid)
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
                programme.idutilisateur = :userid
                AND séance.id = :sessionid
                AND séance.datefin IS NULL
        ";
        $this->prepareExecute($query, [
            'userid' => [
                'value' => $userid,
                'type' => PDO::PARAM_INT
            ],
            'sessionid' => [
                'value' => $sessionid,
                'type' => PDO::PARAM_INT
            ]
        ]);

        $series = $this->fetchAll();
        return $series;
    }

    public function createSerie($sessionid, $exerciceid, $nbrep, $time, $weight)
    {
        $query = "
        INSERT INTO Série (nbrépétitions, poids, idSéance, idExercice) VALUES
        (:nbrep,:weight,:session_id,:exercice_id)";

        $this->prepareExecute($query, [
            'nbrep' => [
                'value' => $nbrep,
                'type' => PDO::PARAM_INT
            ],
            'weight' => [
                'value' => $weight,
                'type' => PDO::PARAM_INT
            ],
            'session_id' => [
                'value' => $sessionid,
                'type' => PDO::PARAM_INT
            ],
            'exercice_id' => [
                'value' => $exerciceid,
                'type' => PDO::PARAM_INT
            ],
        ]);
        $this->closeCursor();
    }
}
