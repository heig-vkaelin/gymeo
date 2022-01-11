<?php

namespace App\Repositories;

use App\Core\App;
use PDO;

class UsersRepository extends Repository
{
    public function getAllUsers()
    {
        $this->db->queryExecute('
            SELECT utilisateur.id, utilisateur.pseudonyme, utilisateur.datenaissance
            FROM utilisateur
            ORDER BY utilisateur.id
        ');

        $result = $this->db->fetchAll();
        $this->db->closeCursor();
        return $result;
    }

    /**
     * Try to find a user to login with
     */
    public function findUser($username) 
    {
        $query = "
            SELECT id, pseudonyme, dateNaissance
            FROM Utilisateur
            WHERE pseudonyme = :username
        ";

        $this->db->prepareExecute($query, [
            'username' => [
                'value' => $username,
                'type' => PDO::PARAM_STR
            ]
        ]);

        $result = $this->db->fetchOne();
        $this->db->closeCursor();
        return $result;
    }
}
