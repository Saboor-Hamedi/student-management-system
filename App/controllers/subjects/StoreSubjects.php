<?php

namespace Thesis\controllers\subjects;
use Thesis\config\CallById;
use Thesis\config\Database;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Exception;
use Thesis\controllers\main\MainController;

class StoreSubjects extends MainController
{
    public $errors = [];
    public $callbyid;
    public function __construct()
    {
        $this->database = Database::GetInstance();
        $this->callbyid = new CallById();
    }
    public function loadTeacher()
    {
        if (isset ($_POST['roles_id']) && $_POST['roles_id'] !== '') {
            $roles_id = $_POST['roles_id'];
            $teacher_data = $this->callbyid->get_by_roles('school.users', $roles_id, 2);
            echo json_encode($teacher_data, JSON_PRETTY_PRINT);
        } else {
            http_response_code(400); // Bad Request
        }
    }
    public function loadStudent()
    {
        if (isset ($_POST['roles_id']) && $_POST['roles_id'] !== '') {
            $roles_id = $_POST['roles_id'];
            $teacher_data = $this->callbyid->get_by_roles('school.users', $roles_id, 1);
            echo json_encode($teacher_data, JSON_PRETTY_PRINT);
        } else {
            http_response_code(400); // Bad Request
        }
    }
    public function loadSubject()
    {
        if (isset ($_POST['name']) && $_POST['name'] !== '') {
            $name = $_POST['name'];
            $subjectsData = $this->callbyid->get_subjects_by_name('school.subjects_repositories', $name);
            echo json_encode($subjectsData, JSON_PRETTY_PRINT);
        } else {
            http_response_code(400); // Bad Request
        }
    }
    public function loadGrade()
    {
        if (isset ($_POST['name']) && $_POST['name'] !== '') {
            $name = $_POST['name'];
            $subjectsData = $this->callbyid->get_subjects_by_name('school.grades', $name);
            echo json_encode($subjectsData, JSON_PRETTY_PRINT);
        } else {
            http_response_code(400); // Bad Request
        }
    }
    // ! load data from all_grades table
    public function load_grades()
    {
        $sql = "SELECT id, name, grade, created_at FROM grades GROUP BY grade";
        $result = $this->database->query($sql);
        if ($result > 0) {
            return $result;
        } else {
            return false;
        }
    }
    public function classes_validation(
        $selected_teacher_id,
        $search_teacher_live,
        $subject_names,
        $student_id,
        $search_student_names,
        $start_subject_time,
        $end_subject_time,
        $select_grades
    ) {
        $validation = new Validation();
        $selected_teacher_id_error = $validation->number($selected_teacher_id, [
            ['required', 'Required teacher ID'],
            ['integer', 'Teacher ID must be integer'],
            ['min_value', 'Teacher must be not less not 1', 1]
        ]);

        $search_teacher_live_error = $validation->string($search_teacher_live, [
            ['required', 'Required name']
        ]);
       
        $student_id_error = $validation->number($student_id, [
            ['required', 'Required student ID'],
            ['integer', 'Student ID must be integer'],
            ['min_value', 'Student must be not less not 1', 1]
        ]);
        $search_student_names_error = $validation->string($search_student_names, [
            ['required', 'Required name']
        ]);
        $start_subject_time_error = $validation->validate_datetime($start_subject_time, [
            ['required', 'Required dateTime']
        ]);
        $end_subject_time_error = $validation->validate_datetime($end_subject_time, [
            ['required', 'Required dateTime']
        ]);
        $select_grades_error = $validation->options($select_grades);
        $subject_name_error = $validation->options($subject_names);
        // ======================================================================

        if (!empty ($selected_teacher_id_error)) {
            $this->errors['selected_teacher_id'] = $selected_teacher_id_error;
        }
        // ! check if the roles are 2, teachers
        if (!$this->callbyid->if_user_exists('school.users', $selected_teacher_id, 2)) { // check if teacher userid is match 
            $this->errors['selected_teacher_id'] = 'This account is not a teacher';
        }
        // ! checks if teacher exists
        if (!$this->callbyid->if_teacher_id_exists('school.teachers', $selected_teacher_id)) {
            $this->errors['selected_teacher_id'] = 'Teacher ID did not match';
        }
        // ! search on through teacher table
        if (!empty ($search_teacher_live_error)) {
            $this->errors['search_teacher_live'] = $search_teacher_live_error;
        }
        //  ! validate subjects
        if (!empty ($subject_name_error)) {
            $this->errors['subject_names'] = $subject_name_error;
        }

        if (!empty ($student_id_error)) {
            $this->errors['student_id'] = $student_id_error;
        }
        // ! check if the roles are 1, students
        if (!$this->callbyid->if_user_exists('school.users', $student_id, 1)) { // check if teacher userid is match 
            $this->errors['student_id'] = 'This is account is not a student';
        }
        // ! check if the students id exists 
        if (!$this->callbyid->if_student_id_exists('school.students', $student_id)) {
            $this->errors['student_id'] = 'Student ID did not match';
        }
        // ! search with student names, on students table, using ajax
        if (!$this->callbyid->get_by_roles('school.users', $search_student_names, 1)) {
            $this->errors['search_student_names'] = 'Student name did not match';
        }
        if (!empty ($search_student_names_error)) {
            $this->errors['search_student_names'] = $search_student_names_error;
        }
        if (!empty ($start_subject_time_error)) {
            $this->errors['start_subject_time'] = $start_subject_time_error;
        }
        if (!empty ($end_subject_time_error)) {
            $this->errors['end_subject_time'] = $end_subject_time_error;
        }
        if (!empty ($select_grades_error)) {
            $this->errors['select_grades'] = $select_grades_error;
        }
        // show error
        if (!empty ($this->errors)) {
            return ['errors' => $this->errors];
        }
        try {
            $data = [
                'teacher_id' => $selected_teacher_id,
                'student_id' => $student_id,
                'subject_name' => $subject_names,
                'start_class' => $start_subject_time,
                'end_class' => $end_subject_time,
                'grades' => $select_grades,
            ];

            $result = $this->database->insert('school.classes', $data);
            if ($result) {
                FlashMessage::setMessage('New class created', 'primary');
                // clear inputs 
                $_POST['selected_teacher_id'] = "";
                $_POST['search_teacher_live']= "";
                $_POST['subject_names']= "";
                $_POST['student_id']= "";
                $_POST['search_student_names']= "";
                $_POST['start_subject_time']= "";
                $_POST['end_subject_time']= "";
                $_POST['select_grades']= "";
                
            } else {
                
                FlashMessage::setMessage('No class created', 'info');
            }
        } catch (Exception $e) {
        FlashMessage::addMessageWithException('Something went wrong', $e, 'danger');
        }
    }
}