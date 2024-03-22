<?php session_start();  ?>
<?php 
require_once __DIR__ . '../../vendor/autoload.php';
define('BASE_URL', 'http://localhost:8888/views');
?>
<?php
const PATH = '../../public/include/';
require_once __DIR__ . '/functions/assets.php';
require_once __DIR__ . '/config/functions.php';
use Thesis\config\Database;

$database = Database::GetInstance();
$connection = $database->GetConnection();

if (isset ($_SESSION['user_id'])) {
  $roles = $_SESSION['roles'];
  $user_id = $_SESSION['user_id'];
  $username = $_SESSION['username'];
  $pageTitle = "Welcome, $username"; // show dynamic title
} else {
  $pageTitle = "Home";
}