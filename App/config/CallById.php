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
        $sql = "SELECT id, username FROM $table WHERE username LIKE :name AND roles = $roles LIMIT 5";

        $param = [":name" => "%" . $name . "%"];
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
        $sql = "SELECT id FROM $table WHERE id = ? AND roles = $roles LIMIT 1 ";
        $params = [$id];
        $result = $this->database->query($sql, $params);
        return count($result) > 0;
    }
    // todo check if student id exists
    // todo this goes for Student class
    public function if_student_id_exists($table, $id)
    {
        $sql = "SELECT student_id FROM $table WHERE student_id = ? ";
        $params = [$id];
        $result = $this->database->query($sql, $params);
        return count($result) > 0;
    }
    // todo check if teacher id exists
    // todo this goes for TeachersProfile class
    public function if_teacher_id_exists($table, $teacher_id)
    {
        $sql = "SELECT teacher_id FROM $table WHERE teacher_id = ? ";
        $params = [$teacher_id];
        $result = $this->database->query($sql, $params);
        return count($result) > 0;
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
