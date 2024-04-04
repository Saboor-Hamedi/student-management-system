<?php

namespace Thesis\controllers\students;

use Thesis\config\Auth;
use Thesis\controllers\main\MainController;

class Schedule extends MainController
{
  public function fetchSchedule()
  {
    $sql = "SELECT * FROM classes 
    INNER JOIN teachers on classes.teacher_id=teachers.teacher_id
    WHERE student_id = :user_id ORDER BY classes.grades desc";

    $params = [
      ':user_id' => Auth::user_id(),
    ];
    $classes = $this->database->executeQuery($sql, $params);
    // Group classes by grade
    if(is_array($classes) || is_object($classes)):
    $groupedClasses = [];
      foreach ($classes as $class) {
        $gradeName = $class['grades']; // Assuming 'grades' is the field for grade name in your classes table
        if (!isset($groupedClasses[$gradeName])) {
          $groupedClasses[$gradeName] = [];
        }
        $groupedClasses[$gradeName][] = $class;
      }
      return $groupedClasses;
    else:
      return [];
    endif;
   
  }
}
