<?php

namespace App\Repositories;

use App\Core\App;

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
}
