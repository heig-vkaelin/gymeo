<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Définition de toutes les routes du site web
 */

// Auth
$router->post('login', 'UsersController@login');
$router->get('logout', 'UsersController@logout');

// Exercices
$router->get('exercices', 'ExercicesController@index');
$router->get('exercice', 'ExercicesController@show');

// Programmes
$router->get('programs', 'ProgramsController@index');
$router->get('program', 'ProgramsController@show');
$router->get('program/delete', 'ProgramsController@delete');
$router->get('programs/create', 'ProgramsController@create');
$router->post('programs', 'ProgramsController@store');
$router->get('programs/edit', 'ProgramsController@edit');
$router->post('programs/update', 'ProgramsController@update');

// Séances
$router->get('sessions', 'SessionsController@index');
$router->get('session', 'SessionsController@show');
$router->get('sessions/create', 'SessionsController@create');
$router->post('sessions', 'SessionsController@store');
$router->post('sessions/end', 'SessionsController@end');

// Séries
$router->get('series', 'SeriesController@index');
$router->get('series/create', 'SeriesController@create');
$router->post('series', 'SeriesController@store');

// Page d'accueil et toute page inconnue: liste des exercices
$router->get('', 'ExercicesController@index');
