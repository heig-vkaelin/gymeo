<?php

namespace App\Repositories;

use PDO;

class ProgramsRepository extends Repository
{
    public function createProgram($infos)
    {
        // TODO
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
