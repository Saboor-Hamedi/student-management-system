<?php 
namespace Thesis\functions;
class HashPassword{

  public static function hash($input)
  {
      return password_hash($input, PASSWORD_DEFAULT);
  }
}