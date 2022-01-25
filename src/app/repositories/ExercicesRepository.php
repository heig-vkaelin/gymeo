<?php

namespace App\Repositories;

use PDO;

class ExercicesRepository extends Repository
{
    public function getAllLocations()
    {
        $this->queryExecute('
            SELECT
                id, nom
            FROM Lieu
        ');

        return $this->fetchAll();
    }

    public function getAllMuscles()
    {
        $this->queryExecute('
            SELECT
                id, nom
            FROM GroupementMusculaire
        ');

        return $this->fetchAll();
    }

    public function getAllExercices()
    {
        return $this->getFilteredExercices(NULL, NULL, NULL);
    }

    public function getFilteredExercices($location, $material, $muscle)
    {
        $query = "
            SELECT
                Exercice.id, Exercice.nom, Exercice.difficulté, Exercice.idMatériel,
                Exercice.nbsériesconseillé, Exercice.nbRépétitionsConseillé,
                Exercice.tempsExécutionConseillé, Matériel.nom as Matériel
            FROM
                Exercice
            LEFT JOIN
                Matériel
            ON
                Exercice.idmatériel = Matériel.id
        ";
        $filters = " WHERE TRUE";
        $data = [];
        if (isset($location)) {
            $query .= "\nINNER JOIN Exercice_lieu ON
                Exercice_lieu.idexercice = Exercice.id\n";
            $filters .= " AND idlieu = :idlocation";
            $data['idlocation'] = [
                'value' => $location,
                'type' => PDO::PARAM_INT
            ];
        }
        if (isset($material))
            $filters .= " AND idmatériel IS " . ($material ? "NOT" : "") . " NULL";

        if (isset($muscle)) {
            $query .= "\nINNER JOIN Exercice_groupementmusculaire ON
            Exercice_groupementmusculaire.idexercice = Exercice.id\n";
            $filters .= " AND idgroupementmusculaire = :idmuscle";
            $data['idmuscle'] = [
                'value' => $muscle,
                'type' => PDO::PARAM_INT
            ];
        }

        $query .= $filters;
        $this->prepareExecute($query, $data);

        return $this->fetchAll();
    }

    public function getOneExercice($id)
    {
        $query = "
            SELECT
                Exercice.id, Exercice.nom, Exercice.description, Exercice.nbSériesConseillé,
                Exercice.nbRépétitionsConseillé, Exercice.tempsExécutionConseillé, 
                Exercice.difficulté, Exercice.idMatériel, Matériel.nom AS nomMatériel,
                Matériel.description AS descriptionMatériel,
                string_agg(Lieu.nom, ', ') as Lieux
            FROM
                Exercice
            LEFT JOIN
                Matériel
            ON
                Exercice.idMatériel = Matériel.id
            LEFT JOIN
                Exercice_Lieu
            ON
                Exercice.id = Exercice_Lieu.idExercice
            LEFT JOIN
                Lieu
            ON
                Exercice_Lieu.idLieu = Lieu.id
            WHERE
                Exercice.id = :id
            GROUP BY
                Exercice.id, Matériel.id
        ";



        $this->prepareExecute($query, [
            'id' => [
                'value' => $id,
                'type' => PDO::PARAM_INT
            ]
        ]);

        return $this->fetchOne();
    }

    public function getExercicesBySession($userId, $sessionId)
    {
        $query = '
            SELECT
                Exercice.id, Exercice.nom, Exercice.nbRépétitionsConseillé,
                Exercice.tempsExécutionConseillé
            FROM
                Exercice
            INNER JOIN
                Programme_Exercice
            ON 
                Programme_Exercice.idExercice = Exercice.id
            INNER JOIN
                Programme
            ON 
                Programme_Exercice.idProgramme = Programme.id
            INNER JOIN
                Séance
            ON 
                Programme.id = Séance.idProgramme
            WHERE
                Séance.id = :sessionId
                AND Programme.idUtilisateur = :userId
            ORDER BY
                Programme_Exercice.ordre ASC
        ';

        $this->prepareExecute($query, [
            'userId' => [
                'value' => $userId,
                'type' => PDO::PARAM_INT
            ], 'sessionId' => [
                'value' => $sessionId,
                'type' => PDO::PARAM_INT
            ]
        ]);
        return $this->fetchAll();
    }
}
