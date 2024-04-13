<?php

namespace Thesis\controllers\users;

use Thesis\config\Database;
use Exception;

class DeleteUsers
{
  protected $database;
  protected $connection;
  protected $errors = [];
  public function __construct(Database $database)
  {
    $this->database = $database;
  }
  public function destroy($studentId)
  {
    try {
      $this->database->delete('users', 'id = ' . $studentId);
      return json_encode(array('success' => true));
    } catch (Exception $e) {
      // Handle any exceptions
      $this->errors[] = $e->getMessage();
      return json_encode(array('success' => false, 'error' => $e->getMessage()));
    }
  }
}
