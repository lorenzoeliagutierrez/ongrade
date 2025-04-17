<?php
require '../../../includes/session.php';


$check_eval_status = mysqli_query($conn, "SELECT * FROM tbl_schoolyears WHERE stud_id = '$_SESSION[id]' AND ay_id = '$_SESSION[active_acadyear]' AND sem_id = '$_SESSION[active_semester]'");
$row = mysqli_fetch_array($check_eval_status);

if ($row['eval_status'] == "Completed") {

    header("location: ../../dashboard/index.php");

} else {
    //check students evaluations chu chu
    $check_enrolled_subj = mysqli_query($conn, "SELECT * FROM tbl_enrolled_subjects WHERE stud_id = '$_SESSION[id]' AND acad_year = '$_SESSION[active_acadyear]' AND semester = '$_SESSION[active_semester]'");

    $total = 0;
    $eval = 0;
    while ($row = mysqli_fetch_array($check_enrolled_subj)) {
        $check_eval = mysqli_query($conn, "SELECT * FROM tbl_evaluations WHERE enrolled_subj_id = '$row[enrolled_subj_id]' AND sem_id = '$_SESSION[active_sem_id]' AND ay_id = '$_SESSION[active_acad_id]'");
        $result = mysqli_num_rows($check_eval);

        if ($result == 0) {
            $_SESSION['enrolled_subj_id'] = $row['enrolled_subj_id'];
            header ("location: ../message.php");
        } else {
            $eval++;
        }
    $total++;
    }

}

if ($total == $eval) {
    header("location:  ../../dashboard/index.php");
}





?>