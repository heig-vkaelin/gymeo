<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Controller pour les sessions Utilisateurs
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
