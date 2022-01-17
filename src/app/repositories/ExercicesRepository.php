<?php

namespace App\Repositories;

use PDO;

class ExercicesRepository extends Repository
{
    public function TMP_getAllExercices()
    {
        $this->queryExecute('
            SELECT
                Exercice.nom, Exercice.difficulté, Exercice.idMatériel,
                Matériel.nom as Matériel
            FROM Exercice
            LEFT JOIN Matériel
                ON Exercice.idMatériel = Matériel.id
        ');
        return $this->fetchAll();
    }

    public function getOneExercice($name)
    {
        $query = "
            SELECT
                Exercice.nom, Exercice.description, Exercice.nbSériesConseillé,
                Exercice.nbRépétitionsConseillé, Exercice.tempsExécutionConseillé, 
                Exercice.difficulté, Exercice.idMatériel, Matériel.nom AS nomMatériel,
                Matériel.description AS descriptionMatériel
            FROM Exercice
            LEFT JOIN Matériel
                ON Exercice.idMatériel = Matériel.id
            WHERE Exercice.nom = :name
        ";

        // LEFT JOIN Exercice_Lieu
        //     ON Matériel.nom = Exercice_Lieu.nomExercice
        // LEFT JOIN Lieu
        //     ON Exercice_Lieu.nomLieu = Lieu.nom

        $this->prepareExecute($query, [
            'name' => [
                'value' => $name,
                'type' => PDO::PARAM_STR
            ]
        ]);

        return $this->fetchOne();
    }
}
