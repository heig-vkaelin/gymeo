<?php

/**
 * ETML
 * Author: Valentin Kaelin
 * Date: 12.12.2019
 * Description: Controller for the users' sessions (login/logout)
 */

namespace App\Controllers;

use App\Core\App;

class UsersController
{
    /**
     * Login a user (POST)
     */
    public function login()
    {
        $username = htmlspecialchars($_POST['user'] ?? '');

        // Check if user exists in db
        $userFromDB = App::get('users-repository')->findUser($username);
        $userExists = !empty($userFromDB);

        if ($userExists) {
            // Store user in Session
            $_SESSION['user'] = [
                'id' => $userFromDB['id'],
                'user' => $userFromDB['pseudonyme'],
                'dateNaissance' => $userFromDB['datenaissance'],
            ];
        }

        return redirect('');
    }

    /**
     * Logout the logged user
     */
    public function logout($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        session_destroy();

        return redirect('');
    }
}
