<?php session_start();  ?>
<?php
require_once __DIR__ . '../../vendor/autoload.php';
define('BASE_URL', 'http://localhost:8888/views');
?>
<?php

require_once __DIR__ . '/functions/assets.php';
require_once __DIR__ . '/config/functions.php';
use Thesis\config\Database;
$database = Database::GetInstance();
$connection = $database->GetConnection();
?>
<script>
window.addEventListener('unload', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../public/include/logout.php', true); // Replace 'logout.php' with the URL of your logout script
    xhr.send();
});

</script>
<?php 

if (isset($_SESSION['user_id'])) {
  $roles = (int)$_SESSION['roles'];
  $user_id = $_SESSION['user_id'];
  $username = $_SESSION['username'];
}

