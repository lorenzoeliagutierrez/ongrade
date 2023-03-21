<?php
include '../../../includes/conn.php';


if (isset($_POST['submit'])) {

    $enrolled_subj_id = mysqli_real_escape_string($conn,$_POST['enrolled_subj_id']);
    $special_tut = mysqli_real_escape_string($conn,$_POST['special_tut']);
    $prelim = mysqli_real_escape_string($conn,$_POST['prelim']);
    $midterm = mysqli_real_escape_string($conn,$_POST['midterm']);
    $finalterm = mysqli_real_escape_string($conn,$_POST['finalterm']);
    $ofgrade = mysqli_real_escape_string($conn,$_POST['ofgrade']);
    $numgrade = mysqli_real_escape_string($conn,$_POST['numgrade']);
    $absences = mysqli_real_escape_string($conn,$_POST['absences']);
    

}