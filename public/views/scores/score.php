<?php
require_once __DIR__ . '/../../../App/config/path.php';
path('header');

use Thesis\config\Auth;
use Thesis\config\ClearInput;
use Thesis\config\FlashMessage;
use Thesis\controllers\scores\Store;

?>

<?php
Auth::isLogged([2]);
?>
<!-- insert here -->
<?php
// declare class 
$store = new Store();
$student_id = '';
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
$subject_names_error = '';
$score_error = '';
?>
<!-- $_SERVER['REQUEST_METHOD'] === 'POST' -->
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
  <?php
  $student_id = $_POST['student_id'] ?? '';
  $search_student_names = $_POST['search_student_names'] ?? '';
  $student_grade_id = $_POST['student_grade_id'] ?? '';
  $student_subject_name = $_POST['student_subject_name'];
  $subject_names = $_POST['subject_names'];
  $score = $_POST['score'];
  $valid = $store->validate(
    $student_id,
    $search_student_names,
    $student_grade_id,
    $student_subject_name,
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
    $student_subject_name_error = $valid['errors']['student_subject_name'] ?? '';
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
path('sidebar', ['roles' => $roles]);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <?php path('cards'); ?>
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
              <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                <?php FlashMessage::displayMessages(); ?>
                <form method="POST" action="<?php ClearInput::getSelfULR(); ?>">
                  <div class="row">
                    <!-- display user_id -->
                    <div class="col-lg-12 ">
                      <!-- <div class="form-group"> -->
                      <input type="hidden" class="form-control" id="student_id" name="student_id" placeholder="Student ID" value="<?php echo getInputValue("student_id") ?>" readonly>
                      <span class="error">
                        <?php
                        // if (!empty($student_id_error)) {
                        //   echo $student_id_error;
                        // }
                        ?>
                      </span>
                      <!-- </div> -->
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <div class="search-container">
                          <input type="text" class="form-control" id="search_student_names" name="search_student_names" placeholder="Search for students" value="<?php echo getInputValue("search_student_names") ?>">
                          <span class="error">
                            <?php
                            // if (!empty($search_student_names_error)) {
                            //   echo $search_student_names_error;
                            // }
                            ?>
                          </span>
                          <div id="search-results2"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <!-- <div class="form-group"> -->
                      <input type="hidden" class="form-control" name="student_grade_id" id="student_grade_id" placeholder="Grade ID" value="<?php echo getInputValue("student_grade_id"); ?>" readonly>
                      <span class="error">
                        <?php
                        if (!empty($student_grade_id_error)) {
                          echo $student_grade_id_error;
                        }
                        ?>
                      </span>
                      <!-- </div> -->
                      <div class="form-group">
                        <div class="search-container">
                          <input type="text" class="form-control" name="student_subject_name" id="student_subject_name" placeholder="Search for student class" value="<?php echo getInputValue("student_subject_name") ?>">
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
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <div class="search-container">
                          <input type="text" class="form-control" name="subject_names" id="subject_names" placeholder="Subject Names" value="<?php echo getInputValue("subject_names"); ?>">
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
                      <div class="form-group">
                        <input type="text" class="form-control" name="score" id="score" placeholder="Score" value="<?php echo getInputValue("score") ?>">
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
                  <button type="submit" name="insert_student_scores" class="btn btn-primary">Submit</button>
                </form>
                <!-- end grades -->
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>
<?php path('footer'); ?>