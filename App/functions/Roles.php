<?php

namespace Thesis\functions;

class Roles
{
  private static $roleCache = [];
  public const LEVEL = [
    'isAdmin' => 0,
    'isStudent' => 1,
    'isTeacher' => 2,
    'isParent' => 3,
  ];


  public static function getRole(string $roleName)
  {
    if (!isset(self::$roleCache[$roleName])) {
      self::$roleCache[$roleName] = self::LEVEL[$roleName] ?? 'Role not found.';
    }
    return self::$roleCache[$roleName];;
  }
  // public static function getRole(string $roleName)
  // {
  //   if (!isset(self::$roleCache[$roleName])) {
  //     self::$roleCache[$roleName] = self::LEVEL[$roleName] ?? 'Role not found.';
  //     return self::$roleCache[$roleName]; // Echo the role number
  //   }
  // }
}