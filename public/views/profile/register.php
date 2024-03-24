<?php require_once __DIR__ . '/../../../App/config/path.php';
path('header'); ?>
<?php

use Thesis\config\Auth;
use Thesis\config\FlashMessage;
use Thesis\controllers\profile\Register;

?>

<?php Auth::isLogged([0]); ?>

<!-- insert data -->
<?php $students_profile = new Register(); ?>
<?php
$student_profile_id = '';
$student_profile_id_error = '';
$search_student_profile_name = '';
$search_student_profile_name_error = '';
$student_lastname = '';
$student_lastname_error = '';
$student_sex = '';
$student_sex_error = '';
if (isset ($_POST['student_profile_btn'])) {
  $student_profile_id = $_POST['student_profile_id'];
  $search_student_profile_name = $_POST['search_student_profile_name'];
  $student_lastname = $_POST['student_lastname'];
  $student_sex = $_POST['student_sex'];
  $result = $students_profile->validate_profile(
    $student_profile_id,
    $search_student_profile_name,
    $student_lastname,
    $student_sex
  );
  if (isset ($result['errors'])) {
    $student_profile_id_error = $result['errors']['student_profile_id'] ?? '';
  }
  if (isset ($result['errors'])) {
    $search_student_profile_name_error = $result['errors']['search_student_profile_name'] ?? '';
  }
  if (isset ($result['errors'])) {
    $student_lastname_error = $result['errors']['student_lastname'] ?? '';
  }
  if (isset ($result['errors'])) {
    $student_sex_error = $result['errors']['student_sex'] ?? '';
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
              <h3 class="card-title">Update Students Data</h3>
            </div>
            <div class="card-body">
              <?php
              FlashMessage::displayMessages();
              ?>
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="row">
                  <div class="col-md-12">
                    <!-- <div class="form-group"> -->
                      <input type="hidden" class="form-control" id="student_profile_id" name="student_profile_id" placeholder="This will be set automatically"
                        value="<?php echo getInputValue('student_profile_id') ?>" readonly>
                      <span class="error">
                        <?php
                        if (!empty ($student_profile_id_error)) {
                          echo $student_profile_id_error;
                        }
                        ?>
                      </span>

                    <!-- </div> -->
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="search-container">

                        <input type="text" class="form-control" id="search_student_profile_name"
                          name="search_student_profile_name" placeholder="Search for student"
                          value="<?php echo getInputValue('search_student_profile_name') ?>">
                        <span class="error">
                          <?php
                          if (!empty ($search_student_profile_name_error)) {
                            echo $search_student_profile_name_error;
                          }
                          ?>
                        </span>
                        <div id="search-results3"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="student_lastname" name="student_lastname"
                        placeholder="Students lastname" value="<?php echo getInputValue('student_lastname') ?>">
                      <span class="error">
                        <?php
                        if (!empty ($student_lastname_error)) {
                          echo $student_lastname_error;
                        }
                        ?>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <select class="form-select" name="student_sex">
                        <option value="">Select sex</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        </select> <span class="error">
                            <?php
                            if (!empty ($student_sex_error)) {
                              echo $student_sex_error;
                            }
                            ?>
                          </span>
                    </div>
                  </div>
                </div>
                <button type="submit" name="student_profile_btn" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php path('footer'); ?>