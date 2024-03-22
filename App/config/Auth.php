<?php

namespace Thesis\config;

class Auth
{
    public static function isLogged($allowedRoles = [])
    {
        if (isset ($_SESSION['user_id'])) {
            // User is logged in, retrieve the user's role from the session
            $roles = $_SESSION['roles'];

            // Check if the user's role is allowed to access the page
            if (in_array($roles, $allowedRoles)) {
                // User has the required role, allow access
                return; // Allow execution to continue
            } else {
                // User's role is not allowed to access the page
                // Redirect to an unauthorized page or display an error message
                // logout();
                header("Location: /public/views/home.php");
                exit();
            }
        } else {
            // User is not logged in, redirect to the index.php or login page
            header("Location: /");
            exit();
        }
    }

    public static function check_loggedout()
    {
        // Check if the user is not logged in
        if (isset ($_SESSION['user_id'])) {
            // User is already logged in, redirect to home.php
            header("Location: ../public/views/home.php");
            exit();
        }
    }
}