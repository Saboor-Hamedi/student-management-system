<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

<?php

/**
 * * This is the teachers profile, where admin update teachers
 * * If a teacher profile is not updated, a teacher would not be able to 
 * * take any class. 
 * * The teacher profile updates through the TeacherProfileUpdate.php
 * * This file is only access through admin user
 */
?>
<?php require_once __DIR__ . '/../../../App/config/path.php'; ?>
<?php path('header'); ?>
<?php

use Thesis\config\CallById;
use Thesis\controllers\teachers\TeacherProfileUpdate;
use Thesis\config\Auth;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\functions\Roles;

?>

<?php Auth::authenticate([Roles::getRole('isTeacher')]); ?>
<!-- insert data -->
<?php $callByID = new CallById(); ?>
<?php $validation = new Validation(); ?>
<?php $updateProfile = new TeacherProfileUpdate($callByID, $validation); ?>
<?php $errors = $updateProfile->UpdateProfile(); ?>
<?php path('navbar'); // header
?>
<?php path(
  'sidebar',
  [
    'roles' => $roles,
    'username' => $username,
    'user_id' => $user_id,
    'database' => $database
  ]
); // sidebar 
?>

<div class="content-wrapper">
  <div class="card"></div>
    <section class="content">
      

    </section>
</div>

<?php path('footer'); ?>
