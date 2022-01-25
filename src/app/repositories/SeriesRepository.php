<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Requêtes se rapportant aux Séries
 */

namespace App\Repositories;

use PDO;

class SeriesRepository extends Repository
{
    /**
     * Récupère les séries réalisées par un utilisateur
     *
     * @param number $userId
     */
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

    /**
     * Récupère les séries réalisées lors d'une séance
     *
     * @param number $userid
     * @param number $sessionid
     */
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
        return $this->fetchAll();
    }

    /**
     * Crée une nouvelle série dans la base de données
     *
     * @param number $sessionid
     * @param number $exerciceid
     * @param number $nbrep
     * @param number $time
     * @param number $weight
     */
    public function createSerie($sessionid, $exerciceid, $nbrep, $time, $weight)
    {
        $query = "
        INSERT INTO Série (%s %s idSéance, idExercice) VALUES
        (%s %s :session_id,:exercice_id)";
        $data = [
            'session_id' => [
                'value' => $sessionid,
                'type' => PDO::PARAM_INT
            ],
            'exercice_id' => [
                'value' => $exerciceid,
                'type' => PDO::PARAM_INT
            ]
        ];
        $poids = "";
        $poidsVal = "";
        if ($weight != NULL) {
            $poids = "poids,";
            $poidsVal = ":poids,";
            $data['poids'] = [
                'value' => $weight,
                'type' => PDO::PARAM_INT
            ];
        }

        if (isset($nbrep)) {
            $query = sprintf($query, "nbRépétitions,", $poids, ":nbrep,", $poidsVal);
            $data['nbrep'] = [
                'value' => $nbrep,
                'type' => PDO::PARAM_INT
            ];
        } else {
            $query = sprintf($query, "tempsExécution,", $poids, ":time,", $poidsVal);
            $data['time'] = [
                'value' => $time,
                'type' => PDO::PARAM_INT
            ];
        }
        $this->prepareExecute($query, $data);
        $this->closeCursor();
    }
}
