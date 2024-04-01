<?php require_once __DIR__ . '/../../../App/config/path.php'; ?>
<?php path('header'); ?>
<?php
use Thesis\config\Auth;
use Thesis\controllers\grade\Grades;
?>
<?php Auth::authenticate([1]); ?>
<!-- header on the top, Navbar -->
<?php path('navbar'); ?>
<!-- Main Sidebar Container -->
<?php path('sidebar', ['roles' => $roles, 'username' => $username, 'user_id' => $user_id, 'database' => $database]); ?>
<div class="content-wrapper">
  <section class="content">
    <?php //path('cards');
    ?>
    <div class="card"></div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?php
          $grade_id = isset($_GET['grade']) ? intval($_GET['grade']) : 0;
          $gradeController = new Grades();
          $grades = $gradeController->fetchGrade($grade_id);
          ?>
          <div class="card">
            <div class="card-header">Grade <?php echo $grade_id; ?></div>
            <div class="card-body">
              <?php if (empty($grades)) : ?>
                <p>No score added yet.</p>
              <?php else : ?>
                <table class="table table-hover table-condensed custom-table">
                  <thead>
                    <tr>
                      <th>Teacher</th>
                      <th>Student</th>
                      <th>Subject</th>
                      <th>Grade</th>
                    </tr>
                  </thead>
                  <?php foreach ($grades as $grade) : ?>
                    <tbody>
                      <tr>
                        <td><?php echo $grade['teacher_lastname']; ?></td>
                        <td><?php echo $grade['lastname']; ?></td>
                        <td><?php echo $grade['subject_name']; ?></td>
                        <td><?php echo $grade['grades']; ?></td>
                      </tr>
                    </tbody>
                  <?php endforeach; ?>
                </table>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php path("footer"); ?>