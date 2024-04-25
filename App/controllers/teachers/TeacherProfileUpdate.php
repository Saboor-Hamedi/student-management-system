<?php

/**
 * ? This class is responsible for inserting a teacher profile.
 * ? Although named TeacherProfileUpdate, its purpose is to handle profile insertion.
 * ? If needed, another function can be added for profile updating.
 * ? This class is exclusively called by views/teacher/register.php.
 * ? The views/teacher/register.php page is accessible only to administrators.
 */

namespace Thesis\controllers\teachers;

use Exception;
use Thesis\config\CallById;
use Thesis\config\ClearInput;
use Thesis\config\Database;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\functions\InputUtils;
use Thesis\helper\EntityExistsChecker;

class TeacherProfileUpdate
{
  protected $callByID;
  protected $validation;
  protected $database;
  protected $flash;
  public function __construct(
    Database $database,
    CallById $callByID,
    Validation $validation,
    FlashMessage $flash
  ) {
    $this->database = $database;
    $this->callByID = $callByID;
    $this->validation = $validation;
    $this->flash = $flash;
  }

  public function UpdateProfile()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return;
    }

    try {
      $errors = $this->input($this->validation);
      if (!empty($errors)) {
        return $errors;
      }
      $entity = new EntityExistsChecker($this->database);
      $hasProfile = $entity->doesEntityIdExist('teachers', $_POST['selected_teacher_id']);
      if (!empty($hasProfile)) {
        $this->flash->setMessage('Profile has already updated', 'info');
      } else {
        $data = $this->prepareData();
        $profile = $this->database->insert('teachers', $data);

        if ($profile) {
          $this->InputClear();
          $this->flash->setMessage('Profile successfully updated', 'success');
        } else {
          $this->flash->setMessage('Profile did not update', 'info');
        }
      }
    } catch (Exception $e) {
      $this->flash->addMessageWithException('Something went wrong', $e, 'danger');
    }
  }

  // ! validate form or input 
  private function input($input)
  {
    $errors = [];
    $fields = [
      'selected_teacher_id' => [
        'type' => 'number',
        'rules' => [['required', 'Required teacher id'], ['integer', 'Teacher id must be a number'], ['min_value', 'Teacher id minimum 1', 1]],
      ],
      'search_teacher_live' => [
        'type' => 'string',
        'rules' => [['required', 'Required teacher name']],
      ],
      'teacher_lastname' => [
        'type' => 'string',
        'rules' => [['required', 'Required teacher last name']],
      ],
      'teacher_qualification' => [
        'type' => 'string',
        'rules' => [['required', 'Required teacher qualifications']],
      ],
      'teacher_experience' => [
        'type' => 'number',
        'rules' => [['required', 'Required teacher experience'], ["integer", "Experience must be number"], ['max_value', 'Maximum experience cannot be more than 20', 20], ['min_value', 'Minimum experience cannot be less than 1', 1]],
      ],
      'teacher_specialization' => [
        'type' => 'string',
        'rules' => [['required', 'Required teacher specialization']],
      ],
      'teacher_taught_subject' => [
        'type' => 'options',
        'rules' => [], // Add your rules for options validation here
      ],
    ];

    foreach ($fields as $field => $data) {
      $errors[$field] = $input->{$data['type']}($_POST[$field], $data['rules']);
    }

    return array_filter($errors);
  }

  private function prepareData()
  {
    $data = [
      'teacher_id' => InputUtils::sanitizeInput($_POST['selected_teacher_id'], 'number_int'),
      'qualification' => InputUtils::sanitizeInput($_POST['teacher_qualification'], 'string'),
      'teacher_lastname' => InputUtils::sanitizeInput($_POST['teacher_lastname'], 'string'),
      'experience' => InputUtils::sanitizeInput($_POST['teacher_experience'], 'number_int'),
      'subjects_taught' => InputUtils::sanitizeInput($_POST['teacher_taught_subject'], 'string'),
      'specialization' => InputUtils::sanitizeInput($_POST['teacher_specialization'], 'string'),
    ];

    return $data;
  }

  private function InputClear()
  {
    ClearInput::clear(
      'selected_teacher_id',
      'search_teacher_live',
      'teacher_lastname',
      'teacher_qualification',
      'teacher_experience',
      'teacher_specialization',
      'teacher_taught_subject',
    );
  }
}
