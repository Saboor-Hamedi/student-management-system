<?php

namespace Thesis\faker;

use Faker\Factory; // Import the Factory class from Faker
use Thesis\config\Database;
use Thesis\config\FlashMessage;

class ClassesFakeData
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

    public function studentTable()
    {
        $sql = "SELECT student_id FROM students";
        return $this->database->executeQuery($sql);
    }

    public function teacherTable()
    {
        $sql = "SELECT teacher_id FROM teachers";
        return $this->database->executeQuery($sql);
    }

    public function fakeClasses()
    {
        // Fetch students and teachers
        $studentIds = $this->studentTable();
        $teacherIds = $this->teacherTable();

        // Number of records to insert
        $numRecords = 10;

        for ($i = 0; $i < $numRecords; $i++) {
            $subjectName = $this->faker->randomElement(['Math', 'Science', 'History', 'English', 'Geography']);
            $startClass = $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s');
            $endClass = $this->faker->dateTimeBetween($startClass, '+1 year')->format('Y-m-d H:i:s');
            $grades = $this->faker->numberBetween(1, 12);

            // Insert into classes table
            $sql = "INSERT INTO classes (teacher_id, student_id, subject_name, start_class, end_class, grades) 
                    VALUES (:teacher_id, :student_id, :subject_name, :start_class, :end_class, :grades)";
            $studentId = $studentIds[array_rand($studentIds)]['student_id'];
            $teacherId = $teacherIds[array_rand($teacherIds)]['teacher_id'];
            $params = [
                ':teacher_id' => $teacherId,
                ':student_id' => $studentId,
                ':subject_name' => $subjectName,
                ':start_class' => $startClass,
                ':end_class' => $endClass,
                ':grades' => $grades
            ];
            $this->database->executeQuery($sql, $params);
            $score = new ScoresFakeData($this->database, $this->flash);
            $score->fakeScores();

            
        }
    }
}
