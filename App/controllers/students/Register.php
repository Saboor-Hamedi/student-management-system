<?php
/**
  ! Update Students Data
  ! This class belongs to the student, and admin has the access to register a new student 
  ! for more details you can visit public/views/student/register.php
  ! if want to add more details about students, add more attributes on student table and inputs on student/register.php
*/

namespace Thesis\controllers\students;

use Exception;
use Thesis\config\CallById;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\controllers\main\MainController;
use Thesis\functions\InputUtils;

class Register extends MainController
{

  protected $errors = [];
  protected $callByID;
  
  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct(); // ! its because we don't want to make override the __construct since its on MainController
    $this->callByID = new CallById();
  }
  /**
   * Search for a student this function goes to the views/files/loadProfile.php
   * and that loadProfile.php would be called through ajax
   * 
   * findStudents
   *
   * @return void
   */
  public function loadProfiles()
  {
    try {
      if (isset($_POST['roles_id']) && $_POST['roles_id'] !== '') {
        $name = $_POST['roles_id'];
        $data = $this->callByID->get_by_roles('school.users', $name, 1);
        echo json_encode($data, JSON_PRETTY_PRINT);
      } else {
        if (isset($_POST['roles_id'])) {
          FlashMessage::setMessage('Invalid student ID', 'info');
        }
      }
    } catch (Exception $e) {
      FlashMessage::addMessageWithException('Something went wrong', $e, 'danger');
    }
  }
  /**
   * This function would be responsible for inserting a student 
   * register
   *
   * @return void
   */
  public function register()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return;
    }

    try {
      $validation = new Validation();
      $this->errors = $this->input($validation);
      if (!empty($this->errors)) {
        return $this->errors;
      }
      $hasUpdate = $this->callByID->doesStudentIdExist('school.students', InputUtils::sanitizeInput($_POST['student_profile_id'], 'number_int'));
      if (!empty($hasUpdate)) {
        FlashMessage::setMessage('This student already exists', 'info');
      } else {
        $data = $this->prepareData();
        $insert_result = $this->database->insert('school.students', $data);
        if ($insert_result) {
          $this->clearInput();
          FlashMessage::setMessage('student updated', 'success');
        } else {
          FlashMessage::setMessage('Something went wrong!', 'danger');
        }
      }
    } catch (Exception $e) {
      FlashMessage::addMessageWithException('Something went wrong', $e, 'danger');
    }
  }
  // TODO: 
  // prepare the data
  private function prepareData()
  {
    return [
      'student_id' => InputUtils::sanitizeInput($_POST['student_profile_id'], 'number_int'),
      'lastname' => InputUtils::sanitizeInput($_POST['student_lastname'], 'string'),
      'age' => InputUtils::sanitizeInput($_POST['student_age'], 'number_int'),
      'sex' => $_POST['student_sex'],
    ];
  }
  private function clearInput()
  {
    ClearInput::clear(
      'student_profile_id',
      'search_student_profile_name',
      'student_lastname',
      'student_age',
      'student_sex',
    );
  }

  // TODO:
  // ! Validate the form
  public function input($input)
  {
    $this->validateStudentProfileId($input);
    $this->validateSearchStudentProfileName($input);
    $this->validateStudentAge($input);
    $this->validateStudentLastname($input);
    $this->validateStudentSex($input);
    return array_filter($this->errors);
  }

  private function validateStudentProfileId($input)
  {
    $rules = [
      ['required', 'Required student id'],
      ['integer', 'ID must be integer'],
    ];
    $this->errors['student_profile_id'] = $input->number($_POST['student_profile_id'], $rules);
    if (!$this->callByID->if_user_exists('school.users', $_POST['student_profile_id'], 1)) {
      $this->errors['student_profile_id'] = 'student id did not match';
    }
  }

  private function validateSearchStudentProfileName($input)
  {
    $rules = [
      ['required', 'Required name'],
    ];
    $this->errors['search_student_profile_name'] = $input->string($_POST['search_student_profile_name'], $rules);
    if (!$this->callByID->get_by_roles('school.users', $_POST['search_student_profile_name'], 1)) {
      $this->errors['search_student_profile_name'] = 'student name did not match';
    }
  }
  private function validateStudentAge($input)
  {
    $rules = [
      ['required', 'Required age'],
      ['integer', 'Age must be a number'],
      ['max_value', 'Maximum age must be 18', 18],
      ['min_value', 'Minimum age must be 4', 4]
    ];
    $this->errors['student_age'] = $input->number($_POST['student_age'], $rules);
  }

  private function validateStudentLastname($input)
  {
    $rules = [
      ['required', 'Required last name'],
    ];
    $this->errors['student_lastname'] = $input->string($_POST['student_lastname'], $rules);
  }

  private function validateStudentSex($input)
  {
    $this->errors['student_sex'] = $input->options($_POST['student_sex']);
  }
  
}
