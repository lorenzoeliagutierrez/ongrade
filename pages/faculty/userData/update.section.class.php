<?php
include '../../../includes/session.php';
$class_id = $_GET['class_id'];
$section = $_GET['section'];

if (isset($_GET['semester']) && isset($_GET['acadyear'])) {
  $acadyear = $_GET['acadyear'];
  $semester = $_GET['semester'];
} else {
  $acadyear = $_SESSION['active_acadyear'];
  $semester = $_SESSION['active_semester'];
}

if (isset($_POST['submit'])) {

    $enrolled_subj_array = array();

    if (isset($_POST['enrolled_subj_id'])) {
        $temp_array = $_POST['enrolled_subj_id'];

        foreach ($temp_array as $index) {
            if ($index != null) {
                array_push($enrolled_subj_array, $index);
            } else {
                array_push($enrolled_subj_array, 0);
            }
        }
    }

    echo $enrolled_subj_array[0];

    foreach ($enrolled_subj_array as $enrolled_subj_id) {

        $new_class_id = mysqli_real_escape_string($conn, $_POST['new_class_id']);
    
        $student_sched = mysqli_query($conn, "UPDATE tbl_enrolled_subjects SET class_id = '$new_class_id' WHERE enrolled_subj_id = '$enrolled_subj_id'");
    
    }

    $_SESSION['update_success'] = true;
    header("location: ../transfer.class.php?class_id=" . $class_id . "&section=" . $section . "&acadyear=" . $acadyear . "&semester=" .$semester);
}


?>