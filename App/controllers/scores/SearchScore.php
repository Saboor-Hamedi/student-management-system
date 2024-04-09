<?php

namespace Thesis\controllers\scores;

use Thesis\config\Auth;
use Thesis\config\Database;

class SearchScore
{
  protected $database;
  protected $auth;
  public function __construct(Database $database)
  {
    $this->database = $database;
  }
  public function searchScores()
  {
    $user_id = Auth::user_id();
    $sql = "SELECT scores.id AS score_id, scores.teacher_id AS teacher_id,
    scores.student_id AS student_id, scores.grades_id AS grades_id, 
    scores.subject_names AS subject_names, scores.score AS score,
    scores.created_at AS created_at, students.lastname FROM scores
    INNER JOIN grades ON scores.grades_id = grades.id
    INNER JOIN teachers ON scores.teacher_id = teachers.teacher_id
    INNER JOIN students ON scores.student_id = students.student_id
    WHERE scores.teacher_id = :user_id ORDER BY grades.grade DESC";
    $params = [':user_id' => $user_id];
    $result = $this->database->executeQuery($sql, $params);
    return $result;
  }
}
