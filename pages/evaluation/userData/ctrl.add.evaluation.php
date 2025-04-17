<?php
require '../../../includes/session.php';

if (isset($_POST['submit'])) {

    $rate_array = [];
    if (isset($_POST['rate'])) {
        $temp_array = $_POST['rate'];

        foreach ($temp_array as $index) {
            if ($index != null) {
                array_push($rate_array, $index);
            } else {
                array_push($rate_array, 0);
            }
        }
 
    }

    $rate = implode(", ", $rate_array);

    $comments = mysqli_real_escape_string($conn, $_POST['comments']);
    $improvement1 = mysqli_real_escape_string($conn, $_POST['improvement1']);
    $improvement2 = mysqli_real_escape_string($conn, $_POST['improvement2']);

    $insert_eval = mysqli_query($conn, "INSERT INTO tbl_evaluations (enrolled_subj_id, rating, comments, improvement1, improvement2, sem_id, ay_id) VALUES ('$_SESSION[enrolled_subj_id]', '$rate', '$comments', '$improvement1', '$improvement2', '$_SESSION[active_sem_id]', '$_SESSION[active_acad_id]')");

    header("location: ctrl.check.evaluation.php");


}


?>