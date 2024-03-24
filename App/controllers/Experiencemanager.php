<?php

use Thesis\config\Database;
use Thesis\config\Validation;
use Thesis\controllers\Login;

class ExperienceManager
{
    protected $database;
    protected $connection;
    protected $errors = [];

    public function __construct()
    {
        $this->database = Database::GetInstance();
    }

    public function validate_user_experiences($qualifications, $experience, $subjects_taught, $specialization)
    {
        $validation = new Validation();
        $qualifications_errors = $validation->string($qualifications, [
            ['required', 'Qualifications are required'],
            ['min_length', 'Qualifications must be at least 10 characters', 10]
        ]);
        $experience_errors = $validation->number($experience, [
            ['required', 'Experience is required'],
            ['integer', 'Experience must be an integer'],
            ['max_value', 'Experience cannot exceed 50 years', 50], // Maximum value is 50
        ]);
        
        $subjects_taught_errors = $validation->string($subjects_taught, [
            ['required', 'Subjects taught are required'],
            ['min_length', 'Subjects taught must be at least 5 characters', 5]
        ]);
        $specialization_errors = $validation->string($specialization, [
            ['required', 'Specialization is required'],
            ['min_length', 'Specialization must be at least 5 characters', 5]
        ]);
        if (!empty ($qualifications_errors)) {
            $this->errors['qualifications'] = $qualifications_errors;
        }
        if (!empty ($experience_errors)) {
            $this->errors['experience'] = $experience_errors;
        }
        if (!empty ($subjects_taught_errors)) {
            $this->errors['subjects_taught'] = $subjects_taught_errors;
        }
        if (!empty ($specialization_errors)) {
            $this->errors['specialization'] = $specialization_errors;
        }
        if (!empty ($this->errors)) {
            return ['errors' => $this->errors];
        }
    }

    public function update_and_insert_experience($qualifications, $experience, $subjects_taught, $specialization)
    {
        $table_name = 'teachers';
        $login = new Login($this->connection);
        $user_id = $login->getUserId();
        $message = '';
        try {
            // Check if the user_id already exists
            $existing_data = $this->database->query("SELECT * FROM $table_name WHERE user_id = :user_id", ['user_id' => $user_id]);

            if (!empty ($existing_data)) {
                // Update the existing data instead of inserting
                $data = [
                    'qualifications' => $qualifications,
                    'experience' => $experience,
                    'subjects_taught' => $subjects_taught,
                    'specialization' => $specialization,
                    'user_id' => $user_id
                ];

                $where = "user_id = :user_id";
                $this->database->update($table_name, $data, $where);
                $message = "<div class='alert alert-primary' role='alert'>Experience successfully updated</div>";
            } else {
                // Insert the new data
                $data = [
                    'user_id' => $user_id,
                    'qualifications' => $qualifications,
                    'experience' => $experience,
                    'subjects_taught' => $subjects_taught,
                    'specialization' => $specialization
                ];

                $this->database->insert($table_name, $data);
                $message = "<div class='alert alert-success' role='alert'>Experience successfully inserted</div>";
            }
        } catch (PDOException $e) {
            $message = $e->getMessage();
        }
        return $message;
    }
}