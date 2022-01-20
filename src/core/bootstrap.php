<?php

/**
 * ETML
 * Author: Valentin Kaelin
 * Date: 21.11.2019
 * Description: Bootstrap the website
 */

use App\Core\App;
use App\Core\Database\{Database};
use App\Repositories\{ExercicesRepository, ProgramsRepository, SeriesRepository, SessionsRepository, UsersRepository};

session_start();

App::bind('config', require 'config.php');

App::bind('database', new Database(App::get('config')['database']));

App::bind('exercices-repository', new ExercicesRepository(App::get('database')));
App::bind('programs-repository', new ProgramsRepository(App::get('database')));
App::bind('sessions-repository', new SessionsRepository(App::get('database')));
App::bind('series-repository', new SeriesRepository(App::get('database')));
App::bind('users-repository', new UsersRepository(App::get('database')));
