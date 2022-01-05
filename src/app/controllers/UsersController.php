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
        $password = htmlspecialchars($_POST['password'] ?? '');

        // Check user exists in db
        $userFromDB = App::get('database')->findUser($username);
        $userExists = !empty($userFromDB);

        if ($userExists && password_verify($password, $userFromDB[0]['useHashedPass'])) {
            // Store user in Session
            $_SESSION['user'] = [
                'id' => $userFromDB[0]['idUser'],
                'user' => $userFromDB[0]['useUsername'],
                'role' => $userFromDB[0]['useRole'],
                'votes' => $userFromDB[0]['useVotes'],
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
