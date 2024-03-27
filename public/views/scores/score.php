<?php
require_once __DIR__ . '/../../../App/config/path.php';
path('header');

use Thesis\config\Auth;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\controllers\scores\Store;
?>

<?php
Auth::authenticate([2]);
?>
<!-- insert here -->
<?php
// declare class 
$store = new Store();
$student_id = '';
$teacher_id = '';
$search_student_names = '';
$student_grade_id = '';
$student_subject_name = '';
$subject_names = '';
$score = '';
// ---
$student_id_error = '';
$search_student_names_error = '';
$student_grade_id_error = '';
$student_subject_name_error = '';
$teacher_id_error = '';
$subject_names_error = '';
$score_error = '';
?>
<!-- $_SERVER['REQUEST_METHOD'] === 'POST' -->
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
<?php
  $student_id = $_POST['student_id'] ?? '';
  $teacher_id = $_POST['teacher_id'] ?? '';
  $search_student_names = $_POST['search_student_names'] ?? '';
  $student_grade_id = $_POST['student_grade_id'] ?? '';
  $subject_names = $_POST['subject_names'];
  $score = $_POST['score'];
  $valid = $store->validate(
    $student_id,
    $teacher_id,
    $search_student_names,
    $student_grade_id,
    $subject_names,
    $score,
  );
  // check for error
  if (isset($valid['errors'])) {
    $student_id_error = $valid['errors']['student_id'] ?? '';
  }
  if (isset($valid['errors'])) {
    $search_student_names_error = $valid['errors']['search_student_names'] ?? '';
  }
  if (isset($valid['errors'])) {
    $student_grade_id_error = $valid['errors']['student_grade_id'] ?? '';
  }
  if (isset($valid['errors'])) {
    $teacher_id_error = $valid['errors']['teacher_id'] ?? '';
  }
  if (isset($valid['errors'])) {
    $subject_names_error = $valid['errors']['subject_names'] ?? '';
  }
  if (isset($valid['errors'])) {
    $score_error = $valid['errors']['score'] ?? '';
  }
  ?>
<?php endif; ?>
<!-- end of insertation -->
<?php
path('navbar');
path('sidebar', ['roles' => $roles, 'username' => $username]);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <?php //path('cards'); 
    ?>
    <div class="card"></div>
    <div class="container-fluid">
      <div class="row">
        <!-- student -->
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                Update Student Grades
              </h3>
            </div>
            <!-- body -->
            <div class="card-body">
              <?php $id = isset($_GET['id']) ? $_GET['id'] : null; ?>
              <?php $id = intval($id); ?>
              <?php $sql = "SELECT 
    classes.id AS class_id,
    classes.subject_name,
    classes.start_class,
    classes.end_class,
    classes.grades,
    classes.approve,
    teachers.teacher_id AS teacher_id,
    teachers.qualification,
    teachers.teacher_lastname,
    teachers.experience,
    teachers.subjects_taught,
    teachers.specialization,
    students.student_id ,
    students.lastname AS student_lastname,
    students.sex
    FROM 
        classes
    INNER JOIN teachers ON classes.teacher_id = teachers.teacher_id
    INNER JOIN students ON classes.student_id = students.student_id
    WHERE classes.id = $id
 "  ?>
              <?php $update =  $database->query($sql); ?>

              <?php foreach ($update as $row) :
              ?>

              <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                <?php FlashMessage::displayMessages(); ?>
                <form method="POST" action="<?php ClearInput::selfURL(); ?>?id=<?php echo $id; ?>">


                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="teacher_id" value="<?php echo $user_id; ?>"
                          placeholder="Teacher ID">
                        <span class="error">
                          <?php
                            if (!empty($teacher_id_error)) {
                              echo $teacher_id_error;
                            }
                            ?>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" id="student_id" name="student_id"
                          placeholder="Student ID" value="<?php echo $row['student_id'] ?>">
                        <span class="error">
                          <?php
                            if (!empty($student_id_error)) {
                              echo $student_id_error;
                            }
                            ?>
                        </span>
                      </div>
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="student_grade_id" id="student_grade_id"
                          placeholder="Grade ID" value="<?php echo $row['grades'] ?>">
                        <span class="error">
                          <?php
                            if (!empty($student_grade_id_error)) {
                              echo $student_grade_id_error;
                            }
                            ?>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="search-container">
                          <input type="text" class="form-control" id="search_student_names" name="search_student_names"
                            placeholder="Search for students" value="<?php echo $row['student_lastname'] ?>">
                          <span class="error">
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
                  <!--  -->
                  <div class="row">

                    <!-- <div class="col-md-6">
                      <div class="form-group">
                        <div class="search-container">
                          <input type="text" class="form-control" name="student_subject_name" id="student_subject_name" placeholder="Search for student class" value="<?php echo $row['grades'] ?>">
                          <span class="error">
                            <?php
                            if (!empty($student_subject_name_error)) {
                              echo $student_subject_name_error;
                            }
                            ?>
                          </span>
                          <div id="search-results3"></div>
                        </div>
                      </div>
                    </div> -->
                  </div>
                  <!--  -->
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="search-container">
                          <input type="text" class="form-control" name="subject_names" id="subject_names"
                            placeholder="Subject Names" value="<?php echo $row['subject_name'] ?>">
                          <span class="error">
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
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" class="form-control" name="score" id="score" placeholder="Score"
                          value="<?php echo getInputValue("score") ?>">
                        <span class="error">
                          <?php
                            if (!empty($score_error)) {
                              echo $score_error;
                            }
                            ?>
                        </span>
                      </div>
                    </div>
                  </div>
              </div>
              <button type="submit" name="insert_student_scores" class="btn btn-primary">Submit</button>
              </form>
              <!-- end grades -->
            </div>
            <?php endforeach;
          ?>
          </div>
        </div>
      </div>
    </div>
</div>
</section>
</div>
<?php path('footer'); ?>