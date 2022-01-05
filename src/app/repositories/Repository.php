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
}
