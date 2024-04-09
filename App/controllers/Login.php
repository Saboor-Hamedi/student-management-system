<?php

namespace Thesis\controllers;

use Exception;
use Thesis\config\Database;
use Thesis\config\Validation;
use Thesis\functions\InputUtils;

class Login
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = InputUtils::sanitizeInput($_POST['username'] ?? '', 'email');
        $password = InputUtils::sanitizeInput($_POST['password'] ?? '', 'string');
        $validate = new Validation();
        $errors = $this->validateInput($validate, $username, $password);

        if (!empty($errors)) {
            return $errors;
        }

        return $this->login($username, $password);
    }

    private function validateInput($validate, $username, $password): array
    {
        $errors = [];
        $errors['username'] = $this->validateUserName($validate, $username);
        $errors['password'] = $this->validatePassword($validate, $password);
        return array_filter($errors);
    }

    private function validateUserName($validate, $username)
    {
        $rules = [
            ['required', 'Email is required'],
        ];
        return $validate->email($username, $rules);
    }

    private function validatePassword($validate, $password)
    {
        $rules = [
            ['required', 'Password is required'],
        ];
        return $validate->password($password, $rules);
    }

    private function login($username, $password)
    {
        try {
            if (empty($username) || empty($password)) {
                throw new Exception('Email and password are required');
            }

            $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $params = [
                'email' => $username,
            ];
            $result = $this->database->query($sql, $params);

            if ($result && password_verify($password, $result[0]['password'])) {
                $user = $result[0];
                $this->removePassword($user);
                // $_SESSION['user_id'] = $user['id'];
                // $_SESSION['roles'] = $user['roles'];
                // $_SESSION['username'] = $user['username'];
                $this->setSession($user);
                header("Location: ../views/home.php");
                exit();
            } else {
                return false;
            }
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    private function setSession($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['roles'] = $user['roles'];
        $_SESSION['username'] = $user['username'];
    }

    public function getUserId()
    {
        return $_SESSION['user_id'] ?? null;
    }

    private function removePassword(&$user)
    {
        unset($user['password']);
    }
}
