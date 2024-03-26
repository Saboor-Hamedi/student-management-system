<?php

namespace Thesis\config;

class Auth
{
    const HOME_PATH = 'http://localhost:8888/views/home.php';

    public static function authenticate(array $allowedRoles = [])
    {
        // Start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            // User is not logged in, redirect to the login page
            self::redirect("/");
        }

        // Check if allowedRoles is an array
        if (!is_array($allowedRoles)) {
            throw new \InvalidArgumentException("Allowed roles must be provided as an array");
        }

        // Check if user's role is allowed to access the page
        $roles = $_SESSION['roles'];
        if (!empty($allowedRoles) && !in_array($roles, $allowedRoles)) {
            // User's role is not allowed to access the page, redirect to home.php
            self::redirect(self::HOME_PATH);
        }
    }

    public static function logoutGuard()
    {
        // Start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            // User is already logged in, redirect to home.php
            self::redirect(self::HOME_PATH);
        }
    }

    private static function redirect(string $url)
    {
        // Ensure that output buffering is turned on before calling header
        if (!headers_sent()) {
            header("Location: " . $url);
            exit();
        } else {
            // Handle the case where headers have already been sent
            echo "<script>window.location.replace('$url');</script>";
            exit();
        }
    }
}

// ================= you can use this as well:

// namespace Thesis\config;

// class Auth
// {
//     const HOME_PATH = 'http://localhost:8888/views/home.php';

//     public static function authenticate($allowedRoles = [])
//     {

//         if (!isset($_SESSION['user_id'])) {
//             // User is not logged in, redirect to the login page
//             header("Location: /");
//             exit();
//         }

//         // User is logged in, check if their role is allowed to access the page
//         $roles = $_SESSION['roles'];
//         if (!in_array($roles, $allowedRoles)) {
//             // User's role is not allowed to access the page, redirect to home.php
//             header("Location: " . self::HOME_PATH);
//             exit();
//         }
//     }

//     public static function logoutGuard()
//     {
//         // Check if the user is logged in
//         if (isset($_SESSION['user_id'])) {
//             // User is already logged in, redirect to home.php
//             header("Location: " . self::HOME_PATH);
//             exit();
//         }
//     }
// }
