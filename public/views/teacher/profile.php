<?php
require_once __DIR__ . '/../../../App/config/path.php';
path('header'); ?>
<?php

use Thesis\config\Auth;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\controllers\TeachersProfile;

?>

<?php Auth::isLogged([0]); ?>
<!-- insert data -->
<?php $teachers_profile = new TeachersProfile(); ?>
<?php
$selected_teacher_id = '';
$selected_teacher_id_error = '';
$search_teacher_live = '';
$search_teacher_live_error = '';
$teacher_lastname = '';
$teacher_lastname_error = '';
$teacher_qualification_lastname = '';
$teacher_qualification_lastname_error = '';
$length_of_experience = '';
$length_of_experience_error = '';
$subject_taught = '';
$subject_taught_error = '';
$teacher_expecialization = '';
$teacher_expecialization_error = '';
if (isset($_POST['teacher_profile_btn'])) {
  $selected_teacher_id = $_POST['selected_teacher_id'];
  $search_teacher_live = $_POST['search_teacher_live'];
  $teacher_lastname = $_POST['teacher_lastname'];
  $teacher_qualification_lastname = $_POST['teacher_qualification_lastname'];
  $length_of_experience = $_POST['length_of_experience'];
  $subject_taught = $_POST['subject_taught'];
  $teacher_expecialization = $_POST['teacher_expecialization'];
  $result = $teachers_profile->validate_profile(
    $selected_teacher_id,
    $search_teacher_live,
    $teacher_lastname,
    $teacher_qualification_lastname,
    $length_of_experience,
    $subject_taught,
    $teacher_expecialization
  );
  if (isset($result['errors'])) {
    $selected_teacher_id_error = $result['errors']['selected_teacher_id'] ?? '';
  }
  if (isset($result['errors'])) {
    $search_teacher_live_error = $result['errors']['search_teacher_live'] ?? '';
  }
  if (isset($result['errors'])) {
    $teacher_lastname_error = $result['errors']['teacher_lastname'] ?? '';
  }
  if (isset($result['errors'])) {
    $teacher_qualification_lastname_error = $result['errors']['teacher_qualification_lastname'] ?? '';
  }
  if (isset($result['errors'])) {
    $length_of_experience_error = $result['errors']['length_of_experience'] ?? '';
  }
  if (isset($result['errors'])) {
    $subject_taught_error = $result['errors']['subject_taught'] ?? '';
  }
  if (isset($result['errors'])) {
    $teacher_expecialization_error = $result['errors']['teacher_expecialization'] ?? '';
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
              <h3 class="card-title">Update Teacher Profile</h3>
            </div>
            <div class="card-body">
              <?php
              FlashMessage::displayMessages();
              ?>
              <form method="POST" action="<?php ClearInput::getSelfULR(); ?>">
                <div class="row">
                  <div class="col-md-12">
                    <!-- <div class="form-group"> -->
                    <input type="hidden" class="form-control" id="selected_teacher_id" name="selected_teacher_id" placeholder="This will be set automatically" value="<?php echo getInputValue('selected_teacher_id') ?>" readonly>
                    <span class="error">
                      <?php
                      if (!empty($selected_teacher_id_error)) {
                        echo $selected_teacher_id_error;
                      }
                      ?>
                    </span>

                    <!-- </div> -->
                  </div>


                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="search-container">

                        <input type="text" class="form-control" id="search_teacher_live" name="search_teacher_live" placeholder="Search for teachers" value="<?php echo getInputValue('search_teacher_live') ?>">
                        <span class="error">
                          <?php
                          if (!empty($search_teacher_live_error)) {
                            echo $search_teacher_live_error;
                          }
                          ?>
                        </span>
                        <div id="search-results"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <input type="text" class="form-control" id="teacher_lastname" name="teacher_lastname" placeholder="Teacher Last names" value="<?php echo getInputValue('teacher_lastname') ?>">
                      <span class="error">
                        <?php
                        if (!empty($teacher_lastname_error)) {
                          echo $teacher_lastname_error;
                        }
                        ?>
                      </span>
                    </div>
                  </div>
                  <!-- lasttname end -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="teacher_qualification_lastname" name="teacher_qualification_lastname" placeholder="Teacher qualifications" value="<?php echo getInputValue('teacher_qualification_lastname') ?>">
                      <span class="error">
                        <?php
                        if (!empty($teacher_qualification_lastname_error)) {
                          echo $teacher_qualification_lastname_error;
                        }
                        ?>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="length_of_experience" name="length_of_experience" placeholder="Length of Experience" value="<?php echo getInputValue('length_of_experience') ?>">
                      <span class="error">
                        <?php
                        if (!empty($length_of_experience_error)) {
                          echo $length_of_experience_error;
                        }
                        ?>
                      </span>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="teacher_expecialization" name="teacher_expecialization" placeholder="Teacher expecialization" value="<?php echo getInputValue('teacher_expecialization') ?>">
                      <span class="error">
                        <?php
                        if (!empty($subject_taught_error)) {
                          echo $subject_taught_error;
                        }
                        ?>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="subject_taught" name="subject_taught" placeholder="Subject teachers ever taughts" value="<?php echo getInputValue('subject_taught') ?>">
                      <span class="error">
                        <?php
                        if (!empty($subject_taught_error)) {
                          echo $subject_taught_error;
                        }
                        ?>
                      </span>
                    </div>
                  </div>
                  <!-- lastname -->
                </div>
                <button type="submit" name="teacher_profile_btn" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php path('footer'); ?>