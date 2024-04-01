<?php

namespace Thesis\controllers\students;

use Thesis\config\Auth;
use Thesis\controllers\main\MainController;

class Scores extends MainController
{
  public function fetchScores()
  {
    $sql = "SELECT * FROM scores
    INNER JOIN grades ON scores.grades_id = grades.id
    INNER JOIN teachers ON scores.teacher_id = teachers.teacher_id
    INNER JOIN students ON scores.student_id = students.student_id
    WHERE scores.student_id = :user_id ORDER BY grades.grade DESC";
    $params = [':user_id' => Auth::user_id()];
    $scores = $this->database->executeQuery($sql, $params);
    // Group scores by grade
    $groupedScores = [];
    foreach ($scores as $score) {
      $gradeName = $score['name']; // Assuming 'name' is the field for grade name in your grades table
      if (!isset($groupedScores[$gradeName])) {
        $groupedScores[$gradeName] = [];
      }
      $groupedScores[$gradeName][] = $score;
    }
    return $groupedScores;
  }
}
