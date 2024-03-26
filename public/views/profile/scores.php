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
    <?php path('cards');
    ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?php $sql = "SELECT * FROM scores
                        INNER JOIN grades on scores.grades_id=grades.id
                        INNER JOIN teachers on scores.teacher_id=teachers.teacher_id
                        INNER JOIN students on scores.student_id=students.student_id
                        WHERE scores.student_id = {$user_id}"; ?>
          <?php $scores = $database->query($sql); ?>
          <div class="card">
            <div class="card-header">Scores</div>
            <div class="card-body">
              <table class="table table-hover table-condensed custom-table">
                <?php if (!empty($scores)) : ?>
                  <thead>
                    <tr>
                      <th>Teacher</th>
                      <th>Student</th>
                      <th>Grade</th>
                      <th>Subject</th>
                      <th>Score</th>
                    </tr>
                  </thead>
                  <?php foreach ($scores as $score) : ?>

                    <tbody>
                      <tr>
                        <td>
                          <?php echo $score['teacher_lastname']; ?>
                        </td>
                        <td>
                          <?php echo $score['lastname']; ?>
                        </td>
                        <td>
                          <?php echo $score['name']; ?>
                        </td>
                        <td>
                          <?php echo $score['subject_names']; ?>
                        </td>
                        <td>
                          <?php echo $score['score']; ?>
                        </td>
                      </tr>
                    </tbody>
                  <?php endforeach ?>
                <?php else : ?>
                  <td>No score added yet.</td>
                <?php endif; ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php path("footer"); ?>