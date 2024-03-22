<?php
require_once __DIR__ . '/../../../App/config/path.php';
path('header');

use Thesis\config\Auth;
use Thesis\config\Database;
use Thesis\config\FlashMessage;
use Thesis\controllers\profile\UserInformation;

 ?>
<?php
$database = Database::GetInstance();
$insert_information = new UserInformation();
?>
<?php
Auth::isLogged([2]);
?>
<!-- header on the top, Navbar -->
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
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <div class="row">
                    <!-- display user_id -->
                    <div class="col-lg-12 ">
                      <div class="form-group">
                        <input type="text" class="form-control" name="student_id" id="student_id"
                          placeholder="Student ID" disabled>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <div class="search-container">
                          <input type="text" class="form-control" id="search_student_names" name="search_student_names"
                            placeholder="Search for students">
                          <span class="span-error">
                          </span>
                          <div id="search-results2"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <input type="text" class="form-control" name="student_grade_id" id="student_grade_id"
                          placeholder="Grade ID" disabled>
                        <span class="span-error">
                        </span>
                      </div>
                      <div class="form-group">
                        <div class="search-container">
                          <input type="text" class="form-control" name="search_for_student_id"
                            id="search_for_student_id" placeholder="Search for student class">
                          <span class="span-error">
                          </span>
                          <div id="search-results3"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <div class="search-container">
                          <input type="text" class="form-control" id="subject_names" name="subject_names"
                            placeholder="Subject Names">
                          <span class="span-error">

                          </span>
                          <div id="search-results1"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" name="score" id="score" placeholder="Score">
                        <span class="span-error">

                        </span>
                      </div>
                    </div>

                  </div>
                  <button type="submit" name="insert_user_profile_button" class="btn btn-primary">Submit</button>
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