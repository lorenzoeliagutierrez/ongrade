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
      <div class="card-body">
        <div class="container">
          <div class="row">
            <div class="col">
              <p class="login-box-msg">You are about to take this <b>Student-to-Teacher Evaluation</b>. We must keep in mind that "Evaluations" are a key opportunity to gather feedback for improvements and for decision-making purposes. <b>WE ARE ENCOURAGING EVERYONE TO PLEASE TAKE TIME TO RATE ALL YOUR TEACHERS.</b></p>
              <p class="login-box-msg">This evaluation will only be available on start_time up until end_time, so make sure to finish this evaulation on this given set of time. Before proceeding, note that this evaluation will only finish once you've completed evaluating all of your course professors.</p>
              <p class="login-box-msg"><b>Your honesty and sincerity in participating in this activity is highly appreciated.  Rest assured that all the gathered data will be treated with utmost confidentiality and will serve the sole purpose of evaluating the faculty members from the College Department.</b></p>
            </div>
          </div>
        </div>


        <p class="mb-0">
        </p>
      </div>
      <div class="card-footer">
          <a class="btn btn-danger">Log Out</a>
          <a href="teacher.eval.php" class="btn btn-primary">Proceed</a>
      </div>
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
</body>

</html>