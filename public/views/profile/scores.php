<?php require_once __DIR__ . '/../../../App/config/path.php'; ?>
<?php path('header'); ?>
<?php

use Thesis\config\Auth; ?>
<?php Auth::authenticate([1]); ?>
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
          $sql = "SELECT * FROM scores
                  INNER JOIN grades on scores.grades_id=grades.id
                  INNER JOIN teachers on scores.teacher_id=teachers.teacher_id
                  INNER JOIN students on scores.student_id=students.student_id
                  WHERE scores.student_id = {$user_id} ORDER BY grades.grade desc";
          $scores = $database->query($sql);

          // Group scores by grade
          $groupedScores = [];
          foreach ($scores as $score) {
            $gradeName = $score['name']; // Assuming 'name' is the field for grade name in your grades table
            if (!isset($groupedScores[$gradeName])) {
              $groupedScores[$gradeName] = [];
            }
            $groupedScores[$gradeName][] = $score;
          }

          // Check if groupedScores is empty
          if (empty($groupedScores)) {
            echo "No score added yet.";
          } else {
          ?>

          <div class="card">
            <div class="card-header">Scores</div>
            <div class="card-body">
              <?php foreach ($groupedScores as $gradeName => $scoresForGrade) : ?>
              <div class="card mt-2">
                <div class="card-header ">
                  <?php echo $gradeName; ?>
                </div>
              </div>
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
              <?php endforeach; ?>
            </div>
          </div>
          <?php
          } // End of else block
          ?>
          </table>
        </div>
      </div>
    </div>
</div>
</div>
</section>
</div>

<?php path("footer"); ?>