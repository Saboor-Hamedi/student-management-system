<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?php echo BASE_URL ?>/home.php" class="brand-link">
    <img src="<?php assets("img/AdminLTELogo.png") ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
          if (!empty($username)) {
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
        <?php if ($roles === 0) : ?>
          <?php require_once __DIR__ . '/nav/admin.php'; ?>
        <?php endif; ?>
        <!-- end admin -->
        <?php if ($roles === 2) : ?>
          <?php require_once __DIR__ . '/nav/teacher.php'; ?>
        <?php endif; ?>
        <!-- end teacher -->

        <?php if ($roles === 1) : ?>
          <?php require_once __DIR__ . '/nav/student.php'; ?>
        <?php endif; ?>
        <li class="nav-item">
          <a href="/include/logout.php" class="nav-link">
            <i class="fas fa-sign-out-alt nav-icon"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>


    <!-- Sidebar end -->

  </div>
</aside>