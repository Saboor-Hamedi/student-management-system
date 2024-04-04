<?php
/** 
 *  Read: 
 *  * The file is on: views/teacher/scores.php
 *  - This file belongs to the teachers
 *  - In this file enables teachers to see the scored students, the one whom recived scores 
 *    from their prespective teachers. 
 *  - Also within this file teahcers are eble to delete certian score of students
 *  - The delete process is done through ajax, visit assets/js/DeleteScore.js
 *  Todo:
 *    Further This file is solely for teachers neither admin nor students has access to it
 *  ? By no mean this documentation is perfetc, I tried my best to explain everything which helps 
 *  ? to understand the project flow. 
 */
?>
<?php require_once __DIR__ . '/../../../App/config/path.php'; ?>
<?php path('header'); ?>
<?php

use Thesis\config\Auth;
use Thesis\functions\Pagination;
use Thesis\functions\Roles;
?>
<?php Auth::authenticate([Roles::getRole('isTeacher')]); ?>
<!-- header on the top, Navbar -->
<?php path('navbar'); ?>
<!-- Main Sidebar Container -->
<?php path('sidebar', ['roles' => $roles, 'username' => $username]); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="height: auto;">
  <section class="content">
    <?php //path('cards'); 
    ?>
    <div class="card"></div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                All Scores
              </h3>
            </div>
            <!-- body -->
            <div class="card-body">
              <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div id="message" class="alert" style="display: none;"></div>
                <table class="table table-hover table-condensed">
                  <thead class="">
                    <tr>
                      <th>Student</th>
                      <th>Grade</th>
                      <th>Subject</th>
                      <th>Score</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <!-- fetch data -->
                  <tbody>
                    <?php
                    $sql = "SELECT scores.id AS score_id, scores.teacher_id AS teacher_id,
                   scores.student_id AS student_id, scores.grades_id AS grades_id, 
                   scores.subject_names AS subject_names, scores.score AS score,
                   scores.created_at AS created_at, students.lastname FROM scores
                   INNER JOIN grades on scores.grades_id=grades.id
                   INNER JOIN teachers on scores.teacher_id=teachers.teacher_id
                   INNER JOIN students on scores.student_id=students.student_id
                   WHERE scores.teacher_id = {$user_id}
                   ORDER BY grades.grade DESC";
                    // Call the paginate method to generate pagination HTML and fetch records for the current page
                    $paginate = Pagination::paginate($database, $sql, 2);

                    ?>
                    <?php if (!empty($paginate['records'])) : ?>
                      <?php foreach ($paginate['records'] as $user) : ?>
                        <tr class="odd">
                          <td><?php echo $user['lastname']; ?></td>
                          <td><?php echo $user['subject_names']; ?></td>
                          <td><?php echo $user['score']; ?></td>
                          <td>
                            <?php echo formatCreatedAt($user['created_at']); ?>
                          </td>
                          <td>
                            <a href="#" class="btn btn-danger btn-xs deleteScore_" data-id="<?php echo $user['score_id'] ?>">
                              delete
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <tr class="odd">
                        <td colspan="3">No user added yet</td>
                      </tr>
                    <?php endif ?>
                  </tbody>
                  <tbody>
                  </tbody>
                </table>
                <nav aria-label="Page navigation example">
                  <?php
                  echo $paginate['paginationHtml']; ?>
                </nav>
                <!-- end pagination -->
              </div>

            </div>
            <div class="card-footer">
              <p></p>
            </div>
          </div>
        </div>
        <!-- main body -->
      </div>
    </div>
  </section>
</div>
<?php path('footer'); ?>