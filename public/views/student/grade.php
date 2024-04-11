<?php
require_once __DIR__ . '/../../../App/config/path.php';
?>

<?php path('header'); ?>
<?php

use Thesis\config\Auth;
use Thesis\controllers\students\Grades;
use Thesis\functions\Roles;

?>
<?php Auth::authenticate([Roles::getRole('isStudent')]); ?>
<!-- header on the top, Navbar -->
<?php path('navbar'); ?>
<!-- Main Sidebar Container -->
<?php path(
  'sidebar',
  [
    'roles' => $roles,
    'username' => $username,
    'user_id' => $user_id,
    'database' => $database
  ]
); ?>
<div class="content-wrapper" style="height: auto;">
  <section class="content">
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
              <table class="table table-hover table-condensed custom-table">
                <thead>
                  <tr>
                    <th>Teacher</th>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>Start Time</th>
                  </tr>
                </thead>
                <?php if (!empty($grades)) : ?>
                  <tbody>
                    <?php foreach ($grades as $grade) : ?>
                      <tr>
                        <td><?php echo ucfirst($grade['teacher_lastname']); ?></td>
                        <td><?php echo ucfirst($grade['lastname']); ?></td>
                        <td><?php echo ucfirst($grade['subject_name']); ?></td>
                        <td><?php echo $grade['grades']; ?></td>
                        <td><?php echo $grade['start_class']; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                <?php else : ?>
                  <tbody>
                    <tr>
                      <td colspan="5">
                        <div class="card-footer text-muted">
                          <h5>No class found</h5>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                <?php endif; ?>
              </table>
            </div>
            <!-- Display the grade under the card -->
            <div class="card-footer text-muted">
              Grade <?php echo $grades[0]['grades']; ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
<?php path("footer"); ?>
