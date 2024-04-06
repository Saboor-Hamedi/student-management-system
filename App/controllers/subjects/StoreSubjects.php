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
