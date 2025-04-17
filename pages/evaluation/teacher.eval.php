<?php
require '../../includes/session.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In | OnGrade - Bacoor</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition evaluation-page">
    <div class="login-box" style="width: 1000px;">
        <!-- /.login-logo -->
        <div class="card card-outline card-danger">
            <div class="card-header text-center">

                <h3><b>Saint Francis of Assisi College - Bacoor</b></h3>
                <h5>Online Evaluation System</h5>

            </div>
            <form action="userData/ctrl.add.evaluation.php" method="POST">
                <div class="card-body">
                    <div class="container">
                        <?php
                        $select_teacher = mysqli_query($conn, "SELECT *, CONCAT(faculty_firstname, ' ', faculty_lastname) AS fullname FROM tbl_enrolled_subjects
                        LEFT JOIN tbl_schedules ON tbl_schedules.class_id = tbl_enrolled_subjects.class_id
                        LEFT JOIN tbl_faculties_staff ON tbl_faculties_staff.faculty_id = tbl_schedules.faculty_id
                        LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_schedules.subj_id
                        WHERE enrolled_subj_id = '$_SESSION[enrolled_subj_id]'");
                        $row = mysqli_fetch_array($select_teacher);
                        ?>
                        <div class="row mb-4 text-center">
                            <div class="col">
                            <h6><?php echo $_SESSION['active_semester'] .", ".$_SESSION['active_acadyear'];?></h6>
                            <h3><b><?php echo $row['subj_code'] .' - '. $row['subj_desc'];?></b></h3>
                            <h5>Instructor: <b><?php echo $row['fullname'];?></b></b></h5>
                            </div>
                        </div>
                        <div class="row">
                            <p class="login-box-msg text-left"><b>Directions: </b>Please select the appropriate rating
                                for the following items/actions of your instructor/professor. You are encouraged to
                                write-down your qualitative comments in the area provided in your answer sheets.</b></p>
                            <p class="login-box-msg text-left"><b>Rating Scale: </b></p>
                            <p class="login-box-msg text-left ml-3">
                                <b>4</b> – VERY SATISFACTORY (Performance of this item is done beyond expectations)<br>
                                <b>3</b> – SATISFACTORY (Performance of this item is done within the bounds of
                                expectations)<br>
                                <b>2</b> – FAIR (Performance of this item is done below the bounds of expectations)<br>
                                <b>1</b> – NEEDS IMPROVEMENT (This item is not performed)<br>
                            </p>
                        </div>
                        <p class="login-box-msg text-left"><b>Part I: Instructor</b></p>
                        <?php
                        $num = 1;
                        $select_questions = mysqli_query($conn, "SELECT * FROM tbl_questions WHERE question_id BETWEEN 1 AND 15");
                        while ($row = mysqli_fetch_array($select_questions)) {
                            ?>
                            <div class="row">
                                <div class="col-lg-8 form-group">
                                    <p class="login-box-msg text-left"><?php echo "<b>$num. </b>" . $row['question']; ?></p>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <input placeholder="Enter rating (1-4)" required type="number" name="rate[]" min="1" max="4" class="form-control">
                                </div>
                            </div>
                            <?php
                            $num++;
                        }
                        ?>
                        <p class="login-box-msg text-left"><b>Comments/Suggestions</b></p>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <textarea type="text" class="form-control" placeholder="Enter your comments or suggestions on your instructor" name="comments"></textarea>
                            </div>
                        </div>
                        <p class="login-box-msg text-left"><b>Part II: Course Evaluation Form. </b>Please provide
                            feedback regarding the COURSE that you have just identified, including feedback on
                            course structure, content, and instructor.</p>

                        <p class="login-box-msg"><b>Level of Effort</b></p>
                        <?php
                        $select_questions = mysqli_query($conn, "SELECT * FROM tbl_questions WHERE question_id BETWEEN 16 AND 16");
                        while ($row = mysqli_fetch_array($select_questions)) {
                            ?>
                            <div class="row">
                                <div class="form-group col-lg-8">
                                    <p class="login-box-msg text-left"><?php echo "<b>$num. </b>" . $row['question']; ?></p>
                                </div>
                                <div class="form-group col-lg-4">
                                    <input placeholder="Enter rating (1-4)" required type="number" name="rate[]" min="1" max="4" class="form-control">
                                </div>
                            </div>
                            <?php
                            $num++;
                        }
                        ?>
                        <p class="login-box-msg"><b>Contribution to Learning</b></p>
                        <?php
                        $select_questions = mysqli_query($conn, "SELECT * FROM tbl_questions WHERE question_id BETWEEN 17 AND 20");
                        while ($row = mysqli_fetch_array($select_questions)) {
                            ?>
                            <div class="row">
                                <div class="col-lg-8 form-group">
                                    <p class="login-box-msg text-left"><?php echo "<b>$num. </b>" . $row['question']; ?></p>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <input placeholder="Enter rating (1-4)" required type="number" name="rate[]" min="1" max="4" class="form-control">
                                </div>
                            </div>
                            <?php
                            $num++;
                        }
                        ?>
                        <p class="login-box-msg"><b>Skill and Responsiveness of the Instructor</b></p>
                        <?php
                        $select_questions = mysqli_query($conn, "SELECT * FROM tbl_questions WHERE question_id BETWEEN 21 AND 26");
                        while ($row = mysqli_fetch_array($select_questions)) {
                            ?>
                            <div class="row">
                                <div class="col-lg-8 form-group">
                                    <p class="login-box-msg text-left"><?php echo "<b>$num. </b>" . $row['question']; ?></p>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <input placeholder="Enter rating (1-4)" required type="number" name="rate[]" min="1" max="4" class="form-control">
                                </div>
                            </div>
                            <?php
                            $num++;
                        }
                        ?>
                        <p class="login-box-msg"><b>Course Content</b></p>
                        <?php
                        $select_questions = mysqli_query($conn, "SELECT * FROM tbl_questions WHERE question_id BETWEEN 27 AND 30");
                        while ($row = mysqli_fetch_array($select_questions)) {
                            ?>
                            <div class="row">
                                <div class="col-lg-8 form-group">
                                    <p class="login-box-msg text-left"><?php echo "<b>$num. </b>" . $row['question']; ?></p>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <input placeholder="Enter rating (1-4)" required type="number" name="rate[]" min="1" max="4" class="form-control">
                                </div>
                            </div>
                            <?php
                            $num++;
                        }
                        ?>
                        <p class="login-box-msg text-left"><b>Part III:</b> Please answer the following questions for
                            the improvement of the course.</p>
                        <p class="login-box-msg text-left"><b>31. </b>What aspects of this course were most useful or
                            valuable?</p>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <textarea type="text" class="form-control" name="improvement1"></textarea>
                            </div>
                        </div>
                        <p class="login-box-msg text-left"><b>32. </b>How would you like to improve this course?</p>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <textarea type="text" class="form-control" name="improvement2"></textarea>
                            </div>
                        </div>


                    </div>


                    <p class="mb-0">
                    </p>
                </div>
                <div class="card-footer">
                    <button type="submit" name="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- alert -->


    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>

    <?php
    if (isset($_SESSION['password_incorrect'])) {
        echo "<script>
    $(function() {
      toastr.error('Password is incorrect.','Error')
    });
    </script>";
    } elseif (isset($_SESSION['username_incorrect'])) {
        echo "<script>
    $(function() {
      toastr.error('Username is incorrect.','Error')
    });
    </script>";
    }

    ?>

</body>

</html>