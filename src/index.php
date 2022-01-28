<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Premier fichier appelé, appelle le bootstrap du site
 */

require 'vendor/autoload.php';
require 'core/bootstrap.php';

use App\Core\{Router, Request};

// Charge les routes de l'application
Router::load('app/routes.php')
    ->direct(Request::uri(), Request::method());
