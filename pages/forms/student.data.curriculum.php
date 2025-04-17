<?php
require ('../fpdf/fpdf.php');
include '../../includes/session.php';

if (($_SESSION['role'] == 'Registrar' || $_SESSION['role'] == 'Enrollment Staff') && isset($_GET['stud_id'])) {
    
    $stud_id = $_GET['stud_id'];
    
} else {
        $stud_id = $_SESSION['id'];
}

//get invoices data
$query = mysqli_query($conn,"SELECT *,CONCAT(tbl_students.lastname, ', ', tbl_students.firstname, ' ', tbl_students.middlename)  as fullname 
   FROM tbl_students
   LEFT JOIN tbl_schoolyears ON tbl_schoolyears.stud_id = tbl_students.stud_id
   LEFT JOIN tbl_courses ON tbl_schoolyears.course_id = tbl_courses.course_id
   LEFT JOIN tbl_genders ON tbl_genders.gender_id = tbl_students.gender_id
   WHERE tbl_schoolyears.stud_id = '$stud_id' ORDER BY year_id DESC, sem_id DESC LIMIT 1") or die (mysqli_error($conn)); 
   $row = mysqli_fetch_array($query);
   
   
   
 




class PDF extends FPDF
{

// Page header

}

$pdf = new PDF('P','mm','Legal');
//left top right
$pdf->SetRightMargin(10);
$pdf->SetAutoPageBreak(true, 8);
$pdf ->AddPage();

    // // Logo(x axis, y axis, height, width)
    // $pdf->Image('../../assets/img/logo.png',50,5,15,15);
    // text color
    $pdf->SetTextColor(255,0,0);
    // font(font type,style,font size)
    $pdf->SetFont('Arial','B',17);
    // Dummy cell
    $pdf->Cell(45);
    // //cell(width,height,text,border,end line,[align])
    $pdf->Cell(110,3,'Saint Francis of Assisi College',0,0,'C');
    // Line break
    $pdf->Ln(4);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9,'C');
    // dummy cell
    $pdf->Cell(50);
    // //cell(width,height,text,border,end line,[align])
    $pdf->Cell(90,3,'96 Bayanan, City of Bacoor, Cavite',0,0,'C');
    // Line break
    $pdf->Ln(3);
    $pdf->SetFont('Arial','B',9,'C');
    // dummy cell
    $pdf->Cell(50);
    // //cell(width,height,text,border,end line,[align])
    $pdf->Cell(90,4,'FOUR-YEAR CURRICULUM',0,0,'C');
    // Line break
    $pdf->Ln(4);
    $pdf->SetFont('Arial','B',9,'C');
    // dummy cell
    $pdf->Cell(50);
    // //cell(width,height,text,border,end line,[align])
    $pdf->Cell(90,3,'FOR',0,0,'C');
    // Line break
    $pdf->Ln(4);
    $pdf->SetFont('Arial','B',9,'C');
    // dummy cell
    $pdf->Cell(50);
    // //cell(width,height,text,border,end line,[align])
    $pdf->Cell(90,4,strtoupper($row['course']),0,1,'C');

    // Line break

    $pdf->SetFont('Arial','',9,'C');
    // dummy cell
    $pdf->Cell(50);
    // //cell(width,height,text,border,end line,[align])
    
      // eto now
   $select_eayid = mysqli_query($conn,"SELECT eay_id, COUNT(eay_id) as CU FROM tbl_enrolled_subjects
    LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id
    WHERE stud_id = '$row[stud_id]'
    GROUP BY eay_id
    ORDER BY CU DESC
    LIMIT 1");
    $id = mysqli_fetch_array($select_eayid);
    $select_eay = mysqli_query($conn,"SELECT * FROM tbl_effective_acadyear WHERE eay_id = '$id[eay_id]'");
    $eay = mysqli_fetch_array($select_eay);
   
   $pdf->Cell(90,4,'Effective Academic Year '.$eay['eay'],0,1,'C');
    
    // eto dati
    // $pdf->Cell(90,4,'(Effective Academic Year 2018-2019)',0,1,'C');
     // Line break
    $pdf->Ln(1);
   



//cell(width,height,text,border,end line,[align])
//student name
$pdf ->Cell(15 ,5,'Name:',0,0); 
$pdf->SetFont('Arial','B',9);
$pdf ->Cell(115 ,5,utf8_decode($row['fullname']),'B',0); //end of line


//student no
$pdf->SetFont('Arial','',9);
$pdf ->Cell(25 ,5,'Student No:',0,0);
$pdf->SetFont('Arial','B','9.5');
$pdf ->Cell(30 ,5,$row['stud_no'],'B',0); //end of line

//dummy cells
$pdf ->Cell(20 ,5,'',0,1);
$pdf ->Cell(20 ,5,'',0,0);

$pdf->SetFont('Arial','B','9.5');
$pdf ->Cell(20 ,7,'CODE',0,0);
$pdf ->Cell(90 ,7,'Description',0,0,'C');
$pdf ->Cell(34 ,7,'UNITS',0,0,'C');
$pdf ->Cell(60 ,7,'Pre-Requisites',0,0);

// UNITS
$pdf ->Cell(132 ,5,'',0,0);
$pdf ->Cell(10 ,5,'LEC',0,0);
$pdf ->Cell(10 ,5,'LAB',0,0);
$pdf ->Cell(10 ,5,'TOTAL',0,1);

$TN = 0;



/////////////////////////////////////////////////////startt/////////////////////////////////////////////

$year_sem = mysqli_query($conn,"SELECT * FROM tbl_year_levels, tbl_semesters");
while ($row3 = mysqli_fetch_array($year_sem)) {

   $sy=mysqli_query($conn,"SELECT * from tbl_schoolyears
   left join tbl_year_levels on tbl_schoolyears.year_id=tbl_year_levels.year_id 
   Left join tbl_courses ON tbl_courses.course_id = tbl_schoolyears.course_id
   where stud_id='$stud_id' and year_level='$row3[year_level]' and sem_id='$row3[semester]' and remark = 'Approved' ")or die(mysqli_error($conn));
   $syrow=mysqli_fetch_array($sy);
   if (mysqli_num_rows($sy) >= 1) 
   {

      $pdf ->Cell(10 ,5,'',0,0);
      $pdf ->Cell(45 ,5,$syrow['course_abv'].' - '.$syrow['year_level'].', '.$syrow['sem_id'],0,1);
      $pdf->SetFont('Arial','','9');

            $squery = mysqli_query($conn, "SELECT *
            FROM tbl_enrolled_subjects
            LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
            LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id WHERE tbl_students.stud_id = '$stud_id'  AND semester = '$syrow[sem_id]' and acad_year = '$syrow[ay_id]' AND tbl_subjects_new.course_id = '$syrow[course_id]' AND tbl_subjects_new.course_id = '$syrow[course_id]' ")or die(mysqli_error($conn));
            
               if (mysqli_num_rows($squery) >= 1) 
               {
                  $total_units = 0;
                     while($row2 = mysqli_fetch_array($squery)) {
                        $pdf ->Cell(5 ,4,'',0,0);

                        if ($_SESSION['role'] == "Student" && $syrow['accounting_status'] == "Disabled") {
                           $pdf ->Cell(10 ,4,'','B',0);
                        } else {
                           $pdf ->Cell(10 ,4,$row2['numgrade'],'B',0);
                        }
                        $pdf ->Cell(30 ,4,$row2['subj_code'],0,0);
                        $pdf ->Cell(90 ,4,$row2['subj_desc'],0,0);
                        $pdf ->Cell(10 ,4,$row2['unit_lec'],0,0);
                        $pdf ->Cell(10 ,4,$row2['unit_lab'],0,0);
                        $pdf ->Cell(10 ,4,$row2['unit_total'],0,0);
                        $pdf ->Cell(20 ,4,$row2['prereq'],0,1);
                        
                        if (is_numeric($row2['unit_total'])) {
                            $total_units = $total_units + $row2['unit_total'];
                        } else {
                            $value = $row2['unit_total'];
                            $total_units = $total_units + $value[1];
                        }

                        
                     }

                     $pdf ->Cell(20 ,5,'',0,0);
                     $pdf->SetFont('Arial','','10');
                     $pdf ->Cell(102 ,5,'',0,0);
                     $pdf ->Cell(32 ,6,'TOTAL',0,0);
                     $pdf->SetFont('Arial','B','10');
                     $pdf ->Cell(10 ,6,$total_units,0,0);
                     $pdf ->Cell(180 ,6,'',0,1);
                     
$TN = $TN + $total_units;

                  }

      

   }
}

$pdf ->Cell(20 ,5,'',0,1);

$pdf->SetFont('Arial','B','10');
$pdf ->Cell(95 ,4,'',0,0);
$pdf ->Cell(34 ,4,'TOTAL NUMBER OF UNITS',0,0,'C');
$pdf ->Cell(16 ,4,'',0,0);
$pdf ->Cell(9 ,4,'',0,0);
$pdf ->Cell(10 ,4,$TN,'',1,0);


$pdf->SetFont('Arial','I','8');
$pdf ->Cell(95 ,4,'',0,0);
$pdf ->Cell(34 ,4,'(Including 6 units of NSTP)',0,0,'C');
$pdf ->Cell(16 ,4,'',0,0);
$pdf ->Cell(9 ,4,'',0,0);



$pdf ->Output();
?>










