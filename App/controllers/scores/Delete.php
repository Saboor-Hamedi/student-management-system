<?php

namespace Thesis\controllers\scores;

use Thesis\config\CallById;
use Thesis\config\Database;

use Exception;

class Delete
{
  private $database;
  protected $connection;
  public $errors = [];
  public $callbyid;
  public function __construct()
  {
    $this->database = Database::GetInstance();
    $this->callbyid = new CallById();
  }
  public function destroy($scoreId)
  {
    try {
      // Call the delete function from the Database class
      $this->database->delete('scores', 'id = ' . $scoreId);
      return json_encode(array('success' => true));
    } catch (Exception $e) {
      // Handle any exceptions
      $this->errors[] = $e->getMessage();
      return json_encode(array('success' => false, 'error' => $e->getMessage()));
    }
  }
}