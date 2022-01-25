<?php

namespace App\Repositories;

use PDO;

class ProgramsRepository extends Repository
{
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

    public function createProgram($userId, $programName, $exercices)
    {
        // Programme
        $programQuery = '
            INSERT into Programme
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
            INSERT into Programme_Exercice
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

    public function getLightProgramsOfUser($userId)
    {
        $query = '
            SELECT
                id, nom, idUtilisateur 
            FROM
                Programme 
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
