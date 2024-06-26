<?php

/**
 *  * This class is responsible to insert or update teacher and students    profiles. 
 *  * This class is only access by teachers & students 
 *  * This class is instantiated on profile/profiles.php 
 *  * 
 * 
 */

namespace Thesis\controllers\profile;

use Exception;
use Thesis\config\Auth;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\functions\InputUtils;

class InsertUserProfile
{
  protected $database;
  protected $callByID;
  protected $validate;
  protected $auth;
  protected $flash;
  public function __construct($database, Validation $validate, Auth $auth, FlashMessage $flash)
  {
    $this->database = $database;
    $this->validate = $validate;
    $this->auth = $auth;
    $this->flash = $flash;
  }
  public function insertProfile()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return;
    }
    try {
      $errors = $this->input($this->validate);
      if (!empty($errors)) {
        return $errors;
      }
      $this->processProfileData();
    } catch (Exception $e) {
      $this->flash->addMessageWithException('Something went wrong', $e, 'danger');
    }
  }
  private function processProfileData()
  {
    try {
      $userId = $this->auth->user_id();
      $existingRow = $this->database->getUserId('school.userinformation', 'user_id', $userId);
      $data = $this->sanitizeData();
      if (!$existingRow) {
        $this->insertData($data);
      } else {
        $this->updateData($data);
      }
    } catch (Exception $e) {
      $this->flash->addMessageWithException('Something went wrong', $e, 'danger');
    }
  }

  private function sanitizeData()
  {
    return [
      'user_id' => InputUtils::sanitizeInput($_POST['user_main_id'], 'number_int'),
      'country' => InputUtils::sanitizeInput($_POST['user_country'], 'string'),
      'address' => InputUtils::sanitizeInput($_POST['user_address'], 'string'),
      'zip_code' => InputUtils::sanitizeInput($_POST['user_post_code'], 'number_int'),
      'phone_number' => InputUtils::sanitizeInput($_POST['phone_number'], 'number_int')
    ];
  }

  private function insertData($data)
  {
    $result =  $this->database->insert('school.userinformation', $data);
    if ($result === false) {
      // throw new Exception('Failed to insert profile into the database.');
      $this->flash->setMessage('Failed to insert profile into the database');
    }
    $this->flash->setMessage('Profile inserted', 'primary');
  }

  private function updateData($data)
  {
    $where = 'user_id = :user_id';
    $result = $this->database->update('school.userinformation', $data, $where);

    if (!$result) {
      // $this->flash->setMessage('No changes made', 'info');
      $this->flash->redirect('/home.php', 'No changes made', 'info');
    } else {
      $this->flash->setMessage('Profile Updated', 'success');
    }
  }

  public function users($table, $id)
  {

    $users =  $this->database->information($table, $id);
    return  $users;
  }

  private function input($input): array
  {
    $errors = [];
    $errors['user_main_id'] = $this->validateUserMainId($input);
    $errors['user_country'] = $this->validateUserCountry($input);
    $errors['user_post_code'] = $this->validateUserPostCode($input);
    $errors['phone_number'] = $this->validatePhoneNumber($input);
    $errors['user_address'] = $this->validateUserAddress($input);
    return array_filter($errors);
  }
  private function validateUserMainId($input)
  {
    $rules = [
      ['required', 'User id required'],
      ['min_value', 'At least 1 character required', 1]
    ];
    return $input->number($_POST['user_main_id'], $rules);
  }
  private function validateUserCountry($input): ?string
  {
    $rules = [
      ['required', 'Country is required'],
      ['min_length', 'At least 2 character required', 2]
    ];
    return $input->string($_POST['user_country'], $rules);
  }
  private function validateUserPostCode($input)
  {
    $rules = [
      ['required', 'Required post code'],
      ['integer', 'post code must be a number'],
    ];
    return $input->number($_POST['user_post_code'], $rules);
  }
  private function validatePhoneNumber($input)
  {
    $rules = [
      ['required', 'Required phone number'],
      ['integer', 'Min value must be less than 10', 10],

    ];
    return $input->number($_POST['phone_number'], $rules);
  }
  private function validateUserAddress($input): ?string
  {
    $rules = [
      ['required', 'Required address'],
    ];
    return $input->string($_POST['user_address'], $rules);
  }
}
