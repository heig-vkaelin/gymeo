<?php

/**
 * ETML
 * Author: Valentin Kaelin
 * Date: 21.11.2019
 * Description: All routes of the website
 */

// Auth
$router->post('login', 'UsersController@login');
$router->get('logout', 'UsersController@logout');

//  Exercices
$router->get('exercices', 'ExercicesController@index');
$router->get('exercice', 'ExercicesController@show');

// Programs
$router->get('programs', 'ProgramsController@index');
$router->get('program', 'ProgramsController@show');
$router->get('program/delete', 'ProgramsController@delete');
$router->get('programs/create', 'ProgramsController@create');
$router->post('programs', 'ProgramsController@store');
$router->get('programs/edit', 'ProgramsController@edit');
$router->post('programs/update', 'ProgramsController@update');

// Sessions
$router->get('sessions', 'SessionsController@index');
$router->get('session', 'SessionsController@show');
$router->get('sessions/create', 'SessionsController@create');
$router->post('sessions', 'SessionsController@store');
$router->post('sessions/end', 'SessionsController@end');

// Series
$router->get('series', 'SeriesController@seriesOfSession');
$router->get('series/user', 'SeriesController@index');
$router->get('series/create', 'SeriesController@create');
$router->post('series', 'SeriesController@store');


// Users
$router->get('', 'TeachersController@index');



// Old ETML project
$router->get('teachers', 'TeachersController@show');
$router->get('teachers/create', 'TeachersController@create');
$router->post('teachers', 'TeachersController@store');
$router->get('teachers/edit', 'TeachersController@edit');
$router->post('teachers/update', 'TeachersController@update');
$router->get('teachers/delete', 'TeachersController@delete');
$router->post('teachers/vote', 'TeachersController@vote');

$router->post('nicknames', 'NicknamesController@store');
$router->post('nicknames/update', 'NicknamesController@update');
