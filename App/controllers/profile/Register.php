<?php

namespace Thesis\controllers\profile;

use Exception;
use Thesis\config\CallById;
use Thesis\config\ClearInput;
use Thesis\config\Database;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;

class Register
{
    private $database;
    private $errors = [];
    private $callbyid = '';
    function __construct()
    {
        $this->callbyid = new CallById();
        $this->database = Database::GetInstance();
    }

    public function search_for_students_profile()
    {

        if (isset ($_POST['roles_id']) && $_POST['roles_id'] !== '') {
            $name = $_POST['roles_id'];
            $students_data = $this->callbyid->get_by_roles('school.users', $name, 1);
            echo json_encode($students_data, JSON_PRETTY_PRINT);
        } else {
            if (isset ($_POST['roles_id'])) {
                FlashMessage::setMessage('Invalid student ID', 'info');
            }
        }
    }

    public function validate_profile(
        $student_profile_id,
        $search_student_profile_name,
        $student_lastname,
        $student_sex
    ) {
        try {
            $validate = new Validation();
            // ! validate student_profile_id
            $student_profile_id_error = $validate->number($student_profile_id, [
                ['required', 'Required student ID'],
                ['integer', 'ID must be integer'],
                ['min_value', 'ID Must not be less then 1', 1],
            ]);
            $search_student_profile_name_error = $validate->string($search_student_profile_name, [
                ['required', 'Required name'],
            ]);
            $student_lastname_error = $validate->string($student_lastname, [
                ['required', 'Required name'],
            ]);

        } catch (Exception $e) {
            FlashMessage::addMessageWithException('Something went wrong', $e, 'danger');
        }
        // ! check for student id, if its valid id
        if (!$this->callbyid->if_user_exists('school.users', $student_profile_id, 1)) {
            $this->errors['student_profile_id'] = 'Student ID did not match';
        }
        if (!empty ($student_profile_id_error)) {
            $this->errors['student_profile_id'] = $student_profile_id_error;
        }
        // ! student name validation
        if (!$this->callbyid->get_by_roles('school.users', $search_student_profile_name, 1)) {
            $this->errors['search_student_profile_name'] = 'Student name did not match';
        }
        if (!empty ($search_student_profile_name_error)) {
            $this->errors['search_student_profile_name'] = $search_student_profile_name_error;
        }
        // ! lastname
        if (!empty ($student_lastname_error)) {
            $this->errors['student_lastname'] = $student_lastname_error;
        }
        

        $student_sex_error = $validate->validated_select_option($student_sex);
        if (!empty ($student_sex_error)) {
            $this->errors['student_sex'] = $student_sex_error;
        }
        // ! display error
        if (!empty ($this->errors)) {
            return ['errors' => $this->errors];
        }
        try {
            $check_id = $this->callbyid->if_student_id_exists('school.students', $student_profile_id);
            if (!empty ($check_id)) {
                FlashMessage::setMessage('Profile exists', 'info');
            } else {
                $data = [

                    'student_id' => $student_profile_id,
                    'lastname' => $student_lastname,
                    'sex' => $student_sex,
                ];

                $insert_result = $this->database->insert('school.students', $data);
                if ($insert_result) {
                    FlashMessage::setMessage('Student added into students table.', 'primary');
                    ClearInput::clear(
                        'student_profile_id',
                        'search_student_profile_name',
                        'student_lastname',
                        'student_sex',
                    );
                } else {
                    FlashMessage::setMessage('Something went wrong!', 'danger');
                }
            }
        } catch (Exception $e) {
            FlashMessage::addMessageWithException('Something went wrong', $e, 'danger');
        }
    }
}