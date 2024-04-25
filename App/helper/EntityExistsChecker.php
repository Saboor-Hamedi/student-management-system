<?php

namespace Thesis\helper;

class EntityExistsChecker
{

  protected  $database;
  public function __construct($database)
  {
    $this->database = $database;
  }
  public  function doesEntityIdExist($table, $entityIdField)
  {
    $sql = "SELECT $entityIdField FROM $table WHERE $entityIdField = ? LIMIT 1";
    $params = [$entityIdField];
    try {
      $result = $this->database->query($sql, $params);
      return count($result) > 0;
    } catch (\Exception $e) {
      // Handle exception as needed
      // For example: log the error, throw a specific exception, etc.
      throw $e;
    }
  }
}
