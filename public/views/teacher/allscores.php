<?php require_once __DIR__ . '/../../../App/config/path.php';
path('header'); ?>

<?php

use Thesis\config\Auth;
use Thesis\functions\Roles;

Auth::authenticate([Roles::getRole('isTeacher')]);
?>
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
                    $result = $database->query($sql);
                    $perPage = 4; // Number of users to display per page
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
                      <td><?php echo $user['lastname']; ?></td>
                      <td><?php echo $user['subject_names']; ?></td>
                      <td><?php echo $user['score']; ?></td>
                      <td>
                        <?php echo formatCreatedAt($user['created_at']); ?>
                      </td>
                      <td>
                        <a href="#" class="btn btn-danger btn-xs deleteScore_"
                          data-id="<?php echo $user['score_id'] ?>">
                          delete
                        </a>
                      </td>
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
                <?php if (!empty($result)) : ?>
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
                <?php endif ?>
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