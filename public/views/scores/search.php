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
              <div class="form-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                <span id="searchResults"></span>
              </div>
              <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div id="message" class="alert" style="display: none;"></div>
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
                    <?php
                    // Fetch scores from the database
                    $search = new SearchScore($database);
                    $result = $search->searchScores();
                    ?>
                    <?php $paginate = Pagination::paginate($database, $result, 2); ?>
                    <?php if(!empty($paginate['records'])): ?>
                     
                    <?php foreach ($paginate['records'] as $user) : ?>
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
                    <?php endforeach; ?>
                    <?php endif;?>
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
      </div>
    </div>
  </section>
</div>
<?php path('footer'); ?>
