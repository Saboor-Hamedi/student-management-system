<?php

namespace Thesis\controllers;

use Exception;

/**
 * Summary of Login
 */
class Login
{
    /**
     * Summary of database
     * @var 
     */
    private $database;

    /**
     * Summary of __construct
     * @param mixed $database
     */
    public function __construct($database)
    {
        $this->database = $database;
    }

    /**
     * Summary of loginUser
     * @param mixed $email
     * @param mixed $password
     * @return array<string>
     */
    public function loginUser($email, $password)
    {
        try {
            // Input validation
            if (empty ($email) || empty ($password)) {
                throw new Exception('Email and password are required');
            }

            $sql = "SELECT * FROM users WHERE email = :email";
            $params = [
                'email' => $email,
            ];
            $result = $this->database->query($sql, $params);
            if (!empty ($result)) {
                $user = $result[0];
                $storedPassword = $user['password'];
                if (password_verify($password, $storedPassword)) {
                    $this->removePassword($user);
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['roles'] = $user['roles'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: ../views/home.php");
                    exit();
                }
            }

            // Invalid credentials
            throw new Exception('Invalid username or password');
        } catch (Exception $e) {
            // Handle the exception
            $errors['login'] = $e->getMessage();
            return $errors;
        }
    }

    public function getUserId()
    {
        return $_SESSION['user_id'];
    }
  


    private function removePassword(&$user)
    {
        unset($user['password']);
    }
}