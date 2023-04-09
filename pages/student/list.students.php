<?php
require '../../includes/session.php';

if (isset($_GET['semester']) && isset($_GET['acadyear'])) {
    $acadyear = $_GET['acadyear'];
    $semester = $_GET['semester'];
} else {
    $acadyear = $_SESSION['active_acadyear'];
    $semester = $_SESSION['active_semester'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student List | OnGrade - Bacoor</title>

  <?php include '../../includes/links.php'; ?>

</head>

<body class="hold-transition layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <?php include '../../includes/navbar.php' ?>

    <?php include '../../includes/sidebar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Student List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"></a></li>
                <li class="breadcrumb-item active"></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Student List</h3>
            <div class="card-tools">
                
            </div>
          </div>
          <div class="card-body">
            <form method="POST">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" placeholder="Search student">
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
          </div>
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Student</th>
                  <th>Course</th>
                  <th>Year Level</th>
                  <th>Payment Status</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($_POST['search'])) {
                    $search = addslashes($_POST['search']);

                    $student_info = mysqli_query($conn, "SELECT *, CONCAT(tbl_students.lastname, ', ', tbl_students.firstname, ' ', tbl_students.middlename)  as fullname
                    FROM tbl_schoolyears 
                    LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_schoolyears.stud_id
                    LEFT JOIN tbl_courses ON tbl_courses.course_id = tbl_schoolyears.course_id
                    LEFT JOIN tbl_year_levels ON tbl_year_levels.year_id = tbl_schoolyears.year_id
                    WHERE tbl_schoolyears.ay_id = '$acadyear'
                    AND tbl_schoolyears.sem_id = '$semester'
                    AND tbl_schoolyears.remark = 'Approved'
                    AND (firstname LIKE '%$search%'
                    OR middlename LIKE '%$search%'
                    OR lastname LIKE '%$search%'
                    OR course_abv LIKE '%$search%'
                    OR course LIKE '%$search%'
                    OR year_level LIKE '%$search%'
                    OR year_abv LIKE '%$search%'
                    OR stud_no LIKE '%$search%')
                    ORDER BY lastname");

                    while ($row = mysqli_fetch_array($student_info))  {
                ?>
                <tr>
                  <td><?php echo $row['fullname']?></td>
                  <td><?php echo $row['course_abv']?></td>
                  <td><?php echo $row['year_level']?></td>
                  <td></td>
                  <td>
                    <a href="" class="btn btn-primary btn-sm m-1">Subject Load</a>
                    <a href="" class="btn btn-primary btn-sm m-1">Change payment status</a>
                    <button type="button" class="btn btn-primary btn-sm m-1" data-toggle="dropdown">
                      Forms
                    </button>
                    <ul class="dropdown-menu">
                      <li class="dropdown-item"><a href="#">Curriculum</a></li>
                      <li class="dropdown-item"><a href="#">Curriculum w/ data</a></li>
                      <li class="dropdown-divider"></li>
                      <li class="dropdown-item"><a href="#">Permanent Record</a></li>
                      <li class="dropdown-item"><a href="#">Summary of Grade</a></li>
                    </ul>
                  </td>
                </tr>
                <?php
                }}
                ?>
              </tbody>
              <tfoot>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer"></div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include '../../includes/footer.php'; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <?php include '../../includes/script.php'; ?>
</body>

</html>