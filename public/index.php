<?php require_once __DIR__ . '/include/header.php'; ?>

<?php
use Thesis\config\Auth;
use Thesis\config\Validation;
use Thesis\controllers\Login;
?>
<?php Auth::logoutGuard(); ?>
<?php
$validate = new Validation();
$login = new Login($database);
$errors = $login->loginUser();
?>
<!-- start -->
<div class="main_div">
  <div class="form">
    <div class="title">Login Form</div>
    <div class="social_icons">
      <a href="#"><i class="fab fa-facebook-f"></i> <span>Facebook</span></a>
      <a href="#"><i class="fab fa-twitter"></i><span>Twitter</span></a>
    </div>
    <!-- Check if login attempt failed -->
    <?php if ($errors === false):?>
      <div class="login-alert flash-message" >Email or password is incorrect</div>
    <?php endif?>
    <!-- form -->
    <form method="POST" class="login-form">
      <div class="input_box">
        <input type="email" name="username" id="username" placeholder="Email@example.com" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ' ' ?>">
        <div class="icon"><i class="fas fa-user"></i></div>
      </div>
      <?php error($errors, 'username'); ?>
      <div class="input_box">
        <input type="password" name="password" id="password" placeholder="Password">
        <div class="icon"><i class="fas fa-lock"></i></div>
      </div>
      <?php error($errors, 'password'); ?>
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
<?php //require_once __DIR__ . '/include/footer.php'; ?>