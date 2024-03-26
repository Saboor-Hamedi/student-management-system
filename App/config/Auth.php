<?php

namespace Thesis\config;

class Auth
{
    const HOME_PATH = 'http://localhost:8888/views/home.php';

    public static function isLogged($allowedRoles = [])
    {

        if (!isset($_SESSION['user_id'])) {
            // User is not logged in, redirect to the login page
            header("Location: /");
            exit();
        }

        // User is logged in, check if their role is allowed to access the page
        $roles = $_SESSION['roles'];
        if (!in_array($roles, $allowedRoles)) {
            // User's role is not allowed to access the page, redirect to home.php
            header("Location: " . self::HOME_PATH);
            exit();
        }
    }

    public static function check_loggedout()
    {
        // Check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            // User is already logged in, redirect to home.php
            header("Location: " . self::HOME_PATH);
            exit();
        }
    }
}
