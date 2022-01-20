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

    public function TMP_getAllExercices()
    {
        $this->queryExecute('
            SELECT
                Exercice.id, Exercice.nom, Exercice.difficulté, Exercice.idMatériel, Exercice.nbsériesconseillé,
                Exercice.nbRépétitionsConseillé, Exercice.tempsExécutionConseillé,
                Matériel.nom as Matériel
            FROM Exercice
            LEFT JOIN Matériel
                ON Exercice.idMatériel = Matériel.id
        ');
        return $this->fetchAll();
    }

    public function getAllExercices($location, $material, $muscle)
    {
        $query = "
        SELECT Exercice.id, Exercice.nom, Exercice.difficulté, Exercice.idMatériel, Exercice.nbsériesconseillé,
        Exercice.nbRépétitionsConseillé, Exercice.tempsExécutionConseillé, Matériel.nom as Matériel
        FROM Exercice
        LEFT JOIN Matériel ON
            Exercice.idmatériel = Matériel.id";
        $filter = " WHERE TRUE";
        $data = [];
        if (isset($location)) {
            $query .= "\nINNER JOIN Exercice_lieu ON
            Exercice_lieu.idexercice = Exercice.id\n";
            $filter .= " AND idlieu = :idlocation";
            $data['idlocation'] = [
                'value' => $location,
                'type' => PDO::PARAM_INT
            ];
        }
        if (isset($material))
            $filter .= " AND idmatériel IS " . ($material ? "NOT" : "") . " NULL";

        if (isset($muscle)) {
            $query .= "\nINNER JOIN Exercice_groupementmusculaire ON
            Exercice_groupementmusculaire.idexercice = Exercice.id\n";
            $filter .= " AND idgroupementmusculaire = :idmuscle";
            $data['idmuscle'] = [
                'value' => $muscle,
                'type' => PDO::PARAM_INT
            ];
        }
        $query .= $filter;
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
                Matériel.description AS descriptionMatériel
            FROM Exercice
            LEFT JOIN Matériel
                ON Exercice.idMatériel = Matériel.id
            WHERE Exercice.id = :id
        ";

        // LEFT JOIN Exercice_Lieu
        //     ON Matériel.nom = Exercice_Lieu.nomExercice
        // LEFT JOIN Lieu
        //     ON Exercice_Lieu.nomLieu = Lieu.nom

        $this->prepareExecute($query, [
            'id' => [
                'value' => $id,
                'type' => PDO::PARAM_INT
            ]
        ]);

        return $this->fetchOne();
    }
}
