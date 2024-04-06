<?php

namespace Thesis\model\load;

use Exception;
use Thesis\config\CallById;
use Thesis\controllers\main\MainController;

/**  
 * @access views/subject/subject.php
 * Class StudentLoader
 *
 * This class is responsible for loading student data and handling AJAX requests for student searches.
 *
 * @package Thesis\model\load
 */
class StudentLoader extends MainController
{
  protected $callByID;
  /**
   * StudentLoader constructor.
   * @param CallById $callByID An instance of CallById used for database interactions.
   */
  public function __construct(CallById $callByID)
  {
    parent::__construct();
    $this->callByID = $callByID;
  }
  /**
   * Load student data based on the provided role ID.
   * This method retrieves student data from the database based on the specified role ID and returns
   * the data as a JSON response.
   * @return void The student data is echoed as a JSON response.
   */
  public function loadStudent()
  {
    try {
      // Check if roles_id is provided and not empty
      if (isset($_POST['roles_id']) && $_POST['roles_id'] !== '') {
        $roles_id = $_POST['roles_id'];
        $student_data = $this->callByID->get_by_roles('school.users', $roles_id, 1);
        echo json_encode($student_data, JSON_PRETTY_PRINT);
      } else {
        http_response_code(400); // Bad Request if roles_id is not provided or empty
      }
    } catch (Exception $e) {
      echo json_encode(['error' => $e->getMessage()]);
    }
  }
}
