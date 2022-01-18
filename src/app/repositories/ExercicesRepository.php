<?php

namespace App\Repositories;

use PDO;

class ExercicesRepository extends Repository
{
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
