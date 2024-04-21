<?php

/**
 *  * This is responsible for updating the teacher, 
 *  * student on the views/update-users file 
 *  * this class is only available for admin
 */

namespace Thesis\controllers\profile;

use Exception;
use Thesis\config\Database;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\functions\HashPassword;
use Thesis\functions\InputUtils;

/**
 * UpdateUserProfile
 */
class UpdateUserProfile
{
  protected $errors = [];
  protected $validation;
  protected $database;
  protected $flash;

  /**
   * __construct
   *
   * @param  mixed $database
   * @param  mixed $validation
   * @param  mixed $flash
   * @return void
   */
  public function __construct(Database $database, Validation $validation, FlashMessage $flash)
  {
    $this->database = $database;
    $this->validation = $validation;
    $this->flash = $flash;
  }

  /**
   * editUserProfile
   *
   */
  public function editUserProfile()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return;
    }
    try {
      $errors = $this->input($this->validation);

      if (!empty($errors)) {
        return $errors; // Return errors if validation fails
      }

      $data = $this->prepareData();

      if (!empty($_POST['password'])) {
        $data['password'] = HashPassword::hash($_POST['password']);
      }
      $hasChanged = $this->isChanged($data['id']);
      if ($hasChanged) {
        return $this->update($data);
      }
    } catch (Exception $e) {
      return null;
    }
  }
  /**
   * isChanged
   *
   * @param  mixed $id
   * @return bool
   */
  private function isChanged(int $id): bool
  {
    $user = $this->database->getById('users', $id);
    if ($user) {
      return true;
    }
    return false;
  }
  /**
   * prepareData
   *
   * @return array
   */
  private function prepareData(): array
  {
    return [
      'id' => InputUtils::sanitizeInput($_POST['user_id'], 'number_int'),
      'username' => InputUtils::sanitizeInput($_POST['username'], 'string'),
      'email' => InputUtils::sanitizeInput($_POST['email'], 'email'),
      'roles' => InputUtils::sanitizeInput($_POST['select_roles'], 'number_int')
    ];
  }

  /**
   * update
   *
   * @param  mixed $data
   * @return void
   */
  private function update(array $data): void
  {
    $sql = "UPDATE school.users SET username = :username, email = :email, roles = :roles";
    if (isset($data['password'])) {
      $sql .= ", password = :password";
    }
    $sql .= " WHERE id = :id";

    $updateData = $data;
    if (!isset($data['password'])) {
      unset($updateData['password']);
    }

    $update = $this->database->executeQuery($sql, $updateData);
    if ($update) {
      $this->flash->setMessage('Record updated', 'success');
    } else {
      $this->flash->setMessage('Nothing changed', 'info');
    }
  }

  /**
   * input
   *
   * @param  mixed $valid
   * @return void
   */
  private function input($valid): array
  {
    $errors = [];
    $errors['username'] = $this->validateUsername($valid);
    $errors['email'] = $this->validateEmail($valid);
    $errors['select_roles'] = $this->validateRoles($valid);
    $errors['password'] = $this->validatePassword($valid);

    return array_filter($errors); // Remove empty elements
  }

  /**
   * validateUsername
   *
   * @param  mixed $valid
   * @return void
   */
  /**
   * validateUsername
   *
   * @param  mixed $valid
   * @return string
   */
  private function validateUsername($valid): ?string
  {

    $name = [
      ['required', 'full name is required'],
      ['min_length', 'full name should be at least 2 characters', 2]
    ];
    return $valid->string($_POST['username'], $name);
  }

  /**
   * validateEmail
   *
   * @param  mixed $valid
   * @return string
   */
  private function validateEmail($valid): ?string
  {
    $email = [
      ['required', 'email required'],
    ];
    return $valid->email($_POST['email'], $email);
  }

  /**
   * validateRoles
   *
   * @param  mixed $valid
   * @return string
   */
  private function validateRoles($valid): ?string
  {
    return $valid->options($_POST['select_roles']);
  }

  /**
   * validatePassword
   *
   * @param  mixed $valid
   * @return string
   */
  private function validatePassword($valid): ?string
  {
    $password = [];
    if (!empty($_POST['password'])) {
      $password = [
        ['required', 'password is required'],
        ['min_length', 'password must be at least 6', 6]
      ];
      return $valid->password($_POST['password'], $password);
    }
    return null;
  }
}
