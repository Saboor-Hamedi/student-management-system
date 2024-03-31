<?php require_once __DIR__ . '/../../../App/config/path.php'; ?>
<?php path('header'); ?>
<?php

use Thesis\config\Auth; ?>
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
          // Fetch scores from the database
          $grade_id = isset($_GET['grade']) ? intval($_GET['grade']) : 0;
          $sql = "SELECT * FROM classes 
          INNER JOIN teachers ON classes.teacher_id = teachers.teacher_id
          INNER JOIN students ON classes.student_id = students.student_id
          WHERE students.student_id = :user_id AND classes.grades = :grade_id
          ORDER BY classes.grades DESC
          ";
          $params = [
            ':user_id' => $user_id,
            ':grade_id' => $grade_id
          ];
          $grades = $database->query($sql, $params);
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