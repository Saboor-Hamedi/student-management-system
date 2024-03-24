<?php require_once __DIR__ . '/../../App/config/path.php'; ?>
<?php path("header"); ?>
<?php
use Thesis\config\Auth;
use Thesis\config\FlashMessage;
use Thesis\controllers\UpdateUserInfo; ?>
<?php Auth::isLogged([0]); ?>
<?php

$user_update = new UpdateUserInfo();
?>
<?php
$errors = [];
$success = '';
$username = '';
$email = '';
$password = '';
$select_roles = '';

$id = isset ($_GET['id']) ? $_GET['id'] : null;
if ($id) {
  $unhashed_id = decrypt($id, 'no@hack_$_can_%_be_^_done');
  // Check if the ID exists
  $user_results = $database->getById('school.users', $unhashed_id);
  // Proceed with the update if the ID exists
  if (isset ($_POST['update_userinfo_button'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $select_roles = $_POST['select_roles'];
    $user_update->update_userinfo($unhashed_id, $username, $email, $password, $select_roles);
  }
}

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
                <?php $user_results = $database->getById('school.users', $unhashed_id); ?>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $id; ?>">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Full Name"
                          value="<?php echo $user_results['username'] ?? ''; ?>">
                        <span class="error">
                          <?php
                          if (isset ($errors['username'])) {
                            echo $errors['username'];
                          }
                          ?>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="email" placeholder="Example@gmail.com"
                          value="<?php echo $user_results['email'] ?? ''; ?>">
                        <span class="error">
                          <?php
                          if (isset ($errors['email'])) {
                            echo $errors['email'];
                          }
                          ?>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <span class="error">
                          <?php
                          if (isset ($errors['password'])) {
                            echo $errors['password'];
                          }
                          ?>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <select class="form-select" name=" select_roles">
                        <option value="">Open this select menu</option>
                        <option value="0" <?php echo $user_results['roles'] == 0 ? 'selected' : ''; ?>>Admin</option>
                        <option value="1" <?php echo $user_results['roles'] == 1 ? 'selected' : ''; ?>>Student</option>
                        <option value="2" <?php echo $user_results['roles'] == 2 ? 'selected' : ''; ?>>Teacher</option>
                      </select>
                      <span class="error">
                        <?php
                        if (isset ($errors['select_roles'])) {
                          echo $errors['select_roles'];
                        }
                        ?>
                      </span>
                    </div>
                  </div>
                  <div class="mt-3">
                    <button type="submit" name="update_userinfo_button" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div>
    </section>
</div>
<?php path("footer"); ?>