<?php

namespace Thesis\controllers;

use Exception;
use Thesis\config\CallById;
use Thesis\config\ClearInput;
use Thesis\config\Database;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;

class TeachersProfile
{
    private $database;
    private $errors = [];
    public $callbyid;
    function __construct()
    {
        $this->database = Database::GetInstance();
        $this->callbyid = new CallById();
    }
    public function validate_profile(
        $selected_teacher_id,
        $search_teacher_live,
        $teacher_lastname,
        $teacher_qualification_lastname,
        $length_of_experience,
        $subject_taught,
        $teacher_expecialization
    ) {
        try {
            $validate = new Validation();
            // ! validate selected_teacher_id 
            $selected_teacher_id_error = $validate->number($selected_teacher_id, [
                ['required', 'Required teacher ID'],
                ['integer', 'ID must be integer'],
                ['min_value', 'ID Must not be less then 1', 1]
            ]);
            $search_teacher_live_error = $validate->string($search_teacher_live, [
                ['required', 'Required name']
            ]);
            $teacher_lastname_error = $validate->string($teacher_lastname, [
                ['required', 'Required Last name'],
                ['min_length', 'Name atleast show be 5 character', 5]
            ]);
            $teacher_qualification_lastname_error = $validate->string($teacher_qualification_lastname, [
                ['required', 'Required qualifications']
            ]);
            //  ! string are different, you can make if you want for experiences
            $length_of_experience_error = $validate->phone_number($length_of_experience, [
                ["required", "Required Experiences"],
                ["pattern", "Experiences must contain numbers", '/^[0-9]+$/'],
                ['min_length', 'Experiences at least 1 year', 1]

            ]);
            $teacher_expecialization_error = $validate->string($teacher_expecialization, [
                ['required', 'Required expecialization']
            ]);
        } catch (Exception $e) {
            FlashMessage::addMessageWithException('Something went wrong', $e, 'danger');
        }

        // ! check for teacher id, if its valid id
        if (!$this->callbyid->if_user_exists('school.users', $selected_teacher_id, 2)) {
            $this->errors['selected_teacher_id'] = 'Teacher ID did not match';
        }
        if (!empty($selected_teacher_id_error)) {
            $this->errors['selected_teacher_id'] = $selected_teacher_id_error;
        }
        // ! teacher name validation
        if (!$this->callbyid->get_by_roles('school.users', $search_teacher_live, 2)) {
            $this->errors['search_teacher_live'] = 'Teacher name did not match';
        }
        if (!empty($teacher_lastname_error)) {
            $this->errors['teacher_lastname'] = $teacher_lastname_error;
        }
        if (!empty($search_teacher_live_error)) {
            $this->errors['search_teacher_live'] = $search_teacher_live_error;
        }
        // ! lastname 
        if (!empty($teacher_qualification_lastname_error)) {
            $this->errors['teacher_qualification_lastname'] = $teacher_qualification_lastname_error;
        }
        // ! validate email 

        if (!empty($length_of_experience_error)) {
            $this->errors['length_of_experience'] = $length_of_experience_error;
        }


        if (!empty($teacher_expecialization_error)) {
            $this->errors['teacher_expecialization'] = $teacher_expecialization_error;
        }
        $subject_taught_erorr = $validate->options($subject_taught);
        if (!empty($subject_taught_erorr)) {
            $this->errors['subject_taught'] = $subject_taught_erorr;
        }
        // ! display error 
        if (!empty($this->errors)) {
            return ['errors' => $this->errors];
        }
        try {
            $check_id = $this->callbyid->if_teacher_id_exists('school.teachers', $selected_teacher_id);
            if (!empty($check_id)) {
                FlashMessage::setMessage('Profile exists', 'info');
            } else {
                $data = [

                    'teacher_id' => $selected_teacher_id,
                    'qualification' => $teacher_qualification_lastname,
                    'teacher_lastname' => $teacher_lastname,
                    'experience' => $length_of_experience,
                    'subjects_taught' => $subject_taught,
                    'specialization' => $teacher_expecialization,
                ];

                $insert_result = $this->database->insert('school.teachers', $data);
                if ($insert_result) {
                    ClearInput::clear(
                        "selected_teacher_id",
                        "search_teacher_live",
                        "teacher_lastname",
                        "teacher_qualification_lastname",
                        "length_of_experience",
                        "subject_taught",
                        "teacher_expecialization",
                    );
                    FlashMessage::setMessage('Profile Updated', 'primary');
                } else {
                    FlashMessage::setMessage('Profile did not updated', 'danger');
                }
            }
        } catch (Exception $e) {
            FlashMessage::addMessageWithException('Something went wrong', $e, 'danger');
        }
    }
}
