<?php require_once __DIR__ . '/../../../App/config/path.php';
path('header'); ?>

<?php

use Thesis\config\Auth;
use Thesis\functions\Pagination;

Auth::authenticate([0]);
?>
<!-- header on the top, Navbar -->
<?php path('navbar'); ?>
<!-- Main Sidebar Container -->
<?php path('sidebar', ['roles' => $roles, 'username' => $username, 'user_id' => $user_id, 'database' => $database]); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="height: auto;">
  <section class="content">

    <?php path('cards'); ?>

    <div class="container-fluid">
      <div class="row">
        <?php if ($roles == 0) : ?>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  Teachers
                </h3>
              </div>
              <!-- body -->
              <div class="card-body">
                <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <div id="message" class="alert" style="display: none;"></div>

                  <?php
                  $sql = $database->users('school.users', 2);
                  $paginate = Pagination::paginate($database, $sql, 2);
                  ?>
                  <?php if (!empty($paginate['records'])) : ?>
                    <table class="table table-hover table-condensed">
                      <thead class="">
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Date</th>
                          <th>Update</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($paginate['records'] as $user) : ?>
                          <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">
                              <?php echo ucfirst($user['username']); ?>
                            </td>
                            <td>
                              <?php echo $user['email']; ?>
                            </td>
                            <td>
                              <?php echo formatCreatedAt($user['created_at']); ?>
                            </td>
                            <td><a href="../update-users.php?id=<?php echo $user['id']; ?>" class=" my-small-button">Edit</a></td>
                            <td>
                              <a href="#" class="btn btn-danger btn-xs deleteTeacher_" data-id="<?php echo $user['id'] ?>">
                                delete
                              </a>
                            </td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    <?php else : ?>
                      <div class="card-body text-center">
                        <p class="card-text">Dear<strong> <?php echo ucfirst($username) ?? '' ?></strong>
                          It appears that there are currently no teachers available.
                          If you are having difficulty displaying teachers here, please click on 'Teacher Profile'
                          to search for a teacher by name and submit; they will then automatically appear here.
                          If you cannot find a student, please consult your database administrator to ensure that the student roles are set to '2'.
                        </p>
                        <a href="<?php echo BASE_URL ?>/users/register.php" class="btn btn-primary">Profile</a>
                      </div>
                    <?php endif ?>
                    </table>
                    <!-- Generate pagination links -->
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
        <?php endif ?>
      </div>
    </div>
  </section>
</div>
<?php path('footer'); ?>
