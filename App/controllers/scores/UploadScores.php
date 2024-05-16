<?php

namespace Thesis\controllers\scores;

use Thesis\config\CallById;
use Thesis\config\Database;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\functions\InputUtils;
use Thesis\helper\EntityExistsChecker;

class UploadScores
{
  protected $database;
  protected $errors = [];
  protected $callById;
  protected $validation;
  protected $flash;
  protected $entityIdField;
  /**
   * __construct
   */
  public function __construct(
    Database $database,
    CallById $callById,
    Validation $validation,
    FlashMessage $flash
  ) {
    $this->database = $database;
    $this->callById =  $callById;
    $this->validation = $validation;
    $this->flash = $flash;
  }

  /**
   *   upload student scores
   */
  public function uploadStudentScores()
  {
    // check if request method is post
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return;
    }
    $errors = $this->validateInput($this->validation);
    if (!empty($errors)) {
      return $errors;
    }
    // check if scores already exist
    if (!$this->checkScores()) {
      $data = $this->prepareData();
      $result = $this->database->insert('school.scores', $data);
      if ($result) {
        $this->flash->redirect('/teacher/classes.php', 'Scores uploaded successfully', 'success');
      }
    } else {
      $this->flash->redirect('/teacher/classes.php', 'Scores already uploaded', 'info');
    }
  }
  /**
   *   validate input
   */
  private function validateInput($input)
  {
    // validate input
    $errors = [];
    $errors['teacher_id'] = $this->validateTeacherId($input, $errors);
    $errors['student_id'] = $this->validateStudentId($input, $errors);
    $errors['search_student_names'] = $this->validateSearchStudentName($input);
    $errors['student_grade_id'] = $this->validateStudentGradeId($input);
    $errors['subject_names'] = $this->validateSubjectName($input);
    $errors['score'] = $this->validateScores($input);
    return array_filter($errors);
  }
  /**
   *  check if scores already exist
   */
  private function checkScores()
  {
    $studentId = $_POST['student_id'];
    $teacherId = $_POST['teacher_id'];
    $subjectName = $_POST['subject_names'];
    $this->entityIdField = new EntityExistsChecker($this->database);
    $scoresExist = $this->database->checkExistingScore($studentId, $teacherId, $subjectName);
    return $scoresExist;
  }
  /**
   *   prepare data
   */
  private function prepareData(): array
  {
    return [
      'student_id' => InputUtils::sanitizeInput($_POST['student_id'], 'number_int'),
      'teacher_id' => InputUtils::sanitizeInput($_POST['teacher_id'], 'number_int'),
      'grades_id' => InputUtils::sanitizeInput($_POST['student_grade_id'], 'number_int'),
      'subject_names' => InputUtils::sanitizeInput($_POST['subject_names'], 'string'),
      'score' => InputUtils::sanitizeInput($_POST['score'], 'number_int'),
    ];
  }

  /**
   *   validate student id
   */
  private function validateStudentId($input, $errors)
  {
    $rules = [
      ['required', 'Required student id'],
      ['integer', 'Student id must be a number'],
    ];
    // check if student_id match the current student_id or exists
    if (!$this->callById->if_user_exists('school.users', $_POST['student_id'], 1)) {
      return $errors['errors'] =  'Student did not match';
    } // check if student user_id is match 
    return $input->number($_POST['student_id'], $rules);
  }
  /**
   *   validate teacher id
   */
  private function validateTeacherId($input, $errors)
  {
    $rules = [
      ['required', 'Required teacher id'],
      ['integer', 'Teacher id must be a number'],
    ];
    if (!$this->callById->if_user_exists('school.users', $_POST['teacher_id'], 2)) {
      return $errors['error'] =  'Teacher did not match';
    } // check if teacher user_id is match

    // * check if the teacher id exists 
    return $input->number($_POST['teacher_id'], $rules);
  }
  private function validateSearchStudentName($input)
  {
    $rules = [
      ['required', 'Required student name'],
    ];
    return $input->string($_POST['search_student_names'], $rules);
  }
  private function validateStudentGradeId($input)
  {
    $rules = [
      ['required', 'Required student grade id'],
      ['integer', 'Student grade id must be a number'],
    ];
    return $input->number($_POST['student_grade_id'], $rules);
  }
  private function validateSubjectName($input)
  {
    $rules = [
      ['required', 'Required subject name'],
    ];
    return $input->string($_POST['subject_names'], $rules);
  }
  public function validateScores($input)
  {
    $rules = [
      ['required', 'Required score'],
      ['integer', 'Score must be a number'],
      ['max_value', 'Score must be less than or equal to 100', 100],
      ['min_value', 'Score must be greater than or equal to 1 and less than 2', 1],

    ];
    return $input->number($_POST['score'], $rules);
  }
}
