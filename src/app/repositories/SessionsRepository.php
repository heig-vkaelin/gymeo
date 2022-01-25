<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Requêtes se rapportant aux Séances
 */

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
                idutilisateur = :userid
            ORDER BY séance.datedébut DESC";
        $this->prepareExecute($query, [
            'userid' => [
                'value' => $userid,
                'type' => PDO::PARAM_INT
            ]
        ]);

        return $this->fetchAll();

        //Récupérer les séances avec les ids de programmes puis return le résultat
    }

    public function getSession($userId, $sessionId)
    {
        $query = '
            SELECT
                Séance.dateDébut,
                Série.nbRépétitions, Série.tempsExécution, Série.poids,
                Exercice.nom AS nomExercice
            FROM
                Série
            INNER JOIN
                Séance ON
                Série.idséance = Séance.id
            INNER JOIN
                Programme ON
                Séance.idprogramme = Programme.id
            INNER JOIN
                Exercice ON
                Série.idexercice = Exercice.id
            WHERE
                Séance.id = :sessionId AND
                Programme.idutilisateur = :userId
        ';

        $this->prepareExecute($query, [
            'sessionId' => [
                'value' => $sessionId,
                'type' => PDO::PARAM_INT
            ],
            'userId' => [
                'value' => $userId,
                'type' => PDO::PARAM_INT
            ]
        ]);

        return $this->fetchAll();
    }

    public function createSession($infos)
    {
        $query = "
        INSERT INTO séance (datedébut, idprogramme)
                VALUES(:date, :idprogramme);";

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
