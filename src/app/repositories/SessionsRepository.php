<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Requêtes se rapportant aux Séances
 */

namespace App\Repositories;

use PDO;

class SessionsRepository extends Repository
{
    /**
     * Retourne les séances d'un utilisateur
     *
     * @param number $userId
     */
    public function getSessionsOfUser($userId)
    {
        $query = '
            SELECT
                Programme.id AS idProgramme, Programme.nom, Séance.dateDébut, Séance.dateFin, Séance.id
            FROM
                Séance
            INNER JOIN
                Programme ON
                Séance.idProgramme = Programme.id
            WHERE
                idUtilisateur = :userId
            ORDER BY
                Séance.datedébut DESC
        ';

        $this->prepareExecute($query, [
            'userId' => [
                'value' => $userId,
                'type' => PDO::PARAM_INT
            ]
        ]);

        return $this->fetchAll();
    }

    /**
     * Récupère les détails d'une séance
     *
     * @param number $userId
     * @param number $sessionId
     */
    public function getSession($userId, $sessionId)
    {
        $query = '
            SELECT DISTINCT
                Séance.dateDébut,
                Série.id, Série.nbRépétitions, Série.tempsExécution, Série.poids,
                Exercice.nom AS nomExercice, Programme_Exercice.tempsPause
            FROM
                Séance
            LEFT JOIN
                Série
            ON
                Séance.id = Série.idSéance 
            INNER JOIN
                Programme
            ON
                Séance.idProgramme = Programme.id
            LEFT JOIN
                Exercice ON
                Série.idExercice = Exercice.id
            LEFT JOIN
                Programme_Exercice
            ON
                Programme.id = Programme_Exercice.idProgramme
            AND
                Exercice.id = Programme_Exercice.idExercice
            WHERE
                Séance.id = :sessionId AND
                Programme.idUtilisateur = :userId
        ';

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

    /**
     * Récupère le nombre de séries réalisé par un utilisateur lors d'une séance en cours
     *
     * @param number $userId
     * @param number $sessionId
     */
    public function getNbSeriesOfCurrentSession($userId, $sessionId)
    {
        $query = '
            SELECT
                COUNT(*) AS nbSéries
            FROM
                Série
            INNER JOIN
                Séance ON
                Série.idSéance = Séance.id
            INNER JOIN
                Programme ON
                Séance.idProgramme = Programme.id
            WHERE
                Programme.idUtilisateur = :userId
                AND Séance.id = :sessionId
                AND Séance.dateFin IS NULL
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
        return $this->fetchOne();
    }

    /**
     * Crée une nouvelle séance dans la base de données
     *
     * @param number $programId
     */
    public function createSession($programId)
    {
        $query = '
            INSERT INTO Séance (dateDébut, idProgramme)
            VALUES(:date, :programId);
        ';

        $this->prepareExecute($query, [
            'date' => [
                'value' => date("Y-m-d H:i:s"),
                'type' => PDO::PARAM_STR
            ],
            'programId' => [
                'value' => $programId,
                'type' => PDO::PARAM_INT
            ]
        ]);

        $idSession = $this->getLastInsertId();
        $this->closeCursor();

        return $idSession;
    }

    /**
     * Termine une séance
     *
     * @param number $userId
     * @param number $sessionId
     */
    public function endSession($sessionId)
    {
        // TODO: A FAIRE
        $query = '
            UPDATE Séance SET dateFin = :date WHERE id = :sessionId;
        ';

        $this->prepareExecute($query, [
            'date' => [
                'value' => date('Y-m-d H:i:s'),
                'type' => PDO::PARAM_STR
            ],
            'sessionId' => [
                'value' => $sessionId,
                'type' => PDO::PARAM_INT
            ]
        ]);

        $this->closeCursor();
    }
}
