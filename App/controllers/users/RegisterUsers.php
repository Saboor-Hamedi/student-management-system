<?php

namespace Thesis\controllers\users;

use PDOException;
use Thesis\config\FlashMessage;
use Thesis\functions\InputUtils;
use Thesis\functions\HashPassword;
use Thesis\config\Validation;
use Thesis\controllers\main\MainController;

class RegisterUsers extends MainController
{
  public function registerUser()
  {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return;
    }
    $validation = new Validation();
    $errors = $this->input($validation);
    if (!empty($errors)) {
      return $errors;
    }

    $emailExists = $this->database->EmailExists($_POST['email']);
    if ($emailExists) {
      FlashMessage::setMessage('Email already taken', 'info');
      return;
    }
    try {
      $users =  $this->database->insert('users', [
        'username' => InputUtils::sanitizeInput($_POST['fullname'],'string'),
        'email' => $_POST['email'],
        'password' => HashPassword::hash($_POST['password']),
        'roles' => $_POST['select_roles'],
      ]);
    } catch (PDOException $e) {
      // Optionally, rethrow the exception or handle it as needed
      FlashMessage::setMessage('An error occurred while adding the user.', 'danger');
    }
    if ($users) {
      FlashMessage::setMessage('New user added', 'primary');
      $_POST = array_fill_keys(array_keys($_POST), ''); // Reset POST data
    } else {
      FlashMessage::setMessage('Something went wrong!', 'danger');
    }
  }
  public function input($valid)
  {
    $errors = [];
    $name = [
      ['required', 'full name is reuired'],
      ['min_length', 'Full Name should be at least 2 characters', 2]
    ];
    $password = [
      ['required', 'password is required'],
      ['min_length', 'password must be at least 3', 3]
    ];
    $errors['fullname'] = $valid->string($_POST['fullname'], $name);
    $errors['email'] = $valid->email($_POST['email']);
    $errors['password'] = $valid->password($_POST['password'], $password);
    $errors['select_roles'] = $valid->options($_POST['select_roles']);
    return array_filter($errors); // Remove empty elements
  }
}
