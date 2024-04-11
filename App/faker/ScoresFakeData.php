<?php

namespace Thesis\faker;

use Faker\Factory; // Import the Factory class from Faker
use Thesis\config\Database;
use Thesis\config\FlashMessage;

class ScoresFakeData
{
  protected $faker;
  protected $database;
  protected $flash;

  public function __construct(Database $database, FlashMessage $flash)
  {
    $this->database = $database;
    $this->flash = $flash;
    $this->faker = Factory::create(); // Initialize the Faker generator
  }

  public function studentTable($studentId)
  {
    $sql = "SELECT student_id FROM students WHERE student_id = :student_id";
    $params = [':student_id' => $studentId];
    return $this->database->executeQuery($sql, $params); // Execute query with parameters
  }

  public function teacherTable($teacherId)
  {
    $sql = "SELECT teacher_id FROM teachers WHERE teacher_id = :teacher_id";
    $params = [':teacher_id' => $teacherId];
    return $this->database->executeQuery($sql, $params); // Execute query with parameters
  }

  public function fakeScores()
  {
    // Number of records to insert
    $numRecords = 10;

    for ($i = 0; $i < $numRecords; $i++) {
      // Randomly select a student and teacher ID
      $randomStudentId = $this->faker->randomElement($this->getStudentIds())['student_id'];
      $randomTeacherId = $this->faker->randomElement($this->getTeacherIds())['teacher_id'];

      // Generate random subject names and grades
      $subjectName = $this->faker->randomElement(['Math', 'Science', 'History', 'English', 'Geography']);
      $grades = $this->faker->numberBetween(1, 12);

      // Insert into scores table
      $sql = "INSERT INTO scores (student_id, teacher_id, grades_id, subject_names, score, created_at) 
                    VALUES (:student_id, :teacher_id, :grades_id, :subject_names, :score, :created_at)";
      $params = [
        ':student_id' => $randomStudentId,
        ':teacher_id' => $randomTeacherId,
        ':grades_id' => $grades,
        ':subject_names' => $subjectName,
        ':score' => $grades,
        ':created_at' => date('Y-m-d H:i:s')
      ];

      // Execute the SQL query with prepared parameters
      $this->database->executeQuery($sql, $params);
    }

    // Display success message using FlashMessage
    // $this->flash->setMessage('Fake scores inserted successfully', 'success');
  }

  private function getStudentIds()
  {
    $sql = "SELECT student_id FROM students";
    return $this->database->executeQuery($sql); // Fetch all student IDs
  }

  private function getTeacherIds()
  {
    $sql = "SELECT teacher_id FROM teachers";
    return $this->database->executeQuery($sql); // Fetch all teacher IDs
  }
}
