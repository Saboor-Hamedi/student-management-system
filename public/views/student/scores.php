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
<?php path('sidebar', ['roles' => $roles, 'username' => $username, 'user_id' => $user_id, 'database' => $database]); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <?php //path('cards');
    ?>
    <div class="card"></div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?php
          // Fetch scores from the database
          $scoresController = new Scores();
          $groupedScores = $scoresController->fetchScores();
          ?>

          <div class="card">
            <div class="card-header">Scores</div>
            <div class="card-body">
              <?php if (empty($groupedScores)) : ?>
                <p>No score added yet.</p>
              <?php else : ?>
                <?php foreach ($groupedScores as $gradeName => $scoresForGrade) : ?>
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
                  <div class="container mt-2" style="margin: 0 auto;padding: 5px;  border-radius: 4px;">
                    <p style="padding: 0px; margin: 0px; font-size: 18px;"><?php echo $gradeName; ?></p>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

        </div>
      </div>
    </div>
</div>
</div>
</section>
</div>

<?php path("footer"); ?>