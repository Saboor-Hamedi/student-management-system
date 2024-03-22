<?php 
namespace Thesis\config;
class ClearInput {
  public static function clear(...$inputNames) {
      foreach ($inputNames as $inputName) {
          if (isset($_POST[$inputName])) {
              unset($_POST[$inputName]);
          } else {
              return false;
          }
      }
  }
}