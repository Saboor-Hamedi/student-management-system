<?php

namespace Thesis\controllers\grade;

use Thesis\config\Auth;
use Thesis\config\Database;
use Thesis\controllers\main\MainController;

class Grades extends MainController
{
 
  public function fetchGrade($grade_id)
  {
    $sql = "SELECT * FROM classes 
    INNER JOIN teachers ON classes.teacher_id = teachers.teacher_id
    INNER JOIN students ON classes.student_id = students.student_id
    WHERE students.student_id = :user_id AND classes.grades = :grade_id
    ORDER BY classes.grades DESC";
    $params = [
      ':user_id' => Auth::user_id(),
      ':grade_id' => $grade_id
    ];
    $grades = $this->database->executeQuery($sql, $params);
    return $grades;
  }
}
