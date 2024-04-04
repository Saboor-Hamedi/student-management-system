<li class="nav-item">
  <a href="<?php echo BASE_URL ?>/home.php" class="nav-link">
    <i class="fas fa-home nav-icon"></i>
    <p>Home</p>
  </a>
</li>
<li class="nav-item menu-is-opening menu-open">
  <a href="#" class="nav-link">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Dashboard
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview" style="display: block;">
    <li class="nav-item">
      <a href="<?php echo BASE_URL ?>/student/students.php" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Students</p>
      </a>
    </li>
    <li class="nav-item">
    <li class="nav-item">
      <a href="<?php echo BASE_URL ?>/teacher/teachers.php" class="nav-link">
        <i class="far fa-circle nav-icon"></i>
        <p>Teachers</p>
      </a>
    </li>
  </ul>
</li>
<li class="nav-header">REGISTER</li>
<li class="nav-item">
  <a href="<?php echo BASE_URL ?>/users/register.php" class="nav-link">
    <i class="nav-icon fas fa-bookmark"></i>
    <p>
      Register
    </p>
  </a>
</li>
<!-- ================= -->
<li class="nav-item">
  <a href="<?php echo BASE_URL ?>/student/register.php" class="nav-link">
    <i class="fa fa-users nav-icon" aria-hidden="true"></i>
    <p>
      Student Profile
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="<?php echo BASE_URL ?>/teacher/register.php" class="nav-link">
    <i class="fa fa-users nav-icon" aria-hidden="true"></i>
    <p>
      Teacher Profile
    </p>
  </a>
</li>
<!-- =========== -->
<li class="nav-item">
  <a href="<?php echo BASE_URL ?>/subject/subject.php" class="nav-link">
    <i class="nav-icon fas fa-mortar-pestle"></i>
    <p>
      Add Subjects
    </p>
  </a>
</li>