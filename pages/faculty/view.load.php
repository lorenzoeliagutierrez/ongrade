<?php
require '../../includes/session.php';

$faculty_id = $_GET['faculty_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

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
              <h1 class="m-0">Subject's Loads</h1>
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
            <?php
            $faculty_info = mysqli_query($conn, "SELECT CONCAT(faculty_lastname, ', ' , faculty_firstname) AS fullname FROM tbl_faculties_staff WHERE faculty_id = '$faculty_id'");
            $row = mysqli_fetch_array($faculty_info);
            ?>
            <h3 class="card-title"><b><?php echo $row['fullname']; ?>'s</b> Subjects Load for <b><?php echo $_SESSION['active_semester']?> - <?php echo $_SESSION['active_acadyear']?></b></h3>

            <div class="card-tools">
              <a class="btn btn-primary btn-sm">Class History</a>
            </div>
          </div>
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Subjects</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $load_info = mysqli_query($conn, "SELECT * FROM tbl_schedules LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_schedules.subj_id WHERE faculty_id = '$faculty_id' AND acad_year = '$_SESSION[active_acadyear]' AND semester = '$_SESSION[active_semester]'");

                while ($row = mysqli_fetch_array($load_info))  {
                ?>
                <tr>
                  <td><b><?php echo $row['class_code'].'</b> - '. $row['subj_desc']; ?></td>
                  <td><a href="section.load.php?class_code=<?php echo $row['class_code']; ?>&faculty_id=<?php echo $row['faculty_id']; ?>&subj_desc=<?php echo $row['subj_desc']; ?>" class="btn btn-primary btn-sm">View Sections</a>
                  </td>
                </tr>
                <?php
                }
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
    <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

</body>

</html>