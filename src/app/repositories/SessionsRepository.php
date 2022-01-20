<?php

namespace App\Repositories;

use PDO;

class SessionsRepository extends Repository
{
    public function getSessionsUser($userid)
    {
        $query = "
            SELECT
                programme.id AS idprogramme, programme.nom, séance.datedébut, séance.datefin
            FROM
                séance
            INNER JOIN
                programme ON
                séance.idprogramme = programme.id
            WHERE
                idutilisateur = :userid";
            

        $this->prepareExecute($query, [
            'userid' => [
                'value' => $userid,
                'type' => PDO::PARAM_INT
            ]
        ]);

        return $this->fetchAll();

        //Récupérer les séances avec les ids de programmes puis return le résultat
    }
}
