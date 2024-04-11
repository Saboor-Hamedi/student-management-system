<?php

use Thesis\controllers\scores\SearchScore;

/**
 * ? View: views/teacher/scores.php
 *
 *    ? This file is accessible exclusively to teachers for managing student scores.
 *
 * ? Features:
 *    ? Allows teachers to view scores assigned to students by their respective teachers.
 *    ? Provides functionality for teachers to delete specific scores assigned to students.
 *    ? (Deletion is performed asynchronously using AJAX, refer to assets/js/DeleteScore.js)
 *
 * ? Access Restrictions:
 *    ? This file is accessible only to teachers and is not accessible by admins or students.
 *
 * ? Note:
 *    ? This documentation aims to provide an overview of the purpose and access restrictions
 *    ? of the  scores.php file.
 *    ? For detailed implementation and functionality, refer to the code and related 
 *    ? JavaScript file (DeleteScore.js).
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

                <!-- fetch data -->
                <?php
                $search = new SearchScore($database);
                $sql = $search->searchScores();
                // Call the paginate method to generate pagination HTML and fetch records for the current page
                $paginate = Pagination::paginate($database, $sql, 2);
                ?>
                <?php if (!empty($paginate['records'])) : ?>
                  <table class="table table-hover table-condensed">
                    <thead class="">
                      <tr>
                        <th>Student</th>
                        <th>Subject</th>
                        <th>Score</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <?php foreach ($paginate['records'] as $user) : ?>
                      <tbody>
                        <tr class="odd">
                          <td><?php echo $user['lastname']; ?></td>
                          <td><?php echo $user['subject_names']; ?></td>
                          <td><?php echo $user['score']; ?></td>
                          <td>
                            <a href="#" class="btn btn-danger btn-xs deleteScore_" data-id="<?php echo $user['score_id'] ?>">
                              delete
                            </a>
                          </td>
                        </tr>
                      </tbody>
                    <?php endforeach; ?>
                  <?php else : ?>
                      <div class="card-body text-center">
                        <p class="card-text">Dear<strong> <?php echo ucfirst($username) ?? '' ?></strong> This message appears due, not giving score to your student, 
                          please if you have finished the exam,provide score to you students</p>
                        <a href="<?php echo BASE_URL ?>/teacher/classes.php" class="btn btn-primary">Profile</a>
                      </div>
                  <?php endif ?>
                  </table>
                  <nav aria-label="Page navigation example">
                    <?php
                    echo $paginate['paginationHtml']; ?>
                  </nav>
              </div>
            </div>
            <div class="card-footer"><p></p></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php path('footer'); ?>
