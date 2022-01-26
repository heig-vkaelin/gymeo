<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Requêtes se rapportant aux Programmes
 */

namespace App\Repositories;

use PDO;

class ProgramsRepository extends Repository
{
    /**
     * Récupère les détails d'un programme
     *
     * @param number $userId
     * @param number $programId
     */
    public function getProgram($userId, $programId)
    {
        $query = '
            SELECT
                Programme.id AS idProgramme, Programme.nom AS nomProgramme,
                Exercice.id AS idExercice, Exercice.nom AS nomExercice,
                Programme_Exercice.tempsPause, Programme_Exercice.nbSéries, Programme_Exercice.ordre
            FROM
                Programme 
            INNER JOIN
                Programme_Exercice
            ON
                Programme.id = Programme_Exercice.idProgramme
            INNER JOIN
                Exercice
            ON
                Programme_Exercice.idExercice = Exercice.id
            WHERE
                programme.idutilisateur = :userId
                AND programme.id = :programId
            ORDER BY
                Programme_Exercice.ordre ASC
        ';

        $this->prepareExecute($query, [
            'userId' => [
                'value' => $userId,
                'type' => PDO::PARAM_INT
            ],
            'programId' => [
                'value' => $programId,
                'type' => PDO::PARAM_INT
            ]
        ]);
        return $this->fetchAll();
    }

    /**
     * Crée un nouveau programme dans la base de données
     *
     * @param number $userId
     * @param string $programName
     * @param array $exercices
     */
    public function createProgram($userId, $programName, $exercices)
    {
        // Programme
        $programQuery = '
            INSERT INTO Programme
            (nom, idUtilisateur)
            VALUES (:name, :userId)
        ';

        $this->prepareExecute($programQuery, [
            'name' => [
                'value' => $programName,
                'type' => PDO::PARAM_STR
            ],
            'userId' => [
                'value' => $userId,
                'type' => PDO::PARAM_INT
            ]
        ]);

        // Programme_Exercice
        $idProgram = $this->getLastInsertId();
        $exercieQuery = '
            INSERT INTO Programme_Exercice
            (idExercice, idProgramme, tempsPause, nbSéries, ordre)
            VALUES (:exerciceId, :programId, :breakTime, :nbSeries, :order)
        ';
        foreach ($exercices as $exercice) {
            $this->prepareExecute($exercieQuery, [
                'exerciceId' => [
                    'value' => $exercice->id,
                    'type' => PDO::PARAM_INT
                ],
                'programId' => [
                    'value' => $idProgram,
                    'type' => PDO::PARAM_INT
                ],
                'breakTime' => [
                    'value' => $exercice->tempsPause,
                    'type' => PDO::PARAM_INT
                ],
                'nbSeries' => [
                    'value' => $exercice->nbSériesConseillé,
                    'type' => PDO::PARAM_INT
                ],
                'order' => [
                    'value' => $exercice->ordre,
                    'type' => PDO::PARAM_INT
                ]
            ]);
        }

        $this->closeCursor();
        return $idProgram;
    }

    /**
     * Supprime un programme de la base de données
     *
     * @param number $userId
     * @param number $programId
     */
    public function deleteProgram($userId, $programId)
    {
        $query = '
            DELETE 
            FROM
                Programme 
            WHERE
                Programme.idutilisateur = :userId
                AND Programme.id = :programId
        ';

        $this->prepareExecute($query, [
            'userId' => [
                'value' => $userId,
                'type' => PDO::PARAM_INT
            ],
            'programId' => [
                'value' => $programId,
                'type' => PDO::PARAM_INT
            ]
        ]);

        $this->closeCursor();
    }

    /**
     * Récupère les informations essentielles des programmes contenant au moins un exercice créés par un utilisateur donné
     * 
     * @param number $userId
     */
    public function getLightProgramsOfUser($userId)
    {
        $query = '
            SELECT DISTINCT
                id, nom, idUtilisateur 
            FROM
                Programme 
            INNER JOIN Programme_Exercice ON
                Programme.id = Programme_Exercice.idProgramme
            WHERE
                Programme.idUtilisateur = :userId

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
     * Récupère toutes les informations des programmes créés par un utilisateur
     *
     * @param number $userId
     */
    public function getAllProgramsOfUser($userId)
    {
        $query = "
            SELECT
                Programme.id, Programme.nom, COUNT(*) AS nbExercices, string_agg(Exercice.nom, ', ') AS Exercices
            FROM
                Programme 
            LEFT JOIN 
                Programme_Exercice
            ON
                Programme.id = Programme_Exercice.idProgramme
            LEFT JOIN 
                Exercice
            ON
                Programme_Exercice.idExercice = Exercice.id
            WHERE
                Programme.idUtilisateur = :userId
            GROUP BY
                Programme.id
        ";

        $this->prepareExecute($query, [
            'userId' => [
                'value' => $userId,
                'type' => PDO::PARAM_INT
            ]
        ]);
        return $this->fetchAll();
    }

    /**
     * Valide la création d'un nouveau programme en assignant un exercice au programme
     *
     * @param number $exerciceId
     * @param number $programId
     * @param number $nbSeries
     * @param number $breakTime
     * @param number $order
     */
    public function confirmProgramExercice($exerciceId, $programId, $nbSeries, $breakTime, $order)
    {
        $query = '
            UPDATE
                Programme_Exercice
            SET
                nbSéries = :nbSeries,
                tempsPause = :breakTime,
                ordre = :order
            WHERE
                idExercice = :exerciceId
                AND idProgramme = :programId
        ';

        $this->prepareExecute($query, [
            'nbSeries' => [
                'value' => $nbSeries,
                'type' => PDO::PARAM_INT
            ],
            'breakTime' => [
                'value' => $breakTime,
                'type' => PDO::PARAM_INT
            ],
            'order' => [
                'value' => $order,
                'type' => PDO::PARAM_INT
            ],
            'exerciceId' => [
                'value' => $exerciceId,
                'type' => PDO::PARAM_INT
            ],
            'programId' => [
                'value' => $programId,
                'type' => PDO::PARAM_INT
            ]
        ]);

        $this->closeCursor();
    }
}
