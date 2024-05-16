<?php
// TODO:
// * This class is responsible to add new subject students
// * This class is only available for admin
// * This class would be call on views/subject/subject.php 
namespace Thesis\controllers\subjects;

use Exception;
use Thesis\config\CallById;
use Thesis\config\ClearInput;
use Thesis\config\Database;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\functions\InputUtils;
use Thesis\helper\EntityExistsChecker;

class Subjects
{

  protected $errors = [];
  protected $database;
  protected $callByID;
  protected $entity;
  /**
   * Summary of __construct
   */
  public function __construct(Database $database, EntityExistsChecker $entity, CallById $callByID)
  {
    $this->database = $database;
    $this->entity = $entity;
    $this->callByID = $callByID;
  }
  // TODO:
  /**
   * Load the grades from grades table.
   * 
   * @return mixed Returns the result of the query, or false if no data found.
   */
  /**
   * Store the subjects.
   */
  public function loadGrades()
  {
    $sql = "SELECT id, name, grade, created_at FROM grades GROUP BY grade";
    $result = $this->database->query($sql);
    if ($result > 0) {
      return $result;
    } else {
      return false;
    }
  }



  /**
   * Add new subject
   */
  public function addSubject()
  {
    /**
     * Check if the request method is POST
     */
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return;
    }
    try {

      $validate = new Validation();
      $this->errors = $this->input($validate);
      /**
       * Check if there are any errors
       */
      if (!empty($this->errors)) {
        return $this->errors;
      }
      $data = $this->prepareData();
      $subject = $this->database->insert('school.classes', $data);
      if ($subject) {
        $this->clearInput();
        FlashMessage::setMessage('New class created', 'success');
      } else {
        FlashMessage::setMessage('No class created', 'info');
      }
    } catch (Exception $e) {
      FlashMessage::addMessageWithException('Something went wrong', $e, 'danger');
    }
  }
  /** 
   * Prepare data for insert
   */
  private function prepareData()
  {
    return [
      'teacher_id' => InputUtils::sanitizeInput($_POST['selected_teacher_id'], 'number_int'),
      'student_id' => InputUtils::sanitizeInput($_POST['student_id'], 'number_int'),
      'subject_name' => InputUtils::sanitizeInput($_POST['subject_names'], 'string'),
      'start_class' => InputUtils::sanitizeInput($_POST['start_subject_time'], 'string'),
      'end_class' => InputUtils::sanitizeInput($_POST['end_subject_time'], 'string'),
      'grades' => $_POST['select_grades'],
    ];
  }
  private function clearInput()
  {
    ClearInput::clear(
      'selected_teacher_id',
      'search_teacher_live',
      'subject_names',
      'select_grades',
      'student_id',
      'search_student_names',
      'start_subject_time',
      'end_subject_time',
    );
  }
  private function input($input)
  {
    $this->validateTeacherId($input);
    $this->validateSearchLive($input);
    $this->validateSubjectName($input);
    $this->validateStudentId($input);
    $this->validateSearchName($input);
    $this->validateSubjectStartTime($input);
    $this->validateSubjectEndTime($input);
    $this->validateGrades($input);
    return array_filter($this->errors);
  }
  // * selected_teacher_id, validate for teacher id
  private function validateTeacherId($input)
  {
    $selectedTeacherId = isset($_POST['selected_teacher_id']) ? $_POST['selected_teacher_id'] : '';
    if (empty($selectedTeacherId)) {
      $this->errors['selected_teacher_id'] = 'Teacher id required';
    } else {
      $rules = [
        ['required',  'Required teacher id'],
        ['integer',   'Teacher id must be integer'],
        ['min_value', 'Teacher must be not less not 1', 1]
      ];
      $this->errors['selected_teacher_id'] = $input->number($selectedTeacherId, $rules);
      if (!$this->errors['selected_teacher_id']) {
        // Check if the teacher ID exists in the database
        $isTeacher = $this->entity->checkWithValue('teachers', 'teacher_id', $selectedTeacherId);
        if (!$isTeacher) {
          $this->errors['selected_teacher_id'] = 'This teacher is not yet registered';
        }
      }
    }
  }
  // * search_teacher_live, validate search for teacher
  private function validateSearchLive($input)
  {
    $rules = [
      ['required', 'Required teacher name']
    ];
    $this->errors['search_teacher_live'] = $input->string($_POST['search_teacher_live'], $rules);
  }
  // * validate subject name
  private function validateSubjectName($input)
  {
    $this->errors['subject_names'] = $input->options($_POST['subject_names']);
  }
  // * validate student id
  private function validateStudentId($input)
  {
    $selectedStudentId = isset($_POST['student_id']) ? $_POST['student_id'] : '';
    if (empty($selectedStudentId)) {
      $this->errors['student_id'] = 'Student id required';
    } else {
      $rules = [
        ['required', 'Required student id'],
        ['integer', 'Student id must be integer'],
        ['min_value', 'Student must be not less not 1', 1]
      ];
      $this->errors['student_id'] = $input->number($selectedStudentId, $rules);
    }
    if (!$this->errors['student_id']) {
      // * check if the students id exists 
      $isStudent = $this->entity->checkWithValue('students', 'student_id', $_POST['student_id']);
      if (!$isStudent) {
        $this->errors['student_id'] = 'This student is not yet registered';
      }
    }
  }
  // * validate student search name
  private function validateSearchName($input)
  {
    $rules = [
      ['required', 'Required student name']
    ];
    $this->errors['search_student_names'] = $input->string($_POST['search_student_names'], $rules);
    // * search with student names, on students table, using ajax
    if (!$this->callByID->get_by_roles('school.users', $_POST['search_student_names'], 1)) {
      $this->errors['search_student_names'] = 'Student name did not match';
    }
  }
  // * validate the start time of the subjects
  private function validateSubjectStartTime($input)
  {
    $rules = [
      ['required', 'Required start time']
    ];
    $this->errors['start_subject_time'] = $input->time($_POST['start_subject_time'], $rules);
  }
  // * validate the end time of the subjects
  private function validateSubjectEndTime($input)
  {
    $rules = [
      ['required', 'Required start time']
    ];
    $this->errors['end_subject_time'] = $input->time($_POST['end_subject_time'], $rules);
  }
  private function validateGrades($input)
  {
    $this->errors['select_grades'] = $input->options($_POST['select_grades'], $input);
  }
}
