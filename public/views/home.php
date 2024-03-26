<?php require_once __DIR__ . '/../../App/config/path.php';
path('header'); ?>

<?php

use Thesis\config\Auth;

Auth::authenticate([0,1,2]);
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
                  Admin
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
                      $result = $database->adminUsers('school.users',0);
                      $perPage = 1; // Number of users to display per page
                      $totalUsers = count($result); // Total number of users
                      $totalPages = ceil($totalUsers / $perPage); // Total number of pages
                      $currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Current page 
                      $startIndex = 0;
                      $endIndex = 0;

                      // Check if index is smaller than the users 
                      if ($totalUsers == 1) {
                        // If there's only one user, set startIndex to 0 and endIndex to 0
                        $startIndex = 0;
                        $endIndex = 0;
                      } elseif ($totalUsers < $perPage) {
                        // If total users is less than perPage, show all users
                        $startIndex = 0;
                        $endIndex = $totalUsers - 1;
                      } else {
                        // Otherwise, calculate startIndex and endIndex normally
                        $startIndex = ($currentPage - 1) * $perPage; // Starting index for the current page
                        $endIndex = min($startIndex + $perPage - 1, $totalUsers - 1); // Ending index for the current page
                      }
                      ?>
                      <?php if (!empty($result)) : ?>
                        <?php for ($i = $startIndex; $i <= $endIndex; $i++) : ?>
                          <?php $user = $result[$i]; ?>
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
                            <td><a href="update-users.php?id=<?php echo encrypt($user['id'], 'no@hack_$_can_%_be_^_done'); ?>" class=" my-small-button">Edit</a></td>
                          </tr>
                        <?php endfor ?>
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
                    <ul class="pagination">
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Previous</span>
                        </a>
                      </li>
                      <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?php if ($i == $currentPage) {
                                                echo 'active';
                                              }
                                              ?>">
                          <a class="page-link" href="?page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                          </a>
                        </li>
                      <?php endfor ?>

                      <li class=" page-item">
                        <a class="page-link" href="#" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                          <span class="sr-only">Next</span>
                        </a>
                      </li>
                    </ul>
                  </nav>
                  <!-- end pagination -->
                </div>
              </div>
            </div>
          </div>
        <?php elseif ($roles == 1) : ?>
          <div class="col-12">
            <div class="card ">
              <div class="card-header">
                <h3 class="card-title">
                  Welcome
                  <?php echo ucfirst($username); ?>
                </h3>
              </div>
              <!-- body -->
              <div class="card-body">
                <div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <table class="table table-hover table-condensed">
                    <thead>
                      <tr>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Name
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Email</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Date</th>
                      </tr>
                    </thead>
                    <!-- fetch data -->
                    <tbody>
                      <?php $result = $database->GetUsersByRoleAndUserId('school.users', $roles, $user_id); ?>
                      <?php if (!empty($result)) : ?>
                        <?php foreach ($result as $user) : ?>
                          <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">
                              <?php echo $user['username']; ?>
                            </td>
                            <td>
                              <?php echo $user['email']; ?>
                            </td>
                            <td>
                              <?php echo formatCreatedAt($user['created_at']); ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else : ?>
                        <tr>
                          <td colspan="3">No user added yet</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <?php else : ?>
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
                  <table class="table table-hover table-condensed">
                    <thead>
                      <tr>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Name
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Email</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Date</th>
                      </tr>
                    </thead>
                    <!-- fetch data -->
                    <tbody>
                      <?php $result = $database->GetUsersByRoleAndUserId('school.users', $roles, $user_id); ?>
                      <?php if (!empty($result)) : ?>
                        <?php foreach ($result as $user) : ?>
                          <tr class="odd">
                            <td class="dtr-control sorting_1" tabindex="0">
                              <?php echo $user['username']; ?>
                            </td>
                            <td>
                              <?php echo $user['email']; ?>
                            </td>
                            <td>
                              <?php echo formatCreatedAt($user['created_at']); ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else : ?>
                        <tr>
                          <td colspan="3">No user added yet</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <?php endif ?>
        <!-- main body -->
      </div>
    </div>
  </section>
</div>
<?php path('footer'); ?>