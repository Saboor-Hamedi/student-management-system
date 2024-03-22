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
        // Clear all session variables
        session_unset();
        // Destroy the session
        session_destroy();
        // Redirect the user to the desired location
        header("Location: /");
        exit();
    }
}