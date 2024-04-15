<?php

namespace Thesis\seeder;

use Faker\Factory;
use Thesis\config\Database;
use Thesis\functions\HashPassword;

class UserTableSeeder
{
  protected $database;
  public function __construct(Database $database)
  {
    $this->database = $database;
  }
  public function run()
  {
    $this->create();
  }
  private function create()
  {
    $fake = Factory::create();
    // $fake->seed(10); // always get the same results
    for ($i = 0; $i < 10; $i++) {
      $data = [
        'username' => $fake->name('10'),
        'email' => $fake->email(),
        'password' => HashPassword::hash('123'),
        'roles' => $fake->numberBetween(1, 2),
      ];
      $sql = 'INSERT INTO school.users (username, email, password, roles)
     VALUES (:username, :email, :password, :roles)';
      $this->database->executeQuery($sql, $data);
    }
  }
}
