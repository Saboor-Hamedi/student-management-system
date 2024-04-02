<?php require_once __DIR__ . '/../../../App/config/path.php';
path('header'); ?>

<?php

use Thesis\config\Auth;
use Thesis\functions\Pagination;
use Thesis\functions\Roles;

Auth::authenticate([Roles::getRole('isAdmin')]);
?>
<!-- header on the top, Navbar -->
<?php path('navbar'); ?>
<!-- Main Sidebar Container -->
<?php path('sidebar', ['roles' => $roles, 'username' => $username]); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="height: auto;">
  <section class="content">
    <?php path('cards'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                Students
              </h3>
            </div>
            <!-- body -->
            <div class="card-body">
              <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                <table class="table table-hover table-condensed">
                  <thead class="">
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Date</th>
                      <th>Update</th>
                    </tr>
                  </thead>
                  <!-- fetch data -->
                  <tbody>
                    <?php
                    $sql = $database->users('school.users', 1);
                    $paginate = Pagination::paginate($database, $sql,2);
                    ?>
                    <?php if (!empty($paginate['records'])) : ?>
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
                      <td><a
                          href="../update-users.php?id=<?php echo $user['id']; ?>"
                          class=" my-small-button">Edit</a></td>
                    </tr>
                    <?php endforeach ?>
                    <?php else : ?>
                    <tr>
                      <td colspan="3">No user added yet</td>
                    </tr>
                    <?php endif ?>
                  </tbody>
                  <tbody>
                  </tbody>
                </table>
                <!-- Generate pagination links -->
                <nav aria-label="Page navigation example">
                  <?php
                  echo $paginate['paginationHtml']; ?>
                </nav>
                <!-- end pagination -->
              </div>
            </div>
          </div>
        </div>
        <!-- main body -->
      </div>
    </div>
  </section>
</div>
<?php path('footer'); ?>