<?php

namespace App\Repositories;

use App\Core\App;

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
}
