<?php
require_once __DIR__ . '/../../../App/config/path.php';
path('header');
use Thesis\config\Auth;
?>


<?php Auth::authenticate([1]); ?>
<!-- header on the top, Navbar -->
<?php path('navbar'); ?>
<!-- Main Sidebar Container -->
<?php path('sidebar', ['roles' => $roles, 'username' => $username, 'user_id' => $user_id, 'database' => $database]); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <?php path('cards'); ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?php $sql = "SELECT * FROM classes 
                        INNER JOIN teachers on classes.teacher_id=teachers.teacher_id
                        WHERE student_id = {$user_id}"; ?>
          <?php $scores = $database->query($sql); ?>
          <div class="card">
            <div class="card-header">Schedule</div>
            <div class="card-body">

              <table class="table table-hover table-condensed custom-table">
                <?php if (!empty ($scores)): ?>
                <thead>
                  <tr>
                    <th>Grade</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                    <th>Start</th>
                    <th>End</th>
                  </tr>
                </thead>
                <?php foreach ($scores as $score): ?>
                <tbody>
                  <tr>
                    <td>
                      <?php echo $score['grades']; ?>
                    </td>
                    <td>
                      <?php echo $score['subject_name']; ?>
                    </td>
                    <td>
                      <?php echo $score['teacher_lastname']; ?>
                    </td>
                    <td>
                      <?php echo $score['start_class']; ?>
                    </td>
                    <td>
                      <?php echo $score['end_class']; ?>
                    </td>
                  </tr>
                </tbody>
                <?php endforeach ?>
                <?php else: ?>
                <td>
                  No schedule yet.
                </td>
                <?php endif; ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>



  </section>
</div>

<?php path("footer"); ?>