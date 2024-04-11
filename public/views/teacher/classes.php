<?php

/** 
 *  Read: 
 *  * The file is on: views/teacher/classes.php
 *  - This file belongs to the teachers
 *  - This file enable teachers to see their students
 *  - Through this file teachers are also able to score students simply by clicking
 *      on the insert button which is appear to be on the table. 
 *  Todo:
 *    Further This file is solely for teachers neither admin nor students has access to it
 */
?>
<?php require_once __DIR__ . '/../../../App/config/path.php'; ?>
<?php path('header'); ?>
<?php

use Thesis\config\Auth;
use Thesis\config\FlashMessage;
use Thesis\functions\Pagination;
use Thesis\functions\Roles;

Auth::authenticate([Roles::getRole('isTeacher')]);
?>
<!-- header on the top, Navbar -->
<?php path('navbar'); ?>
<!-- Main Sidebar Container -->
<?php path('sidebar', ['roles' => $roles, 'username' => $username, 'user_id' => $user_id, 'database' => $database]); ?>

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
                Welcome
                <?php echo ucfirst($username); ?>
              </h3>
            </div>
            <!-- body -->
            <div class="card-body">
              <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                <?php FlashMessage::displayMessages();

                ?>
                <table class="table table-hover table-condensed">

                  <!-- fetch data -->
                  <tbody>
                    <?php $sql = "SELECT classes.id AS class_id,teachers.teacher_id,
                                  /* users.id, 
                                  users.username AS username, */
                                  students.student_id ,
                                  students.lastname,
                                  classes.subject_name,
                                  classes.start_class,
                                  classes.end_class,
                                  classes.grades,
                                  classes.approve,
                                  classes.created_at FROM classes 
                              INNER JOIN teachers ON classes.teacher_id = teachers.teacher_id
                              /* INNER JOIN users ON teachers.teacher_id = users.id */
                              INNER JOIN students ON classes.student_id = students.student_id              
                              WHERE teachers.teacher_id = {$user_id}"; ?>
                    <?php $paginate = Pagination::paginate($database, $sql, 4); ?>
                    <?php if (!empty($paginate['records'])) : ?>
                      <thead>
                        <tr>
                          <th>Subjects</th>
                          <th>Names</th>
                          <th>Grades</th>
                          <th>Start Class</th>
                          <th>Score</th>

                        </tr>
                      </thead>
                      <?php foreach ($paginate['records'] as $row) : ?>
                        <tr class="odd">
                          <td class="dtr-control sorting_1" tabindex="0">
                            <?php echo ucfirst($row['subject_name']); ?>
                          </td>
                          <td>
                            <?php echo ucfirst($row['lastname']); ?>
                          </td>
                          <td>
                            <?php echo $row['grades']; ?>
                          </td>
                          <td>
                            <?php echo formatCreatedAt($row['start_class']); ?>
                          </td>
                          <td><a href="<?php echo BASE_URL ?>/teacher/score.php?id=<?php echo $row['class_id'] ?>" class="btn btn-primary btn-xs">insert</a></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>

                      <div class="card-body text-center">
                        <p class="card-text">Dear<strong> <?php echo ucfirst($username) ?? '' ?></strong> Please talk to the admin, you do not have any class yet</p>
                        <a href="<?php echo BASE_URL ?>/home.php" class="btn btn-primary">Profile</a>
                      </div>
                    <?php endif; ?>
                  </tbody>
                </table>
                <nav aria-label="Page navigation example">
                  <?php
                  echo $paginate['paginationHtml']; ?>
                </nav>
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
