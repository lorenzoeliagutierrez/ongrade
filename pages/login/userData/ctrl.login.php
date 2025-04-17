<?php
include '../../../includes/conn.php';
date_default_timezone_set("Asia/Manila");
ob_start();
session_start();

//check users
if (isset($_POST['submit']) || isset($_SESSION['update_success'])) {

    if (isset($_SESSION['update_success'])) {
        $username = $_SESSION['username'];
        unset($_SESSION['username']);
        $password = $_SESSION['password'];
        unset($_SESSION['password']);

        unset($_SESSION['email']);

    } else {

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
    }

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
    
    $estaff = mysqli_query($conn, "SELECT * FROM tbl_enrollment_staff WHERE username = '$username'");
    $numrow_estaff = mysqli_num_rows($estaff);

    $hr = mysqli_query($conn, "SELECT * FROM tbl_hr WHERE username = '$username'");
    $numrow_hr = mysqli_num_rows($hr);

    if ($numrow_sa > 0) {
        $row = mysqli_fetch_array($super_admin);
        $hashedpass = password_verify($password, $row['password']);

        if ($hashedpass == true) {
            $_SESSION['role'] = "Super Administrator";
            $_SESSION['id'] = $row['sa_id'];
            $_SESSION['name'] = $row['name'];

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
            $_SESSION['name'] = $row['admin_lastname'] . ", " . $row['admin_firstname'];

            header("location: ../../dashboard/index.php");

        } else {
            $_SESSION['password_incorrect'] = true;
            header("location: ../login.php");
        }

    }  elseif ($numrow_estaff > 0) {
        $row = mysqli_fetch_array($estaff);
        $hashedpass = password_verify($password, $row['password']);

        if ($hashedpass == true) {
            $_SESSION['role'] = "Enrollment Staff";
            $_SESSION['id'] = $row['admin_id'];
            $_SESSION['name'] = $row['admin_lastname'] . ", " . $row['admin_firstname'];

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
            $_SESSION['name'] = $row['faculty_lastname'] . ", " . $row['faculty_firstname'];

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
            $_SESSION['name'] = $row['faculty_lastname'] . ", " . $row['faculty_firstname'];

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
            $_SESSION['name'] = $row['lastname'] . ", " . $row['firstname'];

            $select_settings = mysqli_query($conn, "SELECT * FROM tbl_eval_settings");
            $row = mysqli_fetch_array($select_settings);
            $start_date = date("Y-m-d", strtotime($row['day_start']));
            $start_end = date("Y-m-d", strtotime($row['day_end']));
            
            $date_now = date("Y-m-d", time());
            
            if ($date_now >= $start_date && $date_now <= $start_end) {
               header("location: ../../evaluation/userData/ctrl.check.evaluation.php");
            
            } else {
                header("location: ../../dashboard/index.php");
            }
        } else {
            $_SESSION['password_incorrect'] = true;
            header("location: ../login.php");
        }

    } elseif ($numrow_hr > 0) {
        $row = mysqli_fetch_array($hr);
        $hashedpass = password_verify($password, $row['password']);

        if ($hashedpass == true) {
            $_SESSION['role'] = "Human Resource";
            $_SESSION['id'] = $row['hr_id'];
            $_SESSION['name'] = $row['lastname'] . ", " . $row['firstname'];

            header("location: ../../dashboard/index.php");

        } else {
            $_SESSION['password_incorrect'] = true;
            header("location: ../login.php");
        }

    } else {
        $_SESSION['username_incorrect'] = true;
        header("location: ../login.php");
    }
}
?>