<?php

use Faker\Factory;
use Thesis\config\FlashMessage;
use Thesis\faker\FakeData;

 session_start();  ?>
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php require_once __DIR__ . '../../vendor/autoload.php'; ?>
<?php define('BASE_URL', 'http://localhost:8888/views'); ?>


<?php
use Thesis\config\Database;
use Thesis\faker\ClassesFakeData;

$database = Database::GetInstance();
$connection = $database->connect();

require_once __DIR__ . '/functions/assets.php';
require_once __DIR__ . '/config/functions.php';
?>
<?php $factory = Faker\Factory::create(); ?>
<?php $flash = new FlashMessage(); ?>
<?php $fake = new ClassesFakeData($database, $flash);?>
<?php //$fake->fakeClasses() ?>
<script>
// window.addEventListener('unload', function() {
//     var xhr = new XMLHttpRequest();
//     xhr.open('GET', '../public/include/logout.php', true); // Replace 'logout.php' with the URL of your logout script
//     xhr.send();
// });
</script>



<?php 

if (isset($_SESSION['user_id'])) {
  $roles = (int)$_SESSION['roles'];
  $user_id = $_SESSION['user_id'];
  $username = $_SESSION['username'];
}

