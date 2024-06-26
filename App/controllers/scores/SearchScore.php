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
  public function search($searchText)
  {
    $user_id = Auth::user_id();
    $searchText = '%' . $searchText . '%'; // Prepare the search text for SQL LIKE clause
    $sql = "SELECT scores.id AS score_id, scores.teacher_id AS teacher_id,
    scores.student_id AS student_id, scores.grades_id AS grades_id, 
    scores.subject_names AS subject_names, scores.score AS score,
    scores.created_at AS created_at, scores.isScored AS isScored, students.lastname FROM scores
    INNER JOIN grades ON scores.grades_id = grades.id
    INNER JOIN teachers ON scores.teacher_id = teachers.teacher_id
    INNER JOIN students ON scores.student_id = students.student_id
    WHERE scores.teacher_id = :user_id AND (students.lastname LIKE :searchText OR scores.subject_names LIKE :searchText)
    ORDER BY grades.grade DESC";
    $params = [':user_id' => $user_id, ':searchText' => $searchText];
    $result = $this->database->executeQuery($sql, $params);
    return $result;
  }
  public function searchScores()
  {
    $user_id = Auth::user_id();
    $sql = "SELECT scores.id AS score_id, scores.teacher_id AS teacher_id,
    scores.student_id AS student_id, scores.grades_id AS grades_id, 
    scores.subject_names AS subject_names, scores.score AS score,
    scores.created_at AS created_at, scores.isScored AS isScored,  students.lastname FROM scores
    INNER JOIN grades ON scores.grades_id = grades.id
    INNER JOIN teachers ON scores.teacher_id = teachers.teacher_id
    INNER JOIN students ON scores.student_id = students.student_id
    WHERE scores.teacher_id = :user_id ORDER BY grades.grade DESC";
    $params = [':user_id' => $user_id];
    $result = $this->database->executeQuery($sql, $params);
    if (is_array($result) || is_object($result)) :
      return $result;
    endif;
    return [];
  }
  public function  studentScores($id):array
  {
    $sql = "SELECT classes.id AS class_id, classes.subject_name,classes.start_class, 
               classes.end_class,classes.grades, classes.approve,
               teachers.teacher_id AS teacher_id,teachers.qualification,teachers.teacher_lastname,
               teachers.experience,teachers.subjects_taught,teachers.specialization, 
               students.student_id,students.lastname AS student_lastname, students.sex FROM classes
          INNER JOIN teachers ON classes.teacher_id = teachers.teacher_id
          INNER JOIN students ON classes.student_id = students.student_id
          WHERE classes.id = :id";
    $params = [':id' => $id];
    return $this->database->executeQuery($sql, $params);
  }
}
