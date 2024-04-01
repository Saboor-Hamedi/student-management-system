<?php
require_once __DIR__ . '/../../../App/config/path.php';
path('header');

use Thesis\config\Auth;
use Thesis\controllers\grade\Grades;

?>


<?php Auth::authenticate([1]); ?>
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
          $sql = "SELECT * FROM classes 
                  INNER JOIN teachers on classes.teacher_id=teachers.teacher_id
                  WHERE student_id = {$user_id} ORDER BY classes.grades desc";
          $classes = $database->query($sql);

          // Group classes by grade
          $groupedClasses = [];
          foreach ($classes as $class) {
            $gradeName = $class['grades']; // Assuming 'grades' is the field for grade name in your classes table
            if (!isset($groupedClasses[$gradeName])) {
              $groupedClasses[$gradeName] = [];
            }
            $groupedClasses[$gradeName][] = $class;
          }

          // Check if groupedClasses is empty
          if (empty($groupedClasses)) {
            echo "No schedule yet.";
          } else {
          ?>

            <div class="card">
              <div class="card-header">Schedule</div>
              <div class="card-body">
                <?php foreach ($groupedClasses as $gradeName => $classesForGrade) : ?>
                  <div class="card mt-2">
                    <div class="card-header ">
                      Grade <?php echo $gradeName; ?>
                    </div>
                  </div>
                  <table class="table table-hover table-condensed custom-table">
                    <thead>
                      <tr>
                        <th>Grade</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Start</th>
                        <th>End</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($classesForGrade as $class) : ?>
                        <tr>
                          <td><?php echo $gradeName; ?></td>
                          <td><?php echo $class['subject_name']; ?></td>
                          <td><?php echo $class['teacher_lastname']; ?></td>
                          <td><?php echo $class['start_class']; ?></td>
                          <td><?php echo $class['end_class']; ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                <?php endforeach; ?>
              </div>
            </div>

          <?php
          } // End of else block
          ?>
          </table>
        </div>
      </div>
    </div>
</div>
</div>



</section>
</div>

<?php path("footer"); ?>