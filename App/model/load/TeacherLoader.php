<?php

namespace Thesis\model\load;

use Thesis\config\CallById;
use Thesis\controllers\main\MainController;

class TeacherLoader extends MainController
{
  protected $callByID;
  public function __construct(CallById $callByID)
  {
    parent::__construct();
    $this->callByID = $callByID;
  }
  public function loadTeacher()
  {
    if (isset($_POST['roles_id']) && $_POST['roles_id'] !== '') {
      $roles_id = $_POST['roles_id'];
      $teacher_data = $this->callByID->get_by_roles('school.users', $roles_id, 2);
      echo json_encode($teacher_data, JSON_PRETTY_PRINT);
    } else {
      http_response_code(400); // Bad Request
    }
  }
}
