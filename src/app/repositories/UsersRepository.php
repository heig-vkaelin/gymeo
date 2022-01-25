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
    /**
     * Cherche un utilisateur par son pseudonyme
     *
     * @param string $username
     */
    public function findUser($username)
    {
        $query = '
            SELECT
                id, pseudonyme, dateNaissance
            FROM
                Utilisateur
            WHERE
                pseudonyme = :username
        ';

        $this->prepareExecute($query, [
            'username' => [
                'value' => $username,
                'type' => PDO::PARAM_STR
            ]
        ]);

        return $this->fetchOne();
    }
}
