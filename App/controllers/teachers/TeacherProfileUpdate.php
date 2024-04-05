<?php

/**
 *  * This class is responsible to update the teacher profile
 *  * Even though it says TeacherProfileUpdate, but it's responsible to insert not update
 *  * You can make another function to update the if you want to 
 *  * This class is only call on views/teacher/register.php
 *  * 
 */

namespace Thesis\controllers\teachers;

use Exception;
use Thesis\config\CallById;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\controllers\main\MainController;
use Thesis\functions\InputUtils;
class TeacherProfileUpdate extends MainController
{
  protected $callByID;
  protected $validation;
  public function __construct(CallById $callByID, Validation $validation)
  {
    parent::__construct();
    $this->callByID = $callByID;
    $this->validation = $validation;
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
      $hasProfile = $this->callByID->doesTeacherIdExist('school.teachers', $_POST['selected_teacher_id']);

      if (!empty($hasProfile)) {
        FlashMessage::setMessage('Profile has already updated', 'info');
      } else {
        $data = $this->prepareData();
        $profile = $this->database->insert('school.teachers', $data);

        if ($profile) {
          $this->InputClear();
          FlashMessage::setMessage('Profile successfully updated', 'success');
        } else {
          FlashMessage::setMessage('Profile did not update', 'info');
        }
      }
    } catch (Exception $e) {
      FlashMessage::addMessageWithException('Something went wrong', $e, 'danger');
    }
  }

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
