<?php
// declare(strict_types=1);
namespace Thesis\config;

use Thesis\functions\Roles;

class Auth
{
  const HOME_PATH = 'http://localhost:8888/views/home.php';

  public static function authenticate(array $allowedRoles = [])
  {
    self::startSession();
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
      // User is not logged in, redirect to the login page
      self::redirect("/");
    }

    // Check if allowedRoles is an array
    if (!is_array($allowedRoles)) {
      throw new \InvalidArgumentException("Allowed roles must be provided as an array");
    }

    // Check if user's role is allowed to access the page
    $roles = $_SESSION['roles'];
    if (!empty($allowedRoles) && !in_array($roles, $allowedRoles)) {
      // User's role is not allowed to access the page, redirect to home.php
      self::redirect(self::HOME_PATH);
    }
  }

  public static function logoutGuard()
  {
    self::startSession();


    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
      // User is already logged in, redirect to home.php
      self::redirect(self::HOME_PATH);
    }
  }

  private static function redirect(string $url)
  {
    self::startSession();

    // Ensure that output buffering is turned on before calling header
    if (!headers_sent()) {
      header("Location: " . $url);
      exit();
    } else {
      // Handle the case where headers have already been sent
      echo "<script>window.location.replace('$url');</script>";
      exit();
    }
  }

  public static function isAuth($user_id)
  {
    self::startSession();

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
      // User is not logged in, return false
      return false;
    }
    // Check if the session's user_id matches the provided user_id
    return $_SESSION['user_id'] == $user_id;
  }
  public static function user_id()
  {
    self::startSession();
    // Check if the user_id session variable is set
    if (isset($_SESSION['user_id'])) {
      // Return the user_id
      return $_SESSION['user_id'];
    } else {
      // Handle the case where user_id session variable is not set
      throw new \RuntimeException("User ID not found in session");
    }
  }
  public static function isAdmin(): bool
  {
    self::startSession();

    $userRole = $_SESSION['roles'];
    return $userRole == 0;
  }

  public static function isTeacher(): bool
  {
    self::startSession();

    $userRole = $_SESSION['roles'];
    return $userRole == 2;
  }

  public static function isStudent(): bool
  {
    self::startSession();

    $userRole = $_SESSION['roles'];
    return $userRole == 1;
  }

  private static function startSession()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }
}
