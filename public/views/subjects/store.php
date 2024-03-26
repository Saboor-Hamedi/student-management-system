<?php
require_once __DIR__ . '/../../../App/config/path.php';
path('header');

use Thesis\config\Auth;
use Thesis\config\FlashMessage;
use Thesis\controllers\subjects\StoreSubjects;

Auth::authenticate([0]);
$handleSubjects = new StoreSubjects();
$grades = $handleSubjects->load_grades();
?>

<?php
$selected_teacher_id = '';
$selected_teacher_id_error = '';
$search_teacher_live = '';
$search_teacher_live_error = '';
$subject_names = '';
$subject_names_error = '';
$student_id = '';
$student_id_error = '';
$search_student_names = '';
$search_student_names_error = '';
$start_subject_time = '';
$start_subject_time_error = '';
$end_subject_time = '';
$end_subject_time_error = '';
$select_grades = '';
$select_grades_error = '';
$result = '';
if (isset($_POST['insert_grades_btn'])) {
  $selected_teacher_id = $_POST['selected_teacher_id'];
  $search_teacher_live = $_POST['search_teacher_live'];
  $subject_names = $_POST['subject_names'];
  $student_id = $_POST['student_id'];
  $search_student_names = $_POST['search_student_names'];
  $start_subject_time = $_POST['start_subject_time'];
  $end_subject_time = $_POST['end_subject_time'];
  $select_grades = $_POST['select_grades'];

  $result = $handleSubjects->classes_validation(
    $selected_teacher_id,
    $search_teacher_live,
    $subject_names,
    $student_id,
    $search_student_names,
    $start_subject_time,
    $end_subject_time,
    $select_grades
  );
  if (isset($result['errors'])) {
    $selected_teacher_id_error = $result['errors']['selected_teacher_id'] ?? '';
  }
  if (isset($result['errors'])) {
    $search_teacher_live_error = $result['errors']['search_teacher_live'] ?? '';
  }
  if (isset($result['errors'])) {
    $subject_names_error = $result['errors']['subject_names'] ?? '';
  }
  if (isset($result['errors'])) {
    $student_id_error = $result['errors']['student_id'] ?? '';
  }
  if (isset($result['errors'])) {
    $search_student_names_error = $result['errors']['search_student_names'] ?? '';
  }
  if (isset($result['errors'])) {
    $start_subject_time_error = $result['errors']['start_subject_time'] ?? '';
  }
  if (isset($result['errors'])) {
    $end_subject_time_error = $result['errors']['end_subject_time'] ?? '';
  }
  if (isset($result['errors'])) {
    $select_grades_error = $result['errors']['select_grades'] ?? '';
  }
}

?>
<!-- header on the top, Navbar -->
<?php path('navbar'); ?>

<!-- Main Sidebar Container -->
<?php path('sidebar', ['roles' => $roles, 'username' => $username, 'user_id' => $user_id, 'database' => $database]); ?>

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
                        <!-- <div class="form-group"> -->
                        <!-- Hidden input to store the selected teacher's ID -->
                        <input type="hidden" id="selected_teacher_id" class="form-control" name="selected_teacher_id" placeholder="Teacher's ID would set here" value="<?php echo getInputValue('selected_teacher_id'); ?>" readonly>
                        <!-- </div> -->
                        </d>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="search-container">
                            <input type="text" id="search_teacher_live" name="search_teacher_live" class="form-control" value="<?php echo getInputValue('search_teacher_live') ?>" placeholder="Search for Teachers here">
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

                      <!-- search for subject on subject repository table -->
                      <div class="col-md-6">
                        <div class="search-container">
                          <input type="text" class="form-control" id="subject_names" name="subject_names" placeholder="Subject Names" value="<?php echo getInputValue('subject_names'); ?>">
                          <span class=" error">
                            <?php
                            if (!empty($subject_names_error)) {
                              echo $subject_names_error;
                            }
                            ?>
                          </span>
                          <div id="search-results1"></div>
                        </div>
                      </div>
                    </div>
                    <!-- ---------------student search-------------- -->
                    <!-- <div class="form-group"> -->
                    <input type="hidden" class="form-control" id="student_id" name="student_id" placeholder="Student's ID would set here" value="<?php echo getInputValue('student_id'); ?>" readonly>

                    <!-- </div> -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="search-container">
                            <input type="text" class="form-control" id="search_student_names" name="search_student_names" placeholder="Search for students" value="<?php echo getInputValue('search_student_names'); ?>">
                            <span class=" error">
                              <?php
                              if (!empty($search_student_names_error)) {
                                echo $search_student_names_error;
                              }
                              ?>
                            </span>
                            <div id="search-results2"></div>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">
                      <!--  -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" class="form-control" id="start_subject_time" name="start_subject_time" placeholder="Subject Start Time" value="<?php echo getInputValue('start_subject_time') ?>">
                          <span class=" error">
                            <?php
                            if (!empty($start_subject_time_error)) {
                              echo $start_subject_time_error;
                            }
                            ?>
                          </span>
                        </div>
                      </div>
                      <!--  -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" class="form-control" id="end_subject_time" name="end_subject_time" placeholder="Suject End Time" value="<?php echo getInputValue('end_subject_time') ?>">
                          <span class=" error">
                            <?php
                            if (!empty($end_subject_time_error)) {
                              echo $end_subject_time_error;
                            }
                            ?>
                          </span>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <!-- select a grade from here -->
                          <select class="form-select" name="select_grades">
                            <option value="" class="form-class">Select Grades</option>
                            <?php foreach ($grades as $row) : ?>
                              <option value="<?php echo $row['grade']; ?>">
                                <?php echo $row['grade']; ?> Grade
                              </option>
                            <?php endforeach; ?>
                          </select>
                          <span class=" error">
                            <?php
                            if (!empty($select_grades_error)) {
                              echo $select_grades_error;
                            }
                            ?>
                          </span>
                        </div>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="insert_grades_btn" name="insert_grades_btn">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <!-- main body -->
        </div>
      </div>
    </section>
</div>

<?php path('footer'); ?>