<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Requêtes se rapportant aux Exercices
 */

namespace App\Repositories;

use PDO;

class ExercicesRepository extends Repository
{
    /**
     * Récupère tous les lieux possibles pour les exercices
     */
    public function getAllLocations()
    {
        $this->queryExecute('
            SELECT
                nom
            FROM Lieu
        ');

        return $this->fetchAll();
    }

    /**
     * Récupère tous les groupements musculaires possibles pour les exercices
     */
    public function getAllMuscles()
    {
        $this->queryExecute('
            SELECT
                id, nom
            FROM GroupementMusculaire
        ');

        return $this->fetchAll();
    }

    /**
     * Récupère tous les exercices
     */
    public function getAllExercices()
    {
        return $this->getFilteredExercices(NULL, NULL, NULL);
    }

    /**
     * Récupère les exercices selon les filtres appliqués
     *
     * @param number $location
     * @param number $material
     * @param number $muscle
     */
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
                Exercice_lieu.idExercice = Exercice.id\n";
            $filters .= " AND nomLieu = :nomLocation";
            $data['nomLocation'] = [
                'value' => $location,
                'type' => PDO::PARAM_STR
            ];
        }
        if (isset($material))
            $filters .= " AND idmatériel IS " . ($material ? "NOT" : "") . " NULL";

        if (isset($muscle)) {
            $query .= "\nINNER JOIN Exercice_GroupementMusculaire ON
            Exercice_GroupementMusculaire.idExercice = Exercice.id\n";
            $filters .= " AND idgroupementmusculaire = :idMuscle";
            $data['idMuscle'] = [
                'value' => $muscle,
                'type' => PDO::PARAM_INT
            ];
        }

        $query .= $filters;
        $this->prepareExecute($query, $data);

        return $this->fetchAll();
    }

    /**
     * Récupère les détails d'un exercices en particulier
     *
     * @param number $id
     */
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
                Exercice_Lieu.nomLieu = Lieu.nom
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

    /**
     * Récupère les exercices d'une séance
     *
     * @param number $userId
     * @param number $sessionId
     */
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
