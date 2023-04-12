<?php
include '../../../includes/session.php';

$stud_id = $_GET['stud_id'];

if (isset($_POST['submit'])) {

    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $student_info = mysqli_query($conn, "UPDATE tbl_schoolyears SET accounting_status = '$status'
    WHERE sem_id = '$_SESSION[active_semester]' AND ay_id = '$_SESSION[active_acadyear]' AND stud_id = '$stud_id'");
    
    $_SESSION['update_success'] = true;
    header("location: ../list.students.php");

} else {
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $student_info = mysqli_query($conn, "UPDATE tbl_schoolyears SET accounting_status = '$status'
    WHERE sem_id = '$_SESSION[active_semester]' AND ay_id = '$_SESSION[active_acadyear]'");
    
    $_SESSION['update_success'] = true;
    header("location: ../list.students.php");

}




?>