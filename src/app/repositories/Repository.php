<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Met à disposition des fonctions faciliant les requêtes avec la base de données
 */

namespace App\Repositories;

abstract class Repository
{
    protected $db;

    /**
     * Stocke une référence vers l'instance de la classe permettant de communiquer avec la base de données
     *
     * @param Database $database
     */
    function __construct($database)
    {
        $this->db = $database;
    }

    /**
     * Exécute une requête qui n'a pas besoin d'être protégée
     *
     * @param string $query
     */
    function queryExecute($query)
    {
        return $this->db->queryExecute($query);
    }

    /**
     * Prépare et exécute une requête afin d'éviter les injections SQL
     *
     * @param string $query
     * @param array $params
     */
    function prepareExecute($query, $params)
    {
        return $this->db->prepareExecute($query, $params);
    }

    /**
     * Vide le jeu de documents
     */
    function closeCursor()
    {
        return $this->db->closeCursor();
    }

    /**
     * Récupère toutes les résultats d'une requête
     */
    function fetchAll()
    {
        $result = $this->db->fetchAll();
        $this->closeCursor();
        return $result;
    }

    /**
     * Récupère un résultat d'une requête
     */
    function fetchOne()
    {
        $result = $this->db->fetchOne();
        $this->closeCursor();
        return $result;
    }

    /**
     * Retourne le dernier id inséré dans la base de données
     */
    function getLastInsertId()
    {
        return $this->db->getLastInsertId();
    }
}
