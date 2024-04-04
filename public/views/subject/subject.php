<?php
require_once __DIR__ . '/../../../App/config/path.php';
path('header');

use Thesis\config\Auth;
use Thesis\config\CallById;
use Thesis\config\FlashMessage;
use Thesis\controllers\subjects\StoreSubjects;
use Thesis\controllers\subjects\Subjects;

Auth::authenticate([0]);
$handleSubjects = new StoreSubjects();
$callbyid = new CallById();
$subject = new Subjects($callbyid);
$grades = $subject->loadGrades();
$errors = $subject->store();
?>

<?php
// $selected_teacher_id = '';
// $selected_teacher_id_error = '';
// $search_teacher_live = '';
// $search_teacher_live_error = '';
// $subject_names = '';
// $subject_names_error = '';
// $student_id = '';
// $student_id_error = '';
// $search_student_names = '';
// $search_student_names_error = '';
// $start_subject_time = '';
// $start_subject_time_error = '';
// $end_subject_time = '';
// $end_subject_time_error = '';
// $select_grades = '';
// $select_grades_error = '';
// $result = '';
// if (isset($_POST['insert_grades_btn'])) {
//   $selected_teacher_id = $_POST['selected_teacher_id'];
//   $search_teacher_live = $_POST['search_teacher_live'];
//   $subject_names = $_POST['subject_names'];
//   $student_id = $_POST['student_id'];
//   $search_student_names = $_POST['search_student_names'];
//   $start_subject_time = $_POST['start_subject_time'];
//   $end_subject_time = $_POST['end_subject_time'];
//   $select_grades = $_POST['select_grades'];

//   $result = $handleSubjects->classes_validation(
//     $selected_teacher_id,
//     $search_teacher_live,
//     $subject_names,
//     $student_id,
//     $search_student_names,
//     $start_subject_time,
//     $end_subject_time,
//     $select_grades
//   );
//   if (isset($result['errors'])) {
//     $selected_teacher_id_error = $result['errors']['selected_teacher_id'] ?? '';
//   }
//   if (isset($result['errors'])) {
//     $search_teacher_live_error = $result['errors']['search_teacher_live'] ?? '';
//   }
//   if (isset($result['errors'])) {
//     $subject_names_error = $result['errors']['subject_names'] ?? '';
//   }
//   if (isset($result['errors'])) {
//     $student_id_error = $result['errors']['student_id'] ?? '';
//   }
//   if (isset($result['errors'])) {
//     $search_student_names_error = $result['errors']['search_student_names'] ?? '';
//   }
//   if (isset($result['errors'])) {
//     $start_subject_time_error = $result['errors']['start_subject_time'] ?? '';
//   }
//   if (isset($result['errors'])) {
//     $end_subject_time_error = $result['errors']['end_subject_time'] ?? '';
//   }
//   if (isset($result['errors'])) {
//     $select_grades_error = $result['errors']['select_grades'] ?? '';
//   }
// }

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
                      <div class="col-md-12">
                        <!-- <div class="form-group"> -->
                        <input type="hidden" id="selected_teacher_id" class="form-control" name="selected_teacher_id" placeholder="Teacher's ID would set here" value="<?php echo getInputValue('selected_teacher_id'); ?>" readonly>
                        <?php //error($errors, 'selected_teacher_id'); 
                        ?>
                        <!-- </div> -->
                      </div>
                    </div>
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
                      <div class="col-md-6">
                        <!-- search for subject on subject repository table -->
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
                    </div>
                    <!-- <div class="form-group"> -->
                      <input type="hidden" class="form-control" id="student_id" name="student_id" placeholder="Student's ID would set here" value="<?php echo getInputValue('student_id'); ?>" readonly>
                      <?php // error($errors, 'student_id'); ?>
                    <!-- </div> -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="search-container">
                            <input type="text" class="form-control" id="search_student_names" name="search_student_names" placeholder="Search for students" value="<?php echo getInputValue('search_student_names'); ?>">
                            <?php error($errors, 'search_student_names'); ?>
                            <div id="search-results2"></div>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="row">
                      <!--  -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" class="form-control" id="start_subject_time" name="start_subject_time" placeholder="Subject Start Time">
                          <?php error($errors, 'start_subject_time'); ?>
                        </div>
                      </div>
                      <!--  -->
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" class="form-control" id="end_subject_time" name="end_subject_time" placeholder="Suject End Time">
                          <?php error($errors, 'end_subject_time'); ?>
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
                          <?php error($errors, 'select_grades'); ?>
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="insert_grades_btn">Submit</button>
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