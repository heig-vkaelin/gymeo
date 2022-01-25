<?php

namespace App\Repositories;

use PDO;

class SessionsRepository extends Repository
{
    public function getSessionsUser($userid)
    {
        $query = "
            SELECT
                programme.id AS idprogramme, programme.nom, séance.datedébut, séance.datefin, séance.id
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

    public function createSession($infos)
    {
        $query = "
        INSERT INTO séance (datedébut, idprogramme)
                VALUES(:date, :idprogramme);";

        date_default_timezone_set('Europe/Zurich');
        $this->prepareExecute($query, [
            'date' => [
                'value' => date("Y-m-d H:i:s"),
                'type' => PDO::PARAM_STR
            ],
            'idprogramme' => [
                'value' => $infos,
                'type' => PDO::PARAM_INT
            ]
        ]);
        $idSession = $this->getLastInsertId();
        $this->closeCursor();
        return $idSession;
    }
    public function endSession($userid, $sessionid)
    {
        $query = "
        INSERT INTO séance (datedébut, idprogramme)
                VALUES(:date, :idprogramme);";

        date_default_timezone_set('Europe/Zurich');
        $this->prepareExecute($query, [
            'date' => [
                'value' => date("Y-m-d H:i:s"),
                'type' => PDO::PARAM_STR
            ],
            'idprogramme' => [
                'value' => $userid,
                'type' => PDO::PARAM_INT
            ]
        ]);
        $idSession = $this->getLastInsertId();
        $this->closeCursor();
        return $idSession;
    }
}
