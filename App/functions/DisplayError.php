<?php 

trait DisplayError{
  public function error($errors, $field){
    if (isset($errors[$field])) {
      echo '<span class="error">' . $errors[$field] . '</span>';
  }
  }
}