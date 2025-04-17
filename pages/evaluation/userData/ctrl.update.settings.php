<?php
require '../../../includes/session.php';

if (isset($_POST['submit'])) {

    $datefrom = mysqli_real_escape_string($conn, $_POST['datefrom']);
    $dateto = mysqli_real_escape_string($conn, $_POST['dateto']);

    $update_dates = mysqli_query($conn, "UPDATE tbl_eval_settings SET day_start = '$datefrom', day_end = '$dateto'");

    header("location: ../evaluation.setting.php");


}


?>