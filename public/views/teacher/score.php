<?php require_once __DIR__ . '/../../../App/config/path.php';

use Thesis\config\CallById; ?>
<?php path('header'); ?>
<?php
use Thesis\config\Auth;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\config\Validation;
use Thesis\controllers\scores\SearchScore;
use Thesis\controllers\scores\UploadScores;
use Thesis\functions\Roles;
?>
<?php
Auth::authenticate([Roles::getRole('isTeacher')]);
?>
<!-- insert here -->
<?php
$callByID = new CallById();
$validation = new Validation();
$flash = new FlashMessage();
$uploadStudentScores = new UploadScores($database, $callByID, $validation, $flash);
$errors = $uploadStudentScores->uploadStudentScores();

?>
<?php
path('navbar');
path(
  'sidebar',
  [
    'roles' => $roles,
    'username' => $username
  ]
);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="height: auto;">
  <section class="content">
    <div class="card"></div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                Update Student Grades
              </h3>
            </div>
            <!-- body -->
            <div class="card-body">
              <?php $id = isset($_GET['id']) ? intval($_GET['id']) : 0; ?>
              <?php
              $search = new SearchScore($database);
              $scores = $search->studentScores($id);
              ?>
              <?php foreach ($scores as $row) : ?>
                <?php $student_id = $row['student_id'] ?>
                <?php $grades = $row['grades'] ?>
                <?php $student_lastname = $row['student_lastname'] ?>
                <?php $subject_name = $row['subject_name'] ?>
                <?php $student_id = $row['student_id'] ?>
              <?php endforeach; ?>
              <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                <?php FlashMessage::displayMessages(); ?>
                <form  action="<?php ClearInput::selfURL(); ?>?id=<?php echo $id; ?>" method="POST">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="teacher_id" placeholder="Teacher ID" value="<?php echo $user_id; ?>">
                        <?php error($errors, 'teacher_id') ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Student ID" value="<?php echo $student_id; ?>">
                        <?php error($errors, 'student_id') ?>
                      </div>
                    </div>
                  </div>
                  <!-- ============= -->
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="student_grade_id" id="student_grade_id" placeholder="Grade ID" value="<?php echo $grades; ?>">
                        <?php error($errors, 'student_grade_id'); ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="search-container">
                          <input type="text" class="form-control" id="search_student_names" name="search_student_names" placeholder="Search for students" value="<?php echo $student_lastname; ?>">
                          <?php error($errors, 'search_student_names'); ?>
                          </span>
                          <div id="search-results2"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--  -->
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="search-container">
                          <input type="text" class="form-control" name="subject_names" id="subject_names" placeholder="Subject Names" value="<?php echo $subject_name; ?>">
                          <?php error($errors, 'subject_names') ?>
                          <div id="search-results1"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="score" id="score" placeholder="Score">
                        <?php error($errors, 'score') ?>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</div>
</section>
</div>
<?php path('footer'); ?>
