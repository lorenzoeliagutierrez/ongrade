<!-- Preloader -->
<!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
</div> -->

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <?php
    if ($_SESSION['role'] == "Super Administrator") {
        $sa_info = mysqli_query($conn, "SELECT *, name AS fullname FROM tbl_super_admins WHERE sa_id = '$_SESSION[id]'");
        $row = mysqli_fetch_array($sa_info);

    } elseif ($_SESSION['role'] == "Registrar") {
        $admin_info = mysqli_query($conn, "SELECT *, CONCAT(admin_lastname, ', ', admin_firstname) AS fullname FROM tbl_admins WHERE admin_id = '$_SESSION[id]'");
        $row = mysqli_fetch_array($admin_info);

    } elseif ($_SESSION['role'] == "Adviser") {
        $faculty_info = mysqli_query($conn, "SELECT *, CONCAT(faculty_lastname, ', ', faculty_firstname) AS fullname FROM tbl_faculties WHERE faculty_id = '$_SESSION[id]'");
        $row = mysqli_fetch_array($faculty_info);

    } elseif ($_SESSION['role'] == "Faculty Staff") {
        $faculty_staff_info = mysqli_query($conn, "SELECT *, CONCAT(faculty_lastname, ', ', faculty_firstname) AS fullname FROM tbl_faculties_staff WHERE faculty_id = '$_SESSION[id]'");
        $row = mysqli_fetch_array($faculty_staff_info);

    } elseif ($_SESSION['role'] == "Student") {
        $student_info = mysqli_query($conn, "SELECT *, CONCAT(lastname, ', ', firstname) AS fullname FROM tbl_students WHERE stud_id = '$_SESSION[id]'");
        $row = mysqli_fetch_array($student_info);

    }

    ?>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="../../docs/assets/img/logo.png" class="user-image img-circle img-size-32">
                <span class="badge badge-warning navbar-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <div class="dropdown-item">
                    <div class="media">
                    <img src="../../docs/assets/img/logo.png" alt="User Avatar" class="img-size-50 img-circle mr-3">
                    <div class="media-body">
                        <h3 class="dropdown-item-title">
                            <b>
                                <?php echo $_SESSION['name']; ?>
                            </b>
                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                        </h3>
                        <p class="text-sm"><?php echo $row['email']?></p>
                        <p class="text-sm text-muted"><i class="far fa-user mr-1"></i><?php echo $row['username']?></p>
                    </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="../user/edit.account.php" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Edit Account
                </a>
                <div class="dropdown-divider"></div>
                <a href="../login/userData/ctrl.logout.php" class="dropdown-item dropdown-footer"><b>Log Out</b></a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->