<?php

namespace Thesis\model\load;

use Thesis\config\CallById;
use Thesis\controllers\main\MainController;

class SubjectLoader extends MainController
{
  protected $callByID;
  public function __construct(CallById $callByID)
  {
    parent::__construct();
    $this->callByID = $callByID;
  }
  public function loadSubject()
  {
    if (isset($_POST['name']) && $_POST['name'] !== '') {
      $name = $_POST['name'];
      $subjectsData = $this->callByID->get_subjects_by_name('school.subjects_repositories', $name);
      echo json_encode($subjectsData, JSON_PRETTY_PRINT);
    } else {
      http_response_code(400); // Bad Request
    }
  }
}
