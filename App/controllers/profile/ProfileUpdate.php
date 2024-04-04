<?php
// TODO:
  // ! this is for teachers, students, and parents update profile. 
  // ! it goes to the views/update-users.php
  // ! with this class you are able to update the profiles
namespace Thesis\controllers\profile;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\controllers\main\MainController;
use Thesis\functions\HashPassword;
use Thesis\functions\InputUtils;

class ProfileUpdate extends MainController
{

  protected $errors = [];
  // ! update profile
  public function update()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return;
    }

    $validation = new Validation();
    $this->errors = $this->input($validation);

    if (!empty($this->errors)) {
      return $this->errors;
    }

    $data = [
      'id' => InputUtils::sanitizeInput($_POST['user_id'], 'number_int'),
      'username' => InputUtils::sanitizeInput($_POST['username'], 'string'),
      'email' => InputUtils::sanitizeInput($_POST['email'], 'email'),
      'roles' => InputUtils::sanitizeInput($_POST['select_roles'], 'number_int')
    ];

    // Check if password is provided
    if (!empty($_POST['password'])) {
      $data['password'] = HashPassword::hash($_POST['password']);
    }
    // Check if data has changed
    $hasChanged = $this->database->getById('school.users', $data['id']);

    // Update
    if ($hasChanged) {
      // If data has changed, proceed with the update
      $sql = "UPDATE school.users SET username = :username, email = :email, roles = :roles";
      // Add password to the update query if provided
      if (isset($data['password'])) {
        $sql .= ", password = :password";
      }
      $sql .= " WHERE id = :id";

      $updateData = $data;
      // Remove password from update data if not provided
      if (!isset($data['password'])) {
        unset($updateData['password']);
      }

      $update = $this->database->executeQuery($sql, $updateData);

      if ($update) {
        FlashMessage::setMessage('Record updated', 'success');
      } else {
        FlashMessage::setMessage('Record not updated', 'info');
      }
    } else {
      FlashMessage::setMessage('Nothing changed', 'info');
    }
  }

  // ! validate form
  public function input($valid)
  {

    $name = [
      ['required', 'full name is reuired'],
      ['min_length', 'full name should be at least 2 characters', 2]
    ];
    $email = [
      ['required', 'email required'],
    ];
    $this->errors['username'] = $valid->string($_POST['username'], $name);
    $this->errors['email'] = $valid->email($_POST['email'], $email);
    $this->errors['select_roles'] = $valid->options($_POST['select_roles']);
    // check if password is filled
    $password = [];
    if (!empty($_POST['password'])) {
      $password = [
        ['required', 'password is required'],
        ['min_length', 'password must be at least 6', 6]
      ];
      $this->errors['password'] = $valid->password($_POST['password'], $password);
    }


    return array_filter($this->errors); // Remove empty elements
  }
}
