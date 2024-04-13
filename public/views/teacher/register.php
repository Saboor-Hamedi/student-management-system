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

<?php Auth::authenticate([Roles::getRole('isAdmin')]); ?>
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
<div class="content-wrapper" style="height: auto;">
  <section class="content">
    <?php path('cards'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Update Teacher Profile</h3>
            </div>
            <div class="card-body">
              <?php FlashMessage::displayMessages(); ?>
              <form method="POST" action="<?php ClearInput::selfURL(); ?>">
                <div class="row">
                  <div class="col-md-6">
                    <!-- <div class="form-group"> -->
                    <input type="hidden" class="form-control" id="selected_teacher_id" name="selected_teacher_id" placeholder="This will be set automatically" value="<?php echo getInputValue('selected_teacher_id') ?>" readonly>
                    <?php //error($errors, 'selected_teacher_id'); 
                    ?>
                    <!-- </div> -->
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="search-container">
                        <input type="text" class="form-control" id="search_teacher_live" name="search_teacher_live" placeholder="Search for teachers" value="<?php echo getInputValue('search_teacher_live') ?>">
                        <?php error($errors, 'search_teacher_live'); ?>
                        <div id="search-results"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end -->
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input type="text" class="form-control" id="teacher_lastname" name="teacher_lastname" placeholder="Teacher Last names" value="<?php echo getInputValue('teacher_lastname') ?>">
                      <?php error($errors, 'teacher_lastname'); ?>
                    </div>
                  </div>
                </div>
                <!-- end of the teacher last name -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="teacher_qualification" name="teacher_qualification" placeholder="Teacher qualifications" value="<?php echo getInputValue('teacher_qualification') ?>">
                      <?php
                      error($errors, 'teacher_qualification');
                      ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="teacher_experience" name="teacher_experience" placeholder="Length of Experience" value="<?php echo getInputValue('teacher_experience') ?>">
                      <?php error($errors, 'teacher_experience'); ?>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="teacher_specialization" name="teacher_specialization" placeholder="Teacher expecialization" value="<?php echo getInputValue('teacher_specialization') ?>">
                      <?php error($errors, 'teacher_specialization'); ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <select class="form-select" name="teacher_taught_subject">
                      <option value="">What subject the teacher would teach?</option>
                      <?php $subjects = $database->query("SELECT * FROM subjects"); ?>
                      <?php if ($subjects) : ?>
                        <?php foreach ($subjects as $row) : ?>
                          <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                    <?php error($errors, 'teacher_taught_subject'); ?>
                  </div>
                </div>
                <div class="card">
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </form>
              </>
            </div>
          </div>
        </div>
      </div>
  </section>
</div>
<?php path('footer'); ?>
