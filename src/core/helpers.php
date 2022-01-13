<?php

/**
 * ETML
 * Author: Valentin Kaelin
 * Date: 21.11.2019
 * Description: Global helpers functions
 */

/**
 * Require a view.
 *
 * @param  string $name : name of the view
 * @param  array  $data : data to pass to the view
 */
function view($name, $data = [])
{
    // Data from the Controller
    extract($data);

    // Logged User
    $user = $_SESSION['user'] ?? null;
    $logged = !empty($user);

    require "app/views/partials/header.php";
    require "app/views/{$name}.view.php";
    require "app/views/partials/footer.php";
}

/**
 * Redirect to a new page.
 *
 * @param  string $path : path of the new page
 */
function redirect($path)
{
    header("Location: /{$path}");
}

/**
 * Die and debug: kill the process to debug and dump the selected variable
 *
 * @param * $variable to display
 */
function dd($variable)
{
    die(var_dump($variable));
}
