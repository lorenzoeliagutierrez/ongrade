<?php
session_start();
ob_start();

include 'conn.php';

if (isset($_SESSION['role'])) {

} else {
    header("location: ../login/login.php");
}

$acad_year = mysqli_query($conn, "SELECT * FROM tbl_active_acads
LEFT JOIN tbl_acadyears ON tbl_acadyears.ay_id = tbl_active_acads.ay_id");

$row = mysqli_fetch_array($acad_year);
$_SESSION['active_acadyear'] = $row['academic_year'];
$_SESSION['active_acad_id'] = $row['ay_id'];

$semester = mysqli_query($conn, "SELECT * FROM tbl_active_sem
LEFT JOIN tbl_semesters ON tbl_semesters.sem_id = tbl_active_sem.sem_id");

$row = mysqli_fetch_array($semester);
$_SESSION['active_semester'] = $row['semester'];
$_SESSION['active_sem_id'] = $row['sem_id'];

date_default_timezone_set("Asia/Manila");




?>