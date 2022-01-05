<?php

/**
 * ETML
 * Author: Valentin Kaelin
 * Date: 21.11.2019
 * Description: Bootstrap the website
 */

use App\Core\App;
use App\Core\Database\{Database};

session_start();

App::bind('config', require 'config.php');

App::bind('database', new Database(App::get('config')['database']));
