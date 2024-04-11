

<?php require_once __DIR__ . '/../../../App/config/path.php'; ?>
<?php path('header'); ?>
<?php

use Thesis\config\Auth;
use Thesis\controllers\students\Schedule;
use Thesis\functions\Roles;

?>
<?php Auth::authenticate([Roles::getRole('isStudent')]); ?>
<!-- header on the top, Navbar -->
<?php path('navbar'); ?>
<!-- Main Sidebar Container -->
<?php path(
  'sidebar',
  [
    'roles' => $roles,
    'username' => $username,
    'user_id' => $user_id,
    'database' => $database
  ]
); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="height: auto;">
  <section class="content">
    <div class="card"></div>
    <div class="container-fluid">
      <?php
      $scheduleController = new Schedule();
      $groupedClasses = $scheduleController->fetchSchedule();
      ?>
      <?php if (!empty($groupedClasses)) : ?>
        <?php foreach ($groupedClasses as $gradeName => $classesForGrade) : ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title">Schedule - Grade <?php echo $gradeName; ?></h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-condensed custom-table">
                      <thead>
                        <tr>
                          <th>Teacher</th>
                          <th>Subject</th>
                          <th>Start</th>
                          <th>End</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($classesForGrade as $class) : ?>
                          <tr>
                            <td><?php echo $class['teacher_lastname']; ?></td>
                            <td><?php echo $class['subject_name']; ?></td>
                            <td><?php echo $class['start_class']; ?></td>
                            <td><?php echo $class['end_class']; ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer text-muted">
                  Grade <?php echo $gradeName; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="card">
          <div class="card-header">
            No schedule found
          </div>
          <div class="card-body text-center">
            <p class="card-text">It looks like have not get any schedule yet, please wait.</p>
            <a href="<?php echo BASE_URL?>/home.php" class="btn btn-primary">Profile</a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>
</div>

<?php path("footer"); ?>
