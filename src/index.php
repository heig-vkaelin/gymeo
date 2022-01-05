<?php

/**
 * ETML
 * Author: Valentin Kaelin
 * Date: 21.11.2019
 * Description: First launched file of the website, call the bootstrap
 */

require 'vendor/autoload.php';
require 'core/bootstrap.php';

use App\Core\{Router, Request};

// Load routes
Router::load('app/routes.php')
    ->direct(Request::uri(), Request::method());
