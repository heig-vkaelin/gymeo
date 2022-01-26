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
     * Connecte un utilisateur (POST)
     */
    public function login()
    {
        $username = htmlspecialchars($_POST['user'] ?? '');

        // Vérifie que l'utilisateur existe dans la DB
        $userFromDB = App::get('users-repository')->findUser($username);
        $userExists = !empty($userFromDB);

        if ($userExists) {
            // Stocke l'utilisateur dans la session
            $_SESSION['user'] = [
                'id' => $userFromDB['id'],
                'user' => $userFromDB['pseudonyme'],
                'dateNaissance' => $userFromDB['datenaissance'],
            ];

            // Si l'utilisateur s'est déconnecté et qu'il n'avait pas fini sa session
            $currentSession = App::get('sessions-repository')->userHasCurrentSession($userFromDB['id']);
            if ($currentSession) {
                $_SESSION['user']['currentSession'] = $currentSession['id'];
            }
        }

        return redirect('');
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout($user)
    {
        // Redirection si l'utilisateur n'est pas connecté
        if (empty($user)) {
            return redirect('');
        }

        session_destroy();

        return redirect('');
    }
}
