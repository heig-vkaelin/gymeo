<?php

/**
 * ETML
 * Author: Valentin Kaelin
 * Date: 21.11.2019
 * Description: Database connection config
 */

return [
    'database' => [
        'name' => 'db_nickname_valkalin',
        'username' => 'dbNicknameUser',
        'password' => '.Etml-',
        'connection' => 'mysql:host=127.0.0.1',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];
