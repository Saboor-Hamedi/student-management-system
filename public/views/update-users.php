<?php require_once __DIR__ . '/../../App/config/path.php'; ?>
<?php path("header"); ?>
<?php

use Thesis\config\Auth;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\controllers\profile\ProfileUpdate;
use Thesis\controllers\UpdateUserInfo;
use Thesis\functions\Roles;

?>
<?php Auth::authenticate([Roles::getRole('isAdmin')]); ?>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
$user_update = new UpdateUserInfo();
$profileUpdate = new ProfileUpdate();
$errors = $profileUpdate->update();
?>

<!-- header on the top, Navbar -->
<?php path("navbar"); ?>
<!-- Main Sidebar Container -->
<?php path('sidebar', ['roles' => $roles, 'username' => $username, 'user_id' => $user_id, 'database' => $database]); ?>
<!-- ==== -->
<div class="content-wrapper " style="height: auto;">
  <section class="content">
    <section class="content">
      <?php path("cards"); ?>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update User </h3>
              </div>
              <div class="card-body">
                <?php FlashMessage::displayMessages(); ?>
                <?php $users = $database->getById('school.users', $id); ?>
                <form method="POST" action="<?php ClearInput::selfURL(); ?>?id=<?php echo $id; ?>">
                  <div class="row">
                    <div class="col-lg-12">
                      <!-- <div class="form-group"> -->
                      <input type="hidden" class="form-control" name="user_id" placeholder="User ID" value="<?php echo $id; ?>">
                      <!-- </div> -->
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="username" value="<?php echo $users['username'] ?? ''; ?>" placeholder="Full Name">
                        <?php
                        error($errors, 'username');
                        ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="email" placeholder="Example@gmail.com" value="<?php echo $users['email'] ?? ''; ?>">
                        <?php
                        error($errors, 'email');
                        ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <?php
                        error($errors, 'password');
                        ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <select class="form-select" name=" select_roles">
                        <option value="">Open this select menu</option>
                        <option value="0" <?php echo isset($users['roles']) && $users['roles'] == 0 ? 'selected' : ''; ?>>Admin</option>
                        <option value="1" <?php echo isset($users['roles']) && $users['roles'] == 1 ? 'selected' : ''; ?>>Student</option>
                        <option value="2" <?php echo isset($users['roles']) && $users['roles'] == 2 ? 'selected' : ''; ?>>Teacher</option>

                      </select>
                      <?php
                      error($errors, 'select_roles');
                      ?>

                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" name="update_userinfo_button" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
              <div class="card-footer">
                <p></p>
              </div>
            </div>
          </div>
        </div>

        <div>
    </section>
</div>
<?php path("footer"); ?>