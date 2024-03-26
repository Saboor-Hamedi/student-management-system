<?php

namespace Thesis\controllers;

class Logout
{
    public static function logout()
    {
        session_start();
        // Unset specific session variables
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        // Set session cookie lifetime to 0 (destroy on close)
        ini_set('session.cookie_lifetime', 0);
        // Clear all session variables
        session_unset();
        // Destroy the session
        session_destroy();
        // Redirect the user to the desired location
        header("Location: /");
        exit();
    }
}

