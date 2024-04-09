<?php require_once __DIR__ . '/../../../App/config/path.php'; ?>
<?php path('header'); ?>
<?php

use Thesis\config\Auth;
use Thesis\controllers\students\Scores;
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="height: auto;">
  <section class="content">
    <div class="card"></div>
    <div class="container-fluid">
      <?php
      // Fetch scores from the database
      $scoresController = new Scores();
      $groupedScores = $scoresController->fetchScores();
      ?>
      <?php if (!empty($groupedScores)) : ?>
        <?php foreach ($groupedScores as $gradeName => $scoresForGrade) : ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">Scores</div>
                <div class="card-body">
                  <table class="table table-hover table-condensed custom-table">
                    <thead>
                      <tr>
                        <th>Teacher</th>
                        <th>Student</th>
                        <th>Grade</th>
                        <th>Subject</th>
                        <th>Score</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($scoresForGrade as $score) : ?>
                        <tr>
                          <td><?php echo $score['teacher_lastname']; ?></td>
                          <td><?php echo $score['lastname']; ?></td>
                          <td><?php echo $gradeName; ?></td>
                          <td><?php echo $score['subject_names']; ?></td>
                          <td><?php echo $score['score']; ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer text-muted">
                  Grade <?php echo $gradeName; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <td>No scores found</td>
      <?php endif; ?>
    </div>
  </section>
</div>

<?php path("footer"); ?>