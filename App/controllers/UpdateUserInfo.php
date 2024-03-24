<?php
// only admin have access to this class
namespace Thesis\controllers;

use Exception;
use Thesis\config\Database;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;

class UpdateUserInfo
{
    private $database;
    public function __construct()
    {
        $this->database = Database::GetInstance();
    }

    public function update_userinfo($studentId, $username, $email, $password = null, $studentRoles = null)
    {
        // Check if the student exists
        $student = $this->database->getById('school.users', $studentId);
        if (!$student) {
            FlashMessage::setMessage('Student not found', 'info');
        }

        // Validate input
        $validation = new Validation();
        $errors = $validation->string($username, [
            ['required', 'Full Name is required'],
            ['min_length', 'Full Name should be at least 2 characters', 2]
        ]);
        if (!empty($errors)) {
            return ['errors' => $errors];
        }

        $errors = $validation->validate_email($email);
        if (!empty($errors)) {
            return ['errors' => ['email' => $errors]];
        }

        if (!empty($password)) {
            $errors = $validation->validate_password($password);
            if (!empty($errors)) {
                return ['errors' => ['password' => $errors]];
            }
        }

        $errors = $validation->validated_select_option($studentRoles);
        if (!empty($errors)) {
            return ['errors' => ['select_roles' => $errors]];
        } elseif ($studentRoles == null) {
            return ['errors' => ['select_roles' => 'Please select a role']];
        }

        // Check if any changes were made
        $changesMade = ($student['username'] !== $username ||
            $student['email'] !== $email ||
            !empty($password) ||
            $student['roles'] !== $studentRoles
        );


        // Update the data
        $data = [
            'username' => $username,
            'email' => $email
        ];

        // Update password
        if (!empty($password)) {
            $hashPassword = password_hash($password, PASSWORD_BCRYPT);
            $data['password'] = $hashPassword;
        }
        // Update the roles
        if (!is_null($studentRoles)) {
            $data['roles'] = $studentRoles;
        }

        $where = 'id = :id';
        $data['id'] = $studentId;
        try {
            $affectRows = $this->database->update('school.users', $data, $where);
            $rowCount = $affectRows;
            if ($rowCount == 0) {
                FlashMessage::setMessage('No changes made', 'info');
            } elseif ($rowCount > 0) {
                FlashMessage::setMessage('User updated', 'primary');
            } else {
                FlashMessage::setMessage('Update failed', 'info');
            }
        } catch (Exception $e) {
            FlashMessage::setMessage('Update failed', 'error');
        }
    }
}
