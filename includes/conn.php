<?php

    $server = 'localhost';
    $username = 'root';
    $password = '';
    $db = 'enrollmentbac';

    $conn = new mysqli($server, $username, $password, $db);

    date_default_timezone_set('Asia/Manila');

    if (isset($_SESSION['role'])) {

    } else {
        header("location: ../login/login.php");
    }

?>