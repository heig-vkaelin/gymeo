<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Initie l'application web
 */

use App\Core\App;
use App\Core\Database\{Database};
use App\Repositories\{ExercicesRepository, ProgramsRepository, SeriesRepository, SessionsRepository, UsersRepository};

session_start();

// Réglages globaux
date_default_timezone_set('Europe/Zurich');
setlocale(LC_TIME, 'fr_FR', 'french', 'French_France.1252', 'fr_FR.ISO8859-1', 'fra', 'fr_FR.utf8');

// Stockage des instances des différents singletons accessibles dans toute l'application
App::bind('config', require 'config.php');

App::bind('database', new Database(App::get('config')['database']));

App::bind('exercices-repository', new ExercicesRepository(App::get('database')));
App::bind('programs-repository', new ProgramsRepository(App::get('database')));
App::bind('sessions-repository', new SessionsRepository(App::get('database')));
App::bind('series-repository', new SeriesRepository(App::get('database')));
App::bind('users-repository', new UsersRepository(App::get('database')));
