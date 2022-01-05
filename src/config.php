<?php

/**
 * ETML
 * Author: Valentin Kaelin
 * Date: 21.11.2019
 * Description: Database connection config
 */

return [
    'database' => [
        'name' => 'gymeo',
        'username' => 'root',
        'password' => 'root',
        'connection' => 'pgsql:host=127.0.0.1',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];
