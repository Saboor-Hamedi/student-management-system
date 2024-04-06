<?php

namespace Thesis\config;

use Thesis\config\Database;

class CallById
{
    private $database;

    function __construct()
    {
        $this->database = Database::GetInstance();
    }
    public function get_by_roles($table, $name, $roles)
    {
        $sql = "SELECT id, username FROM $table WHERE username LIKE :name AND roles = :roles LIMIT 5 ";

        $param = [
            ':name' => '%' . $name . '%', // ! Add wildcards to search for partial matches
            ':roles' => $roles
        ];
        $result = $this->database->query($sql, $param);
        if (count($result) > 0) {
            $students = [];
            foreach ($result as $row) {
                $students[] = [
                    'id' => $row['id'],
                    'username' => $row['username']
                ];
            }
            return $students;
        } else {
            return [];
        }
    }
    public function if_user_exists($table, $id, $roles)
    {
        try {
            $sql = "SELECT id FROM $table WHERE id = :id AND roles = :roles  LIMIT 1";
            $params =
                [
                    ':id' => $id,
                    ':roles' => $roles
                ];
            $result = $this->database->query($sql, $params);
            return count($result) > 0;
        } catch (\Exception $e) {
            $this->database->error($e);
        }
    }
    // TODO this goes for Student class
    public function doesStudentIdExist($table, $id)
    {
        $sql = "SELECT student_id FROM $table WHERE student_id = ? ";
        $params = [$id];
        $result = $this->database->query($sql, $params);
        return count($result) > 0;
    }
    // TODO this goes for TeacherProfileUpdate class
    public function doesTeacherIdExist($table, $teacher_id)
    {
        $sql = "SELECT teacher_id FROM $table WHERE teacher_id = ?";
        $params = [$teacher_id];

        try {
            $result = $this->database->query($sql, $params);

            // Check if there are any rows returned
            return count($result) > 0;
        } catch (\Exception $e) {
            // FlashMessage::setMessage('Please check if the teacher is registered', 'info');
            $this->database->error($e);
        }
    }

    public function get_subjects_by_name($table, $name)
    {
        $sql = "SELECT id, name FROM $table WHERE name LIKE :name GROUP BY name LIMIT 12";
        $param = [":name" => '%' . $name . '%'];
        $result = $this->database->query($sql, $param);


        if (count($result) > 0) {
            $subjects = [];
            foreach ($result as $row) {
                $subjects[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                ];
            }
            return $subjects;
        } else {
            return [];
        }
    }
}
