<?php require_once __DIR__ . '/../../../App/config/path.php';

use Thesis\controllers\scores\SearchScore; ?>
<?php path('header'); ?>
<?php

use Thesis\config\Auth;
use Thesis\controllers\students\Scores;
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
    <div class="card"></div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                Find Students
              </h3>
            </div>
            <!-- body -->
            <div class="card-body">
              <!-- search here -->
              <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div id="message" class="alert" style="display: none;"></div>

                <?php
                // Fetch scores from the database
                $search = new SearchScore($database);
                $result = $search->searchScores();
                ?>
                <?php $paginate = Pagination::paginate($database, $result, 4); ?>
                <?php if (!empty($paginate['records'])) : ?>
                  <div class="search">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                    <button id="clearSearchBtn"><i class="fa fa-trash"></i></button>
                  </div>
                  <table id="dataTable" class="table table-hover table-condensed">
                    <thead class="">
                      <tr>
                        <th>Student</th>
                        <th>Subject</th>
                        <th>Scores</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <!-- fetch data -->
                    <tbody>
                      <?php foreach ($paginate['records'] as $user) : ?>
                        <tr class="odd">
                          <td><?php echo $user['lastname']; ?></td>
                          <td><?php echo $user['subject_names']; ?></td>
                          <td><?php echo $user['score']; ?></td>
                          <?php if (isset($user['isScored'])) : ?>
                            <td>
                              <?php switch ($user['isScored']) {
                                case 'complete':
                                  echo '<span class="badge bg-success">Completed</span>';
                                  break;
                                case 'progress':
                                  echo '<span class="badge bg-info">In Progress</span>';
                                  break;
                                default:
                                  echo '<a href="#" class="btn btn-danger btn-xs deleteScore_" data-id="' . $user['score_id'] . '">Delete</a>';
                              } ?>
                            </td>
                          <?php endif; ?>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  <?php else : ?>
                    <div class="card-body text-center">
                      <p class="card-text">Dear<strong> <?php echo ucfirst($username) ?? '' ?></strong> This message appears due, not giving score to your student,
                        please if you have finished the exam,provide score to you students</p>
                      <a href="<?php echo BASE_URL ?>/teacher/classes.php" class="btn btn-primary">Profile</a>
                    </div>
                    <!-- end of fetch data -->
                  <?php endif; ?>
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
      </div>
    </div>
  </section>
</div>
<?php path('footer'); ?>
