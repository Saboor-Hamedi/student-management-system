<?php
require_once __DIR__ . '/../../../App/config/path.php'; ?>
<?php path('header');  ?>
<?php

use Thesis\config\Auth;
use Thesis\config\CallById;
use Thesis\config\FlashMessage;
use Thesis\controllers\subjects\Subjects;
?>
<?php

Auth::authenticate([0]);
$callByID = new CallById();
$subject = new Subjects($callByID);
$grades = $subject->loadGrades();
$errors = $subject->addSubject();
?>
<?php path('navbar'); //header 
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="height: auto;">
  <section class="content">
    <section class="content">
      <?php path('cards'); ?>
      <div class="container-fluid">
        <div class="row">
          <?php if ($roles == 0) : ?>
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    Add Subjects
                  </h3>
                </div>
                <!-- body -->
                <div class="card-body">
                  <?php
                  FlashMessage::displayMessages();
                  ?>
                  <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="search-container">
                            <input type="text" id="search_teacher_live" name="search_teacher_live" class="form-control" value="<?php echo getInputValue('search_teacher_live') ?>" placeholder="Search for Teachers here">
                            <?php error($errors, 'search_teacher_live'); ?>
                            <div id="search-results"></div>
                          </div>
                        </div>
                      </div>
                      <!--  -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" id="selected_teacher_id" class="form-control" name="selected_teacher_id" placeholder="Teacher's ID would set here" value="<?php echo getInputValue('selected_teacher_id'); ?>" readonly>
                          <?php error($errors, 'selected_teacher_id');
                          ?>
                        </div>
                      </div>
                    </div>
                    <!--  -->
                    <div class="row">
                      <!-- student name -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="search-container">
                            <input type="text" class="form-control" id="search_student_names" name="search_student_names" placeholder="Search for a student" value="<?php echo getInputValue('search_student_names'); ?>">
                            <?php error($errors, 'search_student_names'); ?>
                            <div id="search-results2"></div>
                          </div>
                        </div>
                      </div>
                      <!-- student id -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Student's ID would set here" value="<?php echo getInputValue('student_id'); ?>" readonly>
                          <?php error($errors, 'student_id');
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <!-- start time -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" class="form-control" id="start_subject_time" name="start_subject_time" value="<?php echo getInputValue('start_subject_time') ?>" placeholder="Subject Start Time">
                          <?php error($errors, 'start_subject_time'); ?>
                        </div>
                      </div>
                      <!-- end time -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" class="form-control" id="end_subject_time" value="<?php echo getInputValue('end_subject_time') ?>" name="end_subject_time" placeholder="Subject End Time">
                          <?php error($errors, 'end_subject_time'); ?>
                        </div>
                      </div>
                    </div>
                    <!-- selects -->
                    <div class="row">
                      <div class="col-md-6">
                        <select class="form-select" name="subject_names">
                          <option value="">What subject the teacher would teach?</option>
                          <?php $subjects = $database->query("SELECT * FROM subjects"); ?>
                          <?php if ($subjects) : ?>
                            <?php foreach ($subjects as $row) : ?>
                              <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </select>
                        <?php error($errors, 'subject_names'); ?>
                      </div>
                      <!--  grade -->
                      <div class="col-md-6">
                        <select class="form-select" name="select_grades">
                          <option value="" class="form-class">Select Grades</option>
                          <?php foreach ($grades as $row) : ?>
                            <option value="<?php echo $row['grade']; ?>">
                              <?php echo $row['grade']; ?> Grade
                            </option>
                          <?php endforeach; ?>
                        </select>
                        <?php error($errors, 'select_grades'); ?>
                      </div>
                    </div>
                    <div><p></p></div>
                    <!-- card -->
                    <div class="card">
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="insert_grades_btn">Submit</button>
                      </div>
                    </div>
                </div>
                </form>
              </div>
            </div>
        </div>
      <?php endif; ?>
      </div>
</div>
</section>
</div>

<?php path('footer'); ?>