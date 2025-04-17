<?php
require '../../includes/session.php';

$class_id = $_GET['class_id'];
$section = $_GET['section'];

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
  <title>Dashboard | OnGrade - Bacoor</title>

  <?php include '../../includes/links.php'; ?>


</head>
<script>
  function selectAll() {
    if (document.getElementById('exampleCheck1').checked) {
      $('input.select-all').each(function () {
        this.checked = true;
      });
    } else {
      $('input.select-all').each(function () {
        this.checked = false;
      });
    }
  }
</script>

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
          <form action="userData/update.section.class.php?class_id=<?php echo $class_id; ?>&section=<?php echo $section; ?>&acadyear=<?php echo $acadyear?>&semester=<?php echo $semester?>"
            method="POST">
            <div class="card-header">
              <h3 class="card-title"><b>
                  <?php echo $section ?>'s
                </b> List of Students</h3>

              <div class="card-tools">
              <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#modal-lg-class-history">Transfer selected students</button>
                <div class="modal fade" id="modal-lg-class-history">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Transfer <b><?php echo $section; ?></b> students</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Current Section</label>
                                  <input type="text" class="form-control" placeholder="Enter ..."
                                    name="midterm" id="midterm" value="<?php echo $section?>" disabled>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label>Transfer to</label>
                                  <select class="form-control select2" name="new_class_id">
                                    <option selected disabled>Select section</option>
                                    <?php
                                    $current_sched = mysqli_query($conn, "SELECT * FROM tbl_schedules WHERE class_id = '$class_id' AND section = '$section'");
                                    $row = mysqli_fetch_array($current_sched);
                                    $sechedules_info = mysqli_query($conn, "SELECT * FROM tbl_schedules
                                    LEFT JOIN tbl_subjects_new ON tbl_schedules.subj_id = tbl_subjects_new.subj_id
                                    LEFT JOIN tbl_faculties_staff ON tbl_schedules.faculty_id = tbl_faculties_staff.faculty_id
                                    WHERE class_code = '$row[class_code]' AND acad_year = '$acadyear' AND semester = '$semester' AND section NOT IN ('$section')");
                                    while ($row1 = mysqli_fetch_array($sechedules_info)) {
                                    ?>
                                    <option value="<?php echo $row1['class_id']?>"><?php echo $row1['class_code'] .' - '. $row1['section'] .' ('. $row1['faculty_lastname'] .')'?></option></option>
                                    <?php
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                          </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="card-body">
              <table id="example4" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="selectAll()">
                        <label class="form-check-label" for="exampleCheck1"></label>
                      </div>
                    </th>
                    <th>Image</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Update At</th>
                    <th>Updated By</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $load_info = mysqli_query($conn, "SELECT *, CONCAT(tbl_students.lastname, ', ', tbl_students.firstname, ' ', tbl_students.middlename)  as fullname, tbl_enrolled_subjects.last_update
                FROM tbl_enrolled_subjects 
                LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id
                LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
                LEFT JOIN tbl_schoolyears ON tbl_schoolyears.stud_id = tbl_students.stud_id
                LEFT JOIN tbl_schedules ON tbl_schedules.class_id = tbl_enrolled_subjects.class_id
                LEFT JOIN tbl_courses ON tbl_courses.course_id = tbl_schoolyears.course_id
                WHERE tbl_schedules.class_id = '$class_id'
                AND tbl_schedules.section = '$section' 
                AND tbl_schoolyears.ay_id = '$acadyear'
                AND tbl_schoolyears.sem_id = '$semester'
                AND tbl_schoolyears.remark = 'Approved'
                ORDER BY lastname ASC");

                  while ($row = mysqli_fetch_array($load_info)) {
                    $last_updated = new DateTime($row['last_update']);
                    ?>
                    <tr>
                      <td>
                        <div class="form-check">
                          <input type="checkbox" class="form-check-input select-all" id="exampleCheck1" value="<?php echo $row['enrolled_subj_id']?>" name="enrolled_subj_id[]">
                        </div>
                      </td>
                      <td>
                        <?php
                        if (empty($row['img'])) {

                        } else {
                          ?>
                          <img style="width: 80px; height: 80px;"
                            src="data:image/jpeg;base64,<?php echo base64_encode($row['img']) ?>">
                          <?php
                        }
                        ?>
                      </td>
                      <td>
                        <?php echo $row['stud_no']; ?>
                      </td>
                      <td>
                        <?php echo strtoupper($row['fullname']); ?>
                      </td>
                      <td>
                        <?php echo $row['course_abv']; ?>
                      </td>
                      <td>
                        <?php echo $last_updated->format('h:i a \o\n M d, Y') ?>
                      </td>
                      <td>
                        <?php echo $row['updated']; ?>
                      </td>
                    </tr>
                    <?php
                  }
                  ?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
          </form>
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