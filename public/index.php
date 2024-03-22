<?php
require_once __DIR__ . '/include/header.php';

use Thesis\config\Auth;
use Thesis\controllers\Login;
use Thesis\controllers\Logout;

// Logout::logout();
?>

<?php Auth::check_loggedout(); ?>
<?php

$login = new Login($database);
?>
<?php
$errors = '';
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the submitted username and password
  $username = $_POST['username'];
  $password = $_POST['password'];
  // Call the loginUser method to perform the login functionality
  $errors = $login->loginUser($username, $password);
  // If there are errors, display them
}
?>
<!-- start -->
<div class="main_div">
<div class="form">
  <div class="title">Login Form</div>
  <div class="social_icons">
    <a href="#"><i class="fab fa-facebook-f"></i> <span>Facebook</span></a>
    <a href="#"><i class="fab fa-twitter"></i><span>Twitter</span></a>
  </div>
  <?php if ($errors) : ?>
      <div class="login-alert">
        <?php
        if (!empty($errors['login'])) {
          echo $errors['login'];
        }
        ?>
      </div>
    <?php endif; ?>
    <!-- form -->
   
   <form method="POST" class="login-form">
    <div class="input_box">
      <input type="email" name="username" id="username" placeholder="Email@example.com" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ' ' ?>">
      <div class="icon"><i class="fas fa-user"></i></div>
    </div>
    <div class="input_box">
      <input type="password" name="password" id="password" placeholder="Password">
      <div class="icon"><i class="fas fa-lock"></i></div>
    </div>
    <div class="option_div">
      <div class="check_box">
        <input type="checkbox">
        <span>Remember me</span>
      </div>
      <div class="forget_div">
        <a href="#">Forgot password?</a>
      </div>
    </div>
      <button type="submit" class="input_box">Login</button>
    <div class="sign_up">
      Not a member? <a href="#">Signup now</a>
    </div>
  </form>
   </div>
</div>
<?php require_once __DIR__ . '/include/header.php'; ?>