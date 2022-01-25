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

    function __construct($database)
    {
        $this->db = $database;
    }

    function queryExecute($query)
    {
        return $this->db->queryExecute($query);
    }

    function prepareExecute($query, $params)
    {
        return $this->db->prepareExecute($query, $params);
    }

    function closeCursor()
    {
        return $this->db->closeCursor();
    }

    function fetchAll()
    {
        $result = $this->db->fetchAll();
        $this->closeCursor();
        return $result;
    }

    function fetchOne()
    {
        $result = $this->db->fetchOne();
        $this->closeCursor();
        return $result;
    }

    function getLastInsertId()
    {
        return $this->db->getLastInsertId();
    }
}
