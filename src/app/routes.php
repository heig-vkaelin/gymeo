<?php

/**
 * ETML
 * Author: Valentin Kaelin
 * Date: 21.11.2019
 * Description: All routes of the website
 */

$router->get('', 'TeachersController@index');
$router->get('teachers', 'TeachersController@show');
$router->get('teachers/create', 'TeachersController@create');
$router->post('teachers', 'TeachersController@store');
$router->get('teachers/edit', 'TeachersController@edit');
$router->post('teachers/update', 'TeachersController@update');
$router->get('teachers/delete', 'TeachersController@delete');
$router->post('teachers/vote', 'TeachersController@vote');

$router->post('nicknames', 'NicknamesController@store');
$router->post('nicknames/update', 'NicknamesController@update');

$router->post('login', 'UsersController@login');
$router->get('logout', 'UsersController@logout');
