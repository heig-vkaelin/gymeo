<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Requêtes se rapportant aux Programmes
 */

namespace App\Repositories;

use Exception;
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
     * Ajoute un exercice à un programme
     *
     * @param object $exercice
     */
    public function addExerciceToProgram($exercice)
    {
        $query = '
            INSERT INTO Programme_Exercice
            (idExercice, idProgramme, tempsPause, nbSéries, ordre)
            VALUES (:exerciceId, :programId, :breakTime, :nbSeries, :order)
        ';

        $this->prepareExecuteUnsafe($query, [
            'exerciceId' => [
                'value' => $exercice['idExercice'],
                'type' => PDO::PARAM_INT
            ],
            'programId' => [
                'value' => $exercice['idProgram'],
                'type' => PDO::PARAM_INT
            ],
            'breakTime' => [
                'value' => $exercice['breakTime'],
                'type' => PDO::PARAM_INT
            ],
            'nbSeries' => [
                'value' => $exercice['nbSeries'],
                'type' => PDO::PARAM_INT
            ],
            'order' => [
                'value' => $exercice['order'],
                'type' => PDO::PARAM_INT
            ],
        ]);

        $this->closeCursor();
    }

    /**
     * Crée un nouveau programme dans la base de données avec ses différents exercices liés
     * 
     * Si une erreur se produit, annule toutes les insertions grâce à une transaction
     *
     * @param number $userId
     * @param string $programName
     * @param array $exercices
     */
    public function createProgram($userId, $programName, $exercices)
    {
        try {
            $this->db->beginTransaction();

            // Programme
            $programQuery = '
                INSERT INTO Programme
                (nom, idUtilisateur)
                VALUES (:name, :userId)
            ';

            $this->prepareExecuteUnsafe($programQuery, [
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
            foreach ($exercices as $exercice) {
                $exercice['idProgram'] = $idProgram;
                $this->addExerciceToProgram($exercice);
            }

            $this->db->commit();
            $this->closeCursor();
            return $idProgram;
        } catch (Exception $e) {
            if ($this->db->inTransaction())
                $this->db->rollback();
        }
        return NULL;
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
                Programme.idUtilisateur = :userId
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
            INNER JOIN
                Programme_Exercice
            ON
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
     * Supprime les exercices liés à un programme
     *
     * @param number $userId
     * @param number $programId
     */
    public function deleteExercicesFromProgram($userId, $programId)
    {
        $query = '
            DELETE
            FROM
                Programme_Exercice
            WHERE Programme_Exercice.idProgramme IN
            (
                SELECT
                    PE.idProgramme
                FROM
                    Programme_Exercice PE
                INNER JOIN
                    Programme
                ON
                    PE.idProgramme = Programme.id
                WHERE Programme.idUtilisateur = :userId
                AND Programme_Exercice.idProgramme = :programId
            )
        ';

        $this->prepareExecuteUnsafe($query, [
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
}
