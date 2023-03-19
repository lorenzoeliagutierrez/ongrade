<?php
include '../../../includes/conn.php';
ob_start();
session_start();

//check users

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$super_admin = mysqli_query($conn, "SELECT * FROM tbl_super_admins WHERE username = '$username'");
$numrow_sa = mysqli_num_rows($super_admin);

$admin = mysqli_query($conn, "SELECT * FROM tbl_admins WHERE username = '$username'");
$numrow_admin = mysqli_num_rows($admin);

$faculty = mysqli_query($conn, "SELECT * FROM tbl_faculties WHERE username = '$username'");
$numrow_faculty = mysqli_num_rows($faculty);

$faculty_staff = mysqli_query($conn, "SELECT * FROM tbl_faculties_staff WHERE username = '$username'");
$numrow_faculty_staff = mysqli_num_rows($faculty_staff);

$student = mysqli_query($conn, "SELECT * FROM tbl_students WHERE username = '$username'");
$numrow_student = mysqli_num_rows($student);

if ($numrow_sa > 0) {
    $row = mysqli_fetch_array($super_admin);
    $hashedpass = password_verify($password, $row['password']);

    if ($hashedpass == true) {
        $_SESSION['role'] = "Super Administrator";
        $_SESSION['id'] = $row['sa_id'];
        $_SESSION['name']   = $row['name'];
        
        header("location: ../../dashboard/index.php");

    } else {
        $_SESSION['password_incorrect'] = true;
        header("location: ../login.php");
    }
} elseif ($numrow_admin > 0) {
    $row = mysqli_fetch_array($admin);
    $hashedpass = password_verify($password, $row['password']);

    if ($hashedpass == true) {
        $_SESSION['role'] = "Registrar";
        $_SESSION['id'] = $row['admin_id'];
        $_SESSION['name']   = $row['admin_lastname'] . ", " . $row['admin_firstname'];

        header("location: ../../dashboard/index.php");

    } else {
        $_SESSION['password_incorrect'] = true;
        header("location: ../login.php");
    }

} elseif ($numrow_faculty > 0) {
    $row = mysqli_fetch_array($faculty);
    $hashedpass = password_verify($password, $row['password']);

    if ($hashedpass == true) {
        $_SESSION['role'] = "Adviser";
        $_SESSION['id'] = $row['faculty_id'];
        $_SESSION['name']   = $row['faculty_lastname'] . ", " . $row['faculty_firstname'];

        header("location: ../../dashboard/index.php");

    } else {
        $_SESSION['password_incorrect'] = true;
        header("location: ../login.php");
    }

} elseif ($numrow_faculty_staff > 0) {
    $row = mysqli_fetch_array($faculty_staff);
    $hashedpass = password_verify($password, $row['password']);

    if ($hashedpass == true) {
        $_SESSION['role'] = "Faculty Staff";
        $_SESSION['id'] = $row['faculty_id'];
        $_SESSION['name']   = $row['faculty_lastname'] . ", " . $row['faculty_firstname'];

        header("location: ../../dashboard/index.php");

    } else {
        $_SESSION['password_incorrect'] = true;
        header("location: ../login.php");
    }

} elseif ($numrow_student > 0) {
    $row = mysqli_fetch_array($student);
    $hashedpass = password_verify($password, $row['password']);

    if ($hashedpass == true) {
        $_SESSION['role'] = "Student";
        $_SESSION['id'] = $row['stud_id'];
        $_SESSION['name']   = $row['lastname'] . ", " . $row['firstname'];

        header("location: ../../dashboard/index.php");

    } else {
        $_SESSION['password_incorrect'] = true;
        header("location: ../login.php");
    }

} else {
    $_SESSION['username_incorrect'] = true;
    header("location: ../login.php");
}
?>