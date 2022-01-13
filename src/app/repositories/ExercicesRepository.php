<?php

namespace App\Repositories;

class ExercicesRepository extends Repository
{
    public function TMP_getAllExercices()
    {
        $this->queryExecute('
            SELECT Exercice.nom, Exercice.difficulté, Exercice.idMatériel,
             Matériel.nom as Matériel
            FROM Exercice
            LEFT JOIN Matériel
            ON Exercice.idMatériel = Matériel.id
        ');
        return $this->fetchAll();
    }
}
