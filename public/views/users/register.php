<?php
use Thesis\config\Validation;
require_once __DIR__ . '/../../../App/config/path.php';
path('header');
?>
<?php

use Thesis\config\Auth;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\controllers\users\RegisterUsers;
use Thesis\functions\Roles;
?>
<?php Auth::authenticate([Roles::getRole('isAdmin')]); ?>

<?php
$validation = new Validation();
$store = new RegisterUsers($database, $validation);
$errors = $store->registerUser();
?>
<!-- header on the top, Navbar -->

<?php path('navbar'); ?>
<!-- Main Sidebar Container -->
<?php path('sidebar', ['roles' => $roles, 'username' => $username, 'user_id' => $user_id, 'database' => $database]); ?>
<!-- end insert data -->
<div class="content-wrapper" style="height: auto;">
  <section class="content">
    <?php path('cards'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Register New User</h3>
            </div>
            <div class="card-body">
              <?php FlashMessage::displayMessages(); ?>
              <form method="POST" action="<?php ClearInput::selfURL(); ?>">
                <div class=" row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" name="fullname" placeholder="Full name" value="<?php echo getInputValue('fullname') ?>" aria-label="Full Name">
                      <?php error($errors, 'fullname') ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" name="email" placeholder="Example@gmail.com" value="<?php echo getInputValue('email') ?>" aria-label="email">
                      <?php error($errors, 'email') ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="password" class="form-control" name="password" value="<?php echo getInputValue('password') ?>" placeholder="Password" aria-label="password">
                      <?php error($errors, 'password') ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <select class="form-select" name="select_roles" value="<?php echo getInputValue('select_roles') ?>">
                      <option value="">Select roles</option>
                      <option value="0">Admin</option>
                      <option value="1">Student</option>
                      <option value="2">Teacher</option>
                    </select>
                    <?php error($errors, 'select_roles') ?>
                  </div>
                </div>
                <!-- button -->
                <div class="card">
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="card-footer">
              <p></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php path('footer'); ?>
