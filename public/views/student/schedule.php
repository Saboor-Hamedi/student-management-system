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
<?php path('sidebar', ['roles' => $roles, 'username' => $username, 'user_id' => $user_id, 'database' => $database]); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <?php //path('cards'); 
    ?>
    <div class="card"></div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?php
          $scheduleController = new Schedule();
          $groupedClasses = $scheduleController->fetchSchedule(); ?>
          <!-- Check if groupedClasses is empty -->
          <div class="card">
            <div class="card-header">Schedule</div>
            <div class="card-body">
              <?php if (!empty($groupedClasses)) : ?>
                <table class="table table-hover table-condensed custom-table">
                  <?php foreach ($groupedClasses as $gradeName => $classesForGrade) : ?>
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
                    <div class="card-footer">
                      Grade <?php echo $gradeName; ?>
                    </div>
                  <?php endforeach; ?>
                </table>
              <?php else : ?>
                <tr>
                  <td>No schedule found</td>
                </tr>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</div>



</section>
</div>

<?php path("footer"); ?>