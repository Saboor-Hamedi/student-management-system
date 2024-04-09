<?php

namespace Thesis\controllers\main;

use Thesis\config\Database;

class MainController
{
  protected $database;
  public function __construct()
  {
    $this->database = Database::GetInstance();
    $this->database->connect();
  }
  public function views($path, $data = [])
  {
    extract($data); // This makes the variables in $data available in the local scope
    $file = __DIR__ . '/../../../public/views/' . $path . '.php'; // Adjust the path accordingly
    if (file_exists($file)) {
      require_once $file;
    } else {
      echo "Error: File '$file' does not exist.";
      return false;
    }
  }
}
