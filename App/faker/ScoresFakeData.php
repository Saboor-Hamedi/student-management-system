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

 

  public function fakeScores()
  {
    // Number of records to insert
    $numRecords = 2;

    for ($i = 0; $i < $numRecords; $i++) {
      // Randomly select a student and teacher ID
      $randomStudentId = $this->faker->randomElement($this->getStudentIds())['student_id'];
      $randomTeacherId = $this->faker->randomElement($this->getTeacherIds())['teacher_id'];
      $randomGradeId = $this->faker->randomElement($this->getGradeIds())['grade'];

      // Generate random subject names and grades
      $subjectName = $this->faker->randomElement(['Math', 'Science', 'History', 'English', 'Geography']);
      $grades = $this->faker->numberBetween(1, 12);


      // Insert into scores table
      $sql = "INSERT INTO scores (student_id, teacher_id, grades_id, subject_names, score, created_at) 
                    VALUES (:student_id, :teacher_id, :grades_id, :subject_names, :score, :created_at)";
      $params = [
        ':student_id' => $randomStudentId,
        ':teacher_id' => $randomTeacherId,
        ':grades_id' => $randomGradeId,
        ':subject_names' => $subjectName,
        ':score' => $grades,
        ':created_at' => date('Y-m-d H:i:s')
      ];

      // Execute the SQL query with prepared parameters
      $res = $this->database->executeQuery($sql, $params);
      if(!$res){
        return false;
      }
      else{
        $this->flash->setMessage( 'Fake scores inserted successfully', 'success');
      }
    }
    // Display success message using FlashMessage
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
  private function getGradeIds()
  {
    $sql = "SELECT grade FROM grades";
    return $this->database->executeQuery($sql); // Fetch all teacher IDs
  }
}
