<li class="nav-item">
  <a href="<?php echo BASE_URL ?>/home.php" class="nav-link">
    <i class="fas fa-home nav-icon"></i>
    <p>Home</p>
  </a>
</li>
<li class="nav-item menu-open">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Dashboard
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview" style="display: block;">
    <li class="nav-item">
    <li class="nav-item">
      <a href="<?php echo BASE_URL ?>/profile/schedule.php" class="nav-link">
        <i class="fas fa-table nav-icon"></i>
        <p>Schedule</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?php echo BASE_URL ?>/profile/scores.php" class="nav-link">
        <i class="fas fa-book nav-icon"></i>
        <p>Scores</p>
      </a>
    </li>
  </ul>
</li>
<!-- all Grades -->
<li class="nav-item menu-open">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      All Grades <?php echo $user_id;?>
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>


  <ul class="nav nav-treeview" style="display: block;">
  <?php
    $sql = "SELECT * FROM classes WHERE classes.student_id = {$user_id} GROUP BY classes.grades";
    $grades = $database->query($sql);
  ?>
    <?php foreach ($grades as $grade) : ?>
      <li class="nav-item">
        <a href="<?php echo BASE_URL ?>/profile/grade.php?grade=<?php echo $grade['grades']; ?>" class="nav-link">
          <i class="fas fa-solid fa-star nav-icon"></i>
          <p>Grade <?php echo $grade['grades']; ?></p>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>

</li>
<!-- end -->
<li class="nav-header">REGISTER</li>
<li class="nav-item">
  <a href="<?php echo BASE_URL ?>/profile/profile.php" class="nav-link">
    <i class="fas fa-users nav-icon"></i>
    <p>Profile</p>
  </a>
</li>



<!-- end drop down -->