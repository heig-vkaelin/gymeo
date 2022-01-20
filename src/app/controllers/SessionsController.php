<?php

namespace App\Controllers;

use App\Core\App;

class SessionsController
{
    public function index($user)
    {
        // Redirect if the user is not logged
        if (empty($user)) {
            return redirect('');
        }

        // $result = App::get('programs-repository')->getOneProgram($user['id'], $_GET['id']);
        $sessions = App::get('sessions-repository')->getSessionsUser($user['id']);

        return view('sessions/index', compact('sessions'));
    }
}
