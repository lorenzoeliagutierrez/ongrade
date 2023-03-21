  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-danger elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../../docs/assets/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><b>OnGrade</b> System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../docs/assets/img/logo.png" class="img-circle elevation-2 mt-2" alt="User Image">
        </div>
        <div class="info">
          <a class="d-block"><?php echo $_SESSION['name']; ?></a>
          <p class="mb-0"><small><?php echo $_SESSION['role']; ?></small></p>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="../dashboard/index.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php
            if ($_SESSION['role'] == "Super Administrator") {
          ?>
          <li class="nav-item">
            <a href="../dashboard/index.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php
            } elseif ($_SESSION['role'] == "Registrar") {
          ?>
          <li class="nav-item">
            <a href="../faculty/faculty.load.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Faculty's Load
              </p>
            </a>
          </li>
          <?php
            } elseif ($_SESSION['role'] == "Adviser") {
          ?>
          <li class="nav-item">
            <a href="index.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php
            } elseif ($_SESSION['role'] == "Faculty Staff") {
            } elseif ($_SESSION['role'] == "Student") {
            }
          ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>