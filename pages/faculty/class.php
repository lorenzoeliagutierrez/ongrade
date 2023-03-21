<?php
require '../../includes/session.php';

$class_id = $_GET['class_id'];
$section = $_GET['section'];
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
              <h1 class="m-0">Students</h1>
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
            <h3 class="card-title"><b><?php echo $section?>'s</b> List of Students</h3>

            <div class="card-tools">
              <a class="btn btn-primary btn-sm">Class History</a>
            </div>
          </div>
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Student ID</th>
                  <th>Student Name</th>
                  <th>Course</th>
                  <th>Prelims</th>
                  <th>Midterms</th>
                  <th>Finalterms</th>
                  <th>Final Grade</th>
                  <th>Numerical Grade</th>
                  <th>Remarks</th>
                  <th>Absences</th>
                  <th>Update At</th>
                  <th>Updated By</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $load_info = mysqli_query($conn, "SELECT *, CONCAT(tbl_students.lastname, ', ', tbl_students.firstname, ' ', tbl_students.middlename)  as fullname
                FROM tbl_enrolled_subjects 
                LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id
                LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
                LEFT JOIN tbl_schoolyears ON tbl_schoolyears.stud_id = tbl_students.stud_id
                LEFT JOIN tbl_schedules ON tbl_schedules.class_id = tbl_enrolled_subjects.class_id
                LEFT JOIN tbl_courses ON tbl_courses.course_id = tbl_schoolyears.course_id
                WHERE tbl_schedules.class_id = '$class_id'
                AND tbl_schedules.section = '$section' 
                AND tbl_schoolyears.ay_id = '$_SESSION[active_acadyear]'
                AND tbl_schoolyears.sem_id = '$_SESSION[active_semester]'
                AND tbl_schoolyears.remark = 'Approved'");

                while ($row = mysqli_fetch_array($load_info))  {
                ?>
                <tr>
                  <td></td>
                  <td><?php echo strtoupper($row['fullname']); ?></td>
                  <td><?php echo $row['course']; ?></td>
                  <td><?php echo $row['stud_no']; ?></td>
                  <td><?php echo $row['prelim']; ?></td>
                  <td><?php echo $row['midterm']; ?></td>
                  <td><?php echo $row['finalterm']; ?></td>
                  <td><?php echo $row['ofgrade']; ?></td>
                  <td><?php echo $row['numgrade']; ?></td>
                  <td><?php echo $row['remarks']; ?></td>
                  <td><?php echo $row['absences']; ?></td>
                  <td><?php echo $row['last_update']; ?></td>
                  <td><?php echo $row['updated']; ?></td>
                  <td>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg<?php echo $row['enrolled_subj_id']; ?>">Enter Grade</button>
                  </td>
                </tr>
                    <!-- Modal for grade input -->
                    <div class="modal fade" id="modal-lg<?php echo $row['enrolled_subj_id']; ?>">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Enter Grade/Absences for <b><?php echo strtoupper($row['fullname']); ?></b></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="userData/enter.grade.php" method="POST">
                              <input name="enrolled_subj_id" value="<?php echo $row['enrolled_subj_id']; ?>" hidden>
                              <input name="special_tut" value="<?php echo $row['special_tut']; ?>" hidden>
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Prelims</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." onkeyup="ofGrade()" name="prelim" id="prelim" value="<?php echo $row['prelim']?>">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Midterms</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." onkeyup="ofGrade()" name="midterm" id="midterm" value="<?php echo $row['midterm']?>">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Finalterm</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." onkeyup="ofGrade()" name="finalterm" id="finalterm" value="<?php echo $row['finalterm']?>">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Final Grade</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." name="ofgrade" id="ofgrade" value="<?php echo $row['ofgrade']?>" disabled>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Numerical Grade</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." name="numgrade" value="<?php echo $row['numgrade']?>" disabled>
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Final Remark</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." name="remarks" value="<?php echo $row['remarks']?>" disabled>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-4">
                                  <div class="form-group">
                                    <label>Absences</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." name="absences" value="<?php echo $row['absences']?>">
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </div>
                      </div>
                    </div>
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
    function ofGrade()
        {
            num1 = 0;
            num2 = 0;
            num3 = 0;

            var num1 = parseFloat(document.getElementById("prelim").value * 1);
            var num2 = parseFloat(document.getElementById("midterm").value * 1);
            var num3 = parseFloat(document.getElementById("finalterm").value * 1);

            var total = +((num1 + num2 + num3)/3 ).toFixed(2);

            if (total <= 74) {
              var num = 5.0
              var num

            } elseif (total <= 79.49) {
              
            } elseif (total <= 82.49) {
              
            } elseif (total <= 84.49) {
              
            } elseif (total <= 87.49) {
              
            } elseif (total <= 92.49) {
              
            } elseif (total <= 95.49) {
              
            } elseif (total <= 97.49) {
              
            } elseif (total <= 99.99) {
              
            } else (total <= 100) {
              
            }


            document.getElementById('ofgrade').value = total.toLocaleString("en-US");

        }

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