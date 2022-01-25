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
            SELECT
                Séance.dateDébut,
                Série.nbRépétitions, Série.tempsExécution, Série.poids,
                Exercice.nom AS nomExercice
            FROM
                Série
            INNER JOIN
                Séance ON
                Série.idséance = Séance.id
            INNER JOIN
                Programme ON
                Séance.idprogramme = Programme.id
            INNER JOIN
                Exercice ON
                Série.idexercice = Exercice.id
            WHERE
                Séance.id = :sessionId AND
                Programme.idutilisateur = :userId
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
    public function endSession($userId, $sessionId)
    {
        // TODO: A FAIRE
        $query = '
            INSERT INTO Séance (dateDébut, idProgramme)
            VALUES(:date, :idProgramme);
        ';

        $this->prepareExecute($query, [
            'date' => [
                'value' => date('Y-m-d H:i:s'),
                'type' => PDO::PARAM_STR
            ],
            'idProgramme' => [
                'value' => $userId,
                'type' => PDO::PARAM_INT
            ]
        ]);

        $idSession = $this->getLastInsertId();
        $this->closeCursor();

        return $idSession;
    }
}
