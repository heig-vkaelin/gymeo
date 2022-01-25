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
        $query = '
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
            ORDER BY
                séance.datedébut DESC;
        ';

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
     * @param number $userId
     * @param number $sessionId
     */
    public function getSeriesById($userId, $sessionId)
    {
        $query = '
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
                programme.idutilisateur = :userId
                AND séance.id = :sessionId
                AND séance.datefin IS NULL
        ';
        $this->prepareExecute($query, [
            'userId' => [
                'value' => $userId,
                'type' => PDO::PARAM_INT
            ],
            'sessionId' => [
                'value' => $sessionId,
                'type' => PDO::PARAM_INT
            ]
        ]);
        return $this->fetchAll();
    }

    /**
     * Crée une nouvelle série dans la base de données
     *
     * @param number $sessionId
     * @param number $exerciceId
     * @param number $nbReps : potentiel nombre de répétitions
     * @param number $time : potentiel temps d'exécution
     * @param number $weight : potentiel poids utilisé
     */
    public function createSerie($sessionId, $exerciceId, $nbReps, $time, $weight)
    {
        $query = '
            INSERT INTO Série (%s %s idSéance, idExercice) VALUES
            (%s %s :sessionId,:exerciceId)
        ';
        $data = [
            'sessionId' => [
                'value' => $sessionId,
                'type' => PDO::PARAM_INT
            ],
            'exerciceId' => [
                'value' => $exerciceId,
                'type' => PDO::PARAM_INT
            ]
        ];
        $poids = '';
        $poidsVal = '';
        // Si le poids est renseigné par l'utilisateur
        if ($weight != NULL) {
            $poids = 'poids,';
            $poidsVal = ':poids,';
            $data['poids'] = [
                'value' => $weight,
                'type' => PDO::PARAM_INT
            ];
        }

        // Si c'est un exercice avec un nombre de répétitions
        if (isset($nbReps)) {
            $query = sprintf($query, 'nbRépétitions,', $poids, ':nbReps,', $poidsVal);
            $data['nbReps'] = [
                'value' => $nbReps,
                'type' => PDO::PARAM_INT
            ];
        }
        // Si c'est un exercice avec un temps d'exécution
        else {
            $query = sprintf($query, 'tempsExécution,', $poids, ':time,', $poidsVal);
            $data['time'] = [
                'value' => $time,
                'type' => PDO::PARAM_INT
            ];
        }
        $this->prepareExecute($query, $data);
        $this->closeCursor();
    }
}
