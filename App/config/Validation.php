<?php

namespace Thesis\config;

use DateTime;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

/**
 * Summary of Validation
 */
class Validation
{
  /**
   * Summary of string
   * @param mixed $input
   * @param mixed $validation_rules
   * @return mixed
   */
  public function string($input, $validation_rules)
  {
    foreach ($validation_rules as $rule) {
      $rule_name = $rule[0];
      $rule_message = $rule[1];

      switch ($rule_name) {
        case 'required':
          if (empty($input)) {
            return $rule_message;
          }
          break;
        case 'min_length':
          $min_length = $rule[2];
          if (strlen($input) < $min_length) {
            return $rule_message;
          }
          break;
      }
    }
    return ''; // No validation errors
  }

  /**
   * Summary of validate_email
   * @param mixed $email
   * @return string
   */
  // public function email($email)
  // {
  //     if (empty($email)) {
  //         return 'Email required';
  //     }
  //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  //         return 'Invalid email';
  //     }
  //     return ''; //no error 
  // }
  public function email($email)
  {
    if (empty($email)) {
      return 'Email required';
    }
    $validateEmail = new EmailValidator();
    $multipleValidations = new MultipleValidationWithAnd([
      new RFCValidation(),
      new DNSCheckValidation()
    ]);
    if (!$validateEmail->isValid($email, $multipleValidations)) {
      return 'Invalid email';
    } else {
      return false;
      // Assuming you want to return false if the email is valid
    }
  }

  // password validation 
  /**
   * Summary of password
   * @param mixed $password
   * @return mixed
   */
  public function password($input, $validation_rules)
  {
    foreach ($validation_rules as $rule) {
      $rule_name = $rule[0];
      $rule_message = $rule[1];
      switch ($rule_name) {
        case 'required':
          if (empty($input)) {
            return $rule_message;
          }
          break;
        case 'min_length':
          $min_length = $rule[2];
          if (strlen($input) < $min_length) {
            return $rule_message;
          }
          break;
        default:
          break;
      }
    }
    return ''; // validation  errors
  }
  /**
   * Summary of post_code
   * @param mixed $post_code
   * @param mixed $validation_rules
   * @return mixed
   */
  public function post_code($post_code, $validation_rules)
  {
    foreach ($validation_rules as $rule) {
      $rule_name = $rule[0];
      $rule_message = $rule[1];

      switch ($rule_name) {
        case 'required':
          if (empty($post_code)) {
            return $rule_message;
          }
          break;
        case 'pattern':
          $pattern = $rule[2];
          if (!preg_match($pattern, $post_code)) {
            return $rule_message;
          }
          break;
        case 'min_length':
          $min_length = $rule[2];
          if (strlen($post_code) < $min_length) {
            return $rule_message;
          }
          break;
      }
    }

    return '';
  }


  public function phone_number($phone_number, $validation_rules)
  {
    foreach ($validation_rules as $rule) {
      $rule_name = $rule[0];
      $rule_message = $rule[1];

      switch ($rule_name) {
        case 'required':
          if (empty($phone_number)) {
            return $rule_message;
          }
          break;
        case 'pattern':
          $pattern = $rule[2];
          if (!preg_match($pattern, $phone_number)) {
            return $rule_message;
          }
          break;
        case 'min_length':
          $min_length = $rule[2];
          if (strlen($phone_number) < $min_length) {
            return $rule_message;
          }
          break;
      }
    }

    return '';
  }

  public function number($number, $validation_rules)
  {
    foreach ($validation_rules as $rule) {
      $rule_name = $rule[0];
      $rule_message = $rule[1];

      switch ($rule_name) {
        case 'required':
          if (empty($number)) {
            return $rule_message;
          }
          break;
        case 'integer': // Check if $number is an integer
          if (!is_numeric($number) || intval($number) != $number) {
            return $rule_message;
          }
          break;
        case 'max_value':
          $max_value = isset($rule[2]) ? $rule[2] : null;
          if ($max_value !== null && $number > intval($max_value)) {
            return $rule_message;
          }
          break;
        case 'min_value':
          $min_value = isset($rule[2]) ? $rule[2] : null;
          if ($min_value !== null && $number < intval($min_value)) {
            return $rule_message;
          }
          break;
      }
    }

    // If all validation rules pass, return an empty string to indicate success
    return '';
  }

  /**
   * Summary of options
   * @param mixed $option
   * @return string
   */
  public function options($option)
  {
    if ($option === '') {
      return 'Option is required';
    }
    return ''; // No validation errors
  }

  public function time($input, $validation_rules, $datetime_format = null)
  {
    foreach ($validation_rules as $rule) {
      $rule_name = $rule[0];
      $rule_message = $rule[1];

      switch ($rule_name) {
        case 'required':
          if (empty($input)) {
            return $rule_message;
          }
          break;
        case 'min_length':
          $min_length = $rule[2];
          if (strlen($input) < $min_length) {
            return $rule_message;
          }
          break;
      }
    }

    if ($datetime_format !== null) {
      $parsed_datetime = DateTime::createFromFormat($datetime_format, $input);
      if (!$parsed_datetime || $parsed_datetime->format($datetime_format) !== $input) {
        return 'Invalid date and time format. Please use ' . $datetime_format . ' format.';
      }

      if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $input)) {
        return 'Invalid date and time format. Please use "YYYY-MM-DD HH:MM" format.';
      }
    }

    return ''; // No validation errors
  }
}
