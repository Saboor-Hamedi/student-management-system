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
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\functions\Roles;

?>

<?php Auth::authenticate([Roles::getRole('isTeacher')]); ?>
<!-- insert data -->
<?php $callByID = new CallById(); ?>
<?php $validation = new Validation(); ?>
<?php $flash = new FlashMessage(); ?>
<?php $updateProfile = new TeacherProfileUpdate($database, $callByID, $validation, $flash); ?>
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
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">
             Profile
            </div>
          </div>
        <div class="container">
            <div class="profile-image d-flex justify-content-center m-auto p-2 mb-3 bg-success">
                <img src="https://via.placeholder.com/300x300" alt="Profile Image" class="avatar avatar-sm">
            </div>
            <div class="profile-details bg-success">
              <h4>Jordon Lemke</h4>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php path('footer'); ?>
