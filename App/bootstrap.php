<?php  session_start();  ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php require_once __DIR__ . '../../vendor/autoload.php'; ?>
<?php define('BASE_URL', 'http://localhost:8888/views'); ?>
<?php 
require_once __DIR__ . '/functions/assets.php';
require_once __DIR__ . '/config/functions.php';
?>
<?php
use Thesis\config\Database;
use Thesis\faker\ClassesFakeData;
use Thesis\config\FlashMessage;
use Thesis\seeder\UserTableSeeder;

$database = Database::GetInstance();
$connection = $database->connect();
?>
<?php $factory = Faker\Factory::create(); ?>
<?php $flash = new FlashMessage(); ?>
<?php $fake = new ClassesFakeData($database, $flash);?>
<?php //$fake->fakeClasses() ?>
<?php $userTable = new UserTableSeeder($database);
//$userTable->run();?>
<?php 
if (isset($_SESSION['user_id'])) {
  $roles = (int)$_SESSION['roles'];
  $user_id = $_SESSION['user_id'];
  $username = $_SESSION['username'];
}

