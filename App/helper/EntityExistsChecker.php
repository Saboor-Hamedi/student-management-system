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
    $sql = "SELECT $entityIdField FROM $table WHERE $entityIdField = ?";
    try {
      $params = [$entityIdField];
      $result = $this->database->query($sql, $params);
      return count($result) > 0;
    } catch (\Exception $e) {
    }
  }
  public function checkWithValue($table, $entityIdField, $entityIdValue)
  {
      $sql = "SELECT $entityIdField FROM $table WHERE $entityIdField = ?";
      try {
          $params = [$entityIdValue]; // Use $entityIdValue instead of $entityIdField
          $result = $this->database->query($sql, $params);
          // Check if any row is returned
          return $result !== null && count($result) > 0;
      } catch (\Exception $e) {
          // Handle exception as needed
          // For example: log the error, throw a specific exception, etc.
          throw $e;
      }
  }
  

  
}
