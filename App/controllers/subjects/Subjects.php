<?php
// TODO:
// ! This class is responsible to add new subject students
// ! This class is only avaliable for admin
// ! This class would be call on views/subject/subject.php 
namespace Thesis\controllers\subjects;

use Exception;
use Thesis\config\CallById;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\controllers\main\MainController;
use Thesis\functions\InputUtils;

class Subjects extends MainController
{
  protected $errors = [];
  protected $callbyid;
  /**
   * Subjects constructor.
   *
   * @param Callbyid $callbyid
   */
  public function __construct(Callbyid $callbyid)
  {
    parent::__construct();
    $this->callbyid = $callbyid;
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

  //  TODO:
  // ! Store the subjects
  public function store()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return;
    }
    try {

      $validate = new Validation();
      $this->errors = $this->input($validate);
      // ! check if erros is empty
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
      'student_id',
      'search_student_names',
      'start_subject_time',
      'end_subject_time',
      'grades'
    );
  }
  private function input($input)
  {
    $this->validateStudentId($input);
    $this->validateSearchLive($input);
    $this->validateSubjectName($input);
    $this->validateSudentId($input);
    $this->validateSearchName($input);
    $this->validateSubjectStartTime($input);
    $this->validateSubjectEndTime($input);
    $this->validateGrades($input);
    return array_filter($this->errors);
  }
  //  ! selected_teacher_id, validate for teacher id
  private function validateStudentId($input)
  {
    $rules = [
      ['required',  'Required teacher id'],
      ['integer',   'Teacher id must be integer'],
      ['min_value', 'Teacher must be not less not 1', 1]
    ];
    $this->errors['selected_teacher_id'] = $input->number($_POST['selected_teacher_id'], $rules);
    //  ! check if the roles are 2, teachers
    if (!$this->callbyid->if_user_exists('school.users', $_POST['selected_teacher_id'], 2)) {
      $this->errors['selected_teacher_id'] = 'This account is not a teacher';
    }
    // ! checks if teacher exists
    if (!$this->callbyid->doesTeacherIdExist('school.teachers', $_POST['selected_teacher_id'])) {
      $this->errors['selected_teacher_id'] = 'Teacher id did not match';
    }
  }
  //  ! search_teacher_live, validate search for teacher
  private function validateSearchLive($input)
  {
    $rules = [
      ['required', 'Required teacher name']
    ];
    $this->errors['search_teacher_live'] = $input->string($_POST['search_teacher_live'], $rules);
  }
  // ! validate subject name
  private function validateSubjectName($input)
  {
    $this->errors['subject_names'] = $input->options($_POST['subject_names']);
  }
  // ! validate student id
  private function validateSudentId($input)
  {
    $rules = [
      ['required', 'Required student id'],
      ['integer', 'Student id must be integer'],
      ['min_value', 'Student must be not less not 1', 1]
    ];
    $this->errors['student_id'] = $input->number($_POST['student_id'], $rules);
    // ! check if the roles are 1, students
    if (!$this->callbyid->if_user_exists('school.users', $_POST['student_id'], 1)) { // check if teacher userid is match 
      $this->errors['student_id'] = 'This is account is not a student';
    }
    // ! check if the students id exists 
    if (!$this->callbyid->doesStudentIdExist('school.students', $_POST['student_id'])) {
      $this->errors['student_id'] = 'Student ID did not match';
    }
  }
  // ! validate student search name
  private function validateSearchName($input)
  {
    $rules = [
      ['required', 'Required student name']
    ];
    $this->errors['search_student_names'] = $input->string($_POST['search_student_names'], $rules);
    // ! search with student names, on students table, using ajax
    if (!$this->callbyid->get_by_roles('school.users', $_POST['search_student_names'], 1)) {
      $this->errors['search_student_names'] = 'Student name did not match';
    }
  }
  // ! validate the start time of the subjects
  private function validateSubjectStartTime($input)
  {
    $rules = [
      ['required', 'Required start time']
    ];
    $this->errors['start_subject_time'] = $input->time($_POST['start_subject_time'], $rules);
  }
  // ! validate the end time of the subjects
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
