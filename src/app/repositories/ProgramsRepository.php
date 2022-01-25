<?php

namespace App\Repositories;

use PDO;

class ProgramsRepository extends Repository
{
    public function createProgram($userId, $programName, $exercices)
    {
        // Programme
        $programQuery = "
            INSERT into Programme
            (nom, idUtilisateur)
            VALUES (:name, :userId)
        ";

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
        $exercieQuery = "
            INSERT into Programme_Exercice
            (idExercice, idProgramme, tempsPause, nbSéries, ordre)
            VALUES (:idExercice, :idProgramme, :tempsPause, :nbSeries, :ordre)
        ";
        foreach ($exercices as $exercice) {
            $this->prepareExecute($exercieQuery, [
                'idExercice' => [
                    'value' => $exercice->id,
                    'type' => PDO::PARAM_INT
                ],
                'idProgramme' => [
                    'value' => $idProgram,
                    'type' => PDO::PARAM_INT
                ],
                'tempsPause' => [
                    'value' => $exercice->tempsPause,
                    'type' => PDO::PARAM_INT
                ],
                'nbSeries' => [
                    'value' => $exercice->nbSériesConseillé,
                    'type' => PDO::PARAM_INT
                ],
                'ordre' => [
                    'value' => $exercice->ordre,
                    'type' => PDO::PARAM_INT
                ]
            ]);
        }
        $this->closeCursor();
    }

    public function deleteProgram($idUser, $idProgram){
        $query = "DELETE 
        FROM programme 
        WHERE programme.idutilisateur = :idUser AND programme.id = :idProgram";

        $this->prepareExecute($query, [
            'idUser' => [
                'value' => $idUser,
                'type' => PDO::PARAM_INT
            ],
            'idProgram' => [
                'value' => $idProgram,
                'type' => PDO::PARAM_INT
            ]
        ]);

        $this->closeCursor();
    }

    public function getAllProgramsOfUser($idUser)
    {
        $query = "SELECT * 
        FROM programme 
        WHERE programme.idutilisateur = :id";

        $this->prepareExecute($query, [
            'id' => [
                'value' => $idUser,
                'type' => PDO::PARAM_INT
            ]
        ]);
        return $this->fetchAll();
    }
}
