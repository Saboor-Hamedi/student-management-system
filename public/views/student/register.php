<?php require_once __DIR__ . '/../../../App/config/path.php'; ?>
<?php path('header'); ?>
<?php
use Thesis\config\Auth;
use Thesis\config\CallById;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\controllers\students\Register;
?>
<?php Auth::authenticate([0]); ?>
<?php $callbyid = new CallById(); ?>
<!-- insert data -->
<?php
$register = new Register();
$errors = $register->register();
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
              <h3 class="card-title">Update Students Data</h3>
            </div>
            <div class="card-body">
              <?php
              FlashMessage::displayMessages();
              ?>
              <form method="POST" action="<?php ClearInput::selfURL(); ?>">
                <div class="row">
                  <div class="col-md-12">
                    <!-- <div class="form-group"> -->
                      <input type="hidden" class="form-control" id="student_profile_id" name="student_profile_id" placeholder="student id number" value="<?php echo getInputValue('student_profile_id') ?>" readonly>
                      <?php //error($errors, 'student_profile_id'); ?>
                    <!-- </div> -->
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="search-container">

                        <input type="text" class="form-control" id="search_student_profile_name" name="search_student_profile_name" placeholder="search for students" value="<?php echo getInputValue('search_student_profile_name') ?>">
                        <?php error($errors, 'search_student_profile_name'); ?>
                        <div id="search-results3"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="student_lastname" name="student_lastname" placeholder="student last name" value="<?php echo getInputValue('student_lastname') ?>">
                      <?php error($errors, 'student_lastname'); ?>
                    </div>
                  </div>
                  <!-- end of lastname -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="student_age" name="student_age" placeholder="student age" value="<?php echo getInputValue('student_age') ?>">
                      <?php error($errors, 'student_age'); ?>
                    </div>
                  </div>
                  <!-- end of age -->
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <select class="form-select" name="student_sex">
                        <option value="">Select sex</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>
                      <?php error($errors, 'student_sex'); ?>
                    </div>
                  </div>
                </div>
                <!-- end of sex -->
                <div class="card">
                  <div class="card-footer">
                    <button type="submit" name="student_profile_btn" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="card-footer"><p ></p></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php path('footer'); ?>