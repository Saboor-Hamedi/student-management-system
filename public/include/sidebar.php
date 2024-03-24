<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?php echo BASE_URL ?>/home.php" class="brand-link">
    <img src="<?php assets("img/AdminLTELogo.png") ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">ITB</span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php assets("img/user2-160x160.jpg") ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?php echo BASE_URL ?>/home.php" class="d-block">
          <?php
          if (!empty ($username)) {
            echo ucfirst($username);
          } else {
            echo "Guest";
          }

          ?>
        </a>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?php echo BASE_URL ?>/home.php" class="nav-link">
            <i class="fas fa-home mr-2"></i>
            <p>Home</p>
          </a>
        </li>

        <?php if ($roles == 0): ?>

        <li class="nav-item ">
          <a href="<?php echo BASE_URL ?>/profile/register.php" class="nav-link ">
            <i class="fas fa-users mr-2"></i>
            <p>Students Profile</p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="<?php echo BASE_URL ?>/teacher/profile.php" class="nav-link ">
            <i class="fas fa-users mr-2"></i>
            <p>Teachers Profile</p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="<?php echo BASE_URL ?>/register/register.php" class="nav-link ">
            <i class="fas fa-user mr-2"></i>
            <p>Register User</p>
          </a>
        </li>
        <!-- Add Subjects -->
        <li class="nav-item">
          <a href="<?php echo BASE_URL ?>/subjects/store.php" class="nav-link ">
            <i class="fas fa-book mr-2"></i>
            <p>Add Subjects</p>
          </a>
        </li>
        <?php elseif ($roles == 1): ?>
        <li class="nav-item">
          <a href="<?php echo BASE_URL?>/profile/profile.php" class="nav-link">
            <i class="fas fa-users mr-2"></i>
            <p>Profile</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_URL ?>/profile/schedule.php" class="nav-link">
            <i class="fas fa-users mr-2"></i>
            <p>Schedule</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_URL ?>/profile/scores.php" class="nav-link">
            <i class="fas fa-users mr-2"></i>
            <p>Scores</p>
          </a>
        </li>

        <li class="nav-item menu-open">
          <a href="<?php echo BASE_URL ?>/scores.php" class="nav-link active">
            <i class="nav-icon fas fa-th mr-2"></i>
            <p>All Grades</p>
          </a>
          <ul class="nav nav-treeview">
            <?php 
              $sql = "SELECT id, grades FROM classes WHERE student_id = $user_id GROUP BY classes.grades ORDER BY classes.grades ASC";
              ?>
            <?php $result = $database->query($sql); ?>
            <?php if (!empty ($result)): ?>
            <?php foreach ($result as $row): ?>
            <li class="nav-item">
              <a href="<?php echo BASE_URL ?>/show_classes.php?classes<?php echo $row['id']; ?>" class=" nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Grade
                  <?php echo $row['grades']; ?>
                </p>
              </a>
            </li>
            <?php endforeach; ?>
            <?php else: ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>No classes</p>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php else: ?>
        <li class="nav-item">
          <a href="<?php echo BASE_URL ?>/profile/profile.php" class="nav-link">
            <i class="fas fa-users mr-2"></i>
            <p>Profile</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo BASE_URL ?>/scores/score.php" class="nav-link">
            <i class="fa fa-calculator mr-2"></i>
            <p>Score</p>
          </a>
        </li>
        <?php endif ?>
        <li class="nav-item">
          <a href="/include/logout.php" class="nav-link">
            <i class="fas fa-sign-out-alt mr-2"></i>
            <p>Logout</p>
          </a>
        </li>
        </a>
      </ul>
    </nav>
  </div>
</aside>