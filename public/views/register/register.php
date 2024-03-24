<?php
require_once __DIR__ . '/../../../App/config/path.php';
path('header');
?>

<?php

use Thesis\config\Auth;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;

?>

<?php Auth::isLogged([0]); ?>

<?php
$fullname_errors = '';
$email_errors = '';
$password_errors = '';
$select_errors = '';
$EmailExists = '';
$validation = new Validation();
$errors = array();
$fullname_rules = [
  ['required', 'Full Name is required'],
  ['min_length', 'Full Name should be at least 2 characters', 2]
];

if (isset ($_POST['make_new_user'])) {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $hashed_password = hash_password($password);
  $select_roles = $_POST['select_roles'];
  $fullname_errors = $validation->string($fullname, $fullname_rules);
  $email_errors = $validation->validate_email($email);
  $password_errors = $validation->validate_password($password);
  $select_errors = $validation->validated_select_option($select_roles);
  if (!empty ($fullname_errors)) {
    $errors['fullname'] = $fullname_errors;
  }

  if (!empty ($email_errors)) {
    $errors['email'] = $email_errors;
  }
  if (!empty ($password_errors)) {
    $errors['password'] = $password_errors;
  }
  if (!empty ($select_errors)) {
    $errors['select_roles'] = $select_errors;
  }

  $EmailExists = $database->EmailExists($email);
  if ($EmailExists) {
    // $errors['EmailExists'] = 'The email already exists.';
    FlashMessage::setMessage('Email already taken', 'info');
  }
  if (empty ($errors)) {
    if ($database->EmailExists($email)) {
    } else {

     $users =  $database->insert('users', [
        'username' => $fullname,
        'email' => $email,
        'password' => $hashed_password,
        'roles' => $select_roles,
      ]);
      if($users){
        // Set success message
        FlashMessage::setMessage('New user added', 'primary');
        $_POST['fullname'] = '';
        $_POST['email'] = '';
        $_POST['password'] = '';
        $_POST['select_roles'] = '';
      }else{
        FlashMessage::setMessage('Something went wrong!', 'danger');
      }
    }
  }
}

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
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class=" row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" name="fullname" placeholder="Full Name"
                        value="<?php echo getInputValue('fullname') ?>" aria-label="Full Name">
                      <span class="error">
                        <?php
                        if (isset ($errors['fullname'])) {
                          echo $errors['fullname'];
                        }
                        ?>
                      </span>

                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" name="email" placeholder="Example@gmail.com"
                        value="<?php echo getInputValue('email') ?>" aria-label="email">
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
                      <input type="password" class="form-control" name="password"
                        value="<?php echo getInputValue('password') ?>" placeholder="Password" aria-label="password">
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
                    <select class="form-select" name="select_roles" value="<?php echo getInputValue('select_roles') ?>">
                      <option value="">Open this select menu</option>
                      <option value="0">Admin</option>
                      <option value="1">Student</option>
                      <option value="2">Teacher</option>
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
                <button type="submit" name="make_new_user" class="btn
                                                        btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php path('footer'); ?>