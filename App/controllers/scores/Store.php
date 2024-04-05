<?php

namespace Thesis\controllers\scores;
use Thesis\config\CallById;
use Thesis\config\Database;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\config\ClearInput;
class Store 
{
    private $database;
    protected $connection;
    public $errors = [];
    public $callbyid;
    public function __construct()
    {
        $this->database = Database::GetInstance();
        $this->callbyid = new CallById();
    }

    public function validate(
        $student_id,
        $teacher_id,
        $search_student_names,
        $student_grade_id,
        $subject_names,
        $score
    ) {
        $validation = new Validation();

        $student_id_error = $validation->number($student_id, [
            ['required', 'Required Student ID'],
            ['integer', 'Student ID must be number'],
        ]);
        $teacher_id_error = $validation->number($teacher_id, [
            ['required', 'Required Teacher ID'],
            ['integer', 'Teacher ID must be number'],
        ]);

        $search_student_names_error = $validation->string($search_student_names, [
            ['required', 'Required name']
        ]);
        $student_grade_id_error = $validation->number($student_grade_id, [
            ['required', 'Required subjects'],
            ['integer', 'Grade ID must be number'],
        ]);

        $subject_names_error = $validation->string($subject_names, [
            ['required', 'Required Subject']
        ]);
        $score_error = $validation->number($score, [
            ['required', 'Required score'],
            ['integer', 'Score must be a number'],
            ['max_value', 'Score must be less than or equal to 100', 100],
            ['min_value', 'Score must be greater than or equal to 1 and less than 2', 1],
        ]);

        // ======================================================================
        if (!empty($student_id_error)) {
            $this->errors['student_id'] = $student_id_error;
        }
        // ! check if the roles are 2, teachers
        if (!$this->callbyid->if_user_exists('school.users', $student_id, 1)) { // check if teacher userid is match 
            $this->errors['student_id'] = 'This student does not exists';
        }
        if (!empty($teacher_id_error)) {
            $this->errors['teacher_id'] = $teacher_id_error;
        }
        // ! check if student name is empty
        if (!empty($search_student_names_error)) {
            $this->errors['search_student_names'] = $search_student_names_error;
        }
        //  ! validate subjects
        if (!empty($student_grade_id_error)) {
            $this->errors['student_grade_id'] = $student_grade_id_error;
        }

        // ! check if the roles are 1, students
        if (!$this->callbyid->if_user_exists('school.users', $student_id, 1)) { // check if teacher userid is match 
            $this->errors['student_id'] = 'This is account is not a student';
        }
        // ! check if the students id exists 
        if (!$this->callbyid->doesStudentIdExist('school.classes', $student_id)) {
            $this->errors['student_id'] = 'Student ID did not match';
        }
        // ! check if the teacher id exists 
        if (!$this->callbyid->doesTeacherIdExist('school.classes', $teacher_id)) {
            $this->errors['teacher_id'] = 'Teacher ID did not match';
        }
        // ! search with student names, on students table, using ajax
        // if (!$this->callbyid->get_by_roles('school.users', $search_student_names, 1)) {
        //     $this->errors['search_student_names'] = 'Student name did not match';
        // }
        // ! search for students 
        if (!empty($search_student_names_error)) {
            $this->errors['search_student_names'] = $search_student_names_error;
        }
        if (!empty($student_subject_name_error)) {
            $this->errors['student_subject_name'] = $student_subject_name_error;
        }
        if (!empty($subject_names_error)) {
            $this->errors['subject_names'] = $subject_names_error;
        }
        if (!empty($score_error)) {
            $this->errors['score'] = $score_error;
        }
        // check for error
        if (!empty($this->errors)) {
            return ['errors' => $this->errors];
        }
        try {
            // check if the teacher has given scores to the certian student. 
            if ($this->database->checkExistingScore($student_id, $teacher_id, $subject_names)) {
                FlashMessage::setMessage("Teacher ID: {$teacher_id} has already scored student ID: {$student_id} for subject: {$subject_names}", 'danger');
            } else {
                $data = [
                    'student_id' => $student_id,
                    'teacher_id' => $teacher_id,
                    'grades_id' => $student_grade_id,
                    'subject_names' => $subject_names,
                    'score' => $score,
                ];

                $result = $this->database->insert('school.scores', $data);
                if ($result) {
                    ClearInput::clear(
                        'student_id',
                        'teacher_id',
                        'grades_id',
                        'subject_names',
                        'score',
                    );
                    FlashMessage::setMessage('New Score added', 'primary');
                } else {
                    FlashMessage::setMessage('Failed to add score', 'danger');
                }
            }
        } catch (\PDOException  $e) {
            if ($e->getCode() == '23000') {
                FlashMessage::setMessage("Teacher ID: {$teacher_id} did not match", 'danger');
            } else {
                // Handle other database errors
                FlashMessage::setMessage('Failed to add score: ' . $e->getMessage(), 'danger');
            }
        }
    }
  
}
