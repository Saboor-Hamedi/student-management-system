<?php

namespace Thesis\controllers\subjects;

use Thesis\config\CallById;
use Thesis\config\Database;

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
        if (isset($_POST['roles_id']) && $_POST['roles_id'] !== '') {
            $roles_id = $_POST['roles_id'];
            $teacher_data = $this->callbyid->get_by_roles('school.users', $roles_id, 2);
            echo json_encode($teacher_data, JSON_PRETTY_PRINT);
        } else {
            http_response_code(400); // Bad Request
        }
    }
    public function loadStudent()
    {
        if (isset($_POST['roles_id']) && $_POST['roles_id'] !== '') {
            $roles_id = $_POST['roles_id'];
            $teacher_data = $this->callbyid->get_by_roles('school.users', $roles_id, 1);
            echo json_encode($teacher_data, JSON_PRETTY_PRINT);
        } else {
            http_response_code(400); // Bad Request
        }
    }
    public function loadSubject()
    {
        if (isset($_POST['name']) && $_POST['name'] !== '') {
            $name = $_POST['name'];
            $subjectsData = $this->callbyid->get_subjects_by_name('school.subjects_repositories', $name);
            echo json_encode($subjectsData, JSON_PRETTY_PRINT);
        } else {
            http_response_code(400); // Bad Request
        }
    }
    public function loadGrade()
    {
        if (isset($_POST['name']) && $_POST['name'] !== '') {
            $name = $_POST['name'];
            $subjectsData = $this->callbyid->get_subjects_by_name('school.grades', $name);
            echo json_encode($subjectsData, JSON_PRETTY_PRINT);
        } else {
            http_response_code(400); // Bad Request
        }
    }
}
