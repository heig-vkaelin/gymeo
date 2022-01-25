<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Requêtes se rapportant aux Utilisateurs
 */

namespace App\Repositories;

use PDO;

class UsersRepository extends Repository
{
    public function getAllUsers()
    {
        $this->queryExecute('
            SELECT utilisateur.id, utilisateur.pseudonyme, utilisateur.datenaissance
            FROM utilisateur
            ORDER BY utilisateur.id
        ');

        return $this->fetchAll();
    }

    /**
     * Try to find a user to login with
     */
    public function findUser($username)
    {
        $query = "
            SELECT
                id, pseudonyme, dateNaissance
            FROM Utilisateur
            WHERE pseudonyme = :username
        ";

        $this->prepareExecute($query, [
            'username' => [
                'value' => $username,
                'type' => PDO::PARAM_STR
            ]
        ]);

        return $this->fetchOne();
    }
}
