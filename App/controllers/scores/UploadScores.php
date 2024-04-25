<?php

namespace Thesis\controllers\scores;

use Thesis\config\CallById;
use Thesis\config\Database;
use Thesis\config\FlashMessage;
use Thesis\config\ClearInput;
use Thesis\config\Validation;
use Thesis\functions\InputUtils;

class UploadScores
{
  protected $database;
  protected $errors = [];
  protected $callById;
  protected $validation;
  protected $flash;

  public function __construct(Database $database, CallById $callById, Validation $validation, FlashMessage $flash)
  {
    $this->database = $database;
    $this->callById =  $callById;
    $this->validation = $validation;
    $this->flash = $flash;
  }

  public function uploadStudentScores()
  {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return;
    }
    $errors = $this->validateInput($this->validation);
    if (!empty($errors)) {
      return $errors;
    }
    if (!$this->checkScores()) {
      $data = $this->prepareData();
      $result = $this->database->insert('school.scores', $data);
      if ($result) {
        $this->flash->redirect('/teacher/classes.php','Scores uploaded successfully', 'success');
      }
    }else{
      $this->flash->redirect('/teacher/classes.php','Scores already uploaded', 'info');
    }
  }
  private function validateInput($input)
  {
    $errors = [];
    $errors['teacher_id'] = $this->validateTeacherId($input);
    $errors['student_id'] = $this->validateStudentId($input);
    $errors['search_student_names'] = $this->validateSearchStudentName($input);
    $errors['student_grade_id'] = $this->validateStudentGradeId($input);
    $errors['subject_names'] = $this->validateSubjectName($input);
    $errors['score'] = $this->validateScores($input);
    return array_filter($errors);
  }
  private function checkScores()
  {
    $studentId = $_POST['student_id'];
    $teacherId = $_POST['teacher_id'];
    $subjectName = $_POST['subject_names'];
    if (!$this->callById->doesStudentIdExist('school.classes', $studentId)) {
      return 'Student id did not match';
    }
    if (!$this->callById->doesTeacherIdExist('school.classes', $teacherId)) {
      return 'Teacher id did not match';
    }
    $scoresExist = $this->database->checkExistingScore($studentId, $teacherId, $subjectName);
    return $scoresExist;
  }
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

  private function validateStudentId($input)
  {
    $rules = [
      ['required', 'Required student id'],
      ['integer', 'Student id must be a number'],
    ];
    //  * check if student_id match the current student_id or exists
    if (!$this->callById->if_user_exists('school.users', $_POST['student_id'], 1)) { // check if teacher user_id is match 
      return 'Student not found';
    }
    return $input->number($_POST['student_id'], $rules);
  }
  private function validateTeacherId($input)
  {
    $rules = [
      ['required', 'Required teacher id'],
      ['integer', 'Teacher id must be a number'],
    ];

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