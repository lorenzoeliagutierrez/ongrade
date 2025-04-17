<?php
require('./../fpdf/fpdf.php');
include '../../includes/session.php';
$class_code = $_GET['class_code'];
$section = $_GET['section'];
$class_id = $_GET['class_id'];

class PDF extends FPDF
{

    // Page header

    function Header()
    {
        include '../../includes/conn.php';
        $class_code = $_GET['class_code'];
        $class_id = $_GET['class_id'];
        $section = $_GET['section'];
        
        if (isset($_GET['semester']) && isset($_GET['acadyear'])) {
            $acadyear = $_GET['acadyear'];
            $semester = $_GET['semester'];
        } else {
            $acadyear = $_SESSION['active_acadyear'];
            $semester = $_SESSION['active_semester'];
        }
        // Logo(x axis, y axis, height, width)
        $this->Image('../../docs/assets/img/logo.png', 27, 3, 19, 19);
        // font(font type,style,font size)
        $this->SetFont('Times', 'B', 28);
        $this->SetTextColor(255, 0, 0);
        // Dummy cell
        $this->Cell(50);
        // //cell(width,height,text,border,end line,[align])
        $this->Cell(110, 5, 'Saint Francis of Assisi College', 0, 0, 'C');
        // Line break
        $this->Ln(9);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 10);
        // dummy cell

        // //cell(width,height,text,border,end line,[align])
        // $test = utf8_decode("Piñas");
        $this->Cell(0, 3, '96 Bayanan, City of Bacoor, Cavite', 0, 0, 'C');
        // Line break
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 12);
        // //cell(width,height,text,border,end line,[align])
        $this->Cell(0, 4, 'COLLEGE DEPARTMENT', 0, 0, 'C');
        // Line break
        $this->Ln(8);
        $this->SetFont('Arial', 'B', 14);
        // //cell(width,height,text,border,end line,[align])
        $this->Cell(0, 6, 'REPORTS OF GRADES', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 4, $semester . ' ' . $acadyear, 0, 1, 'C');

        $this->Ln(3);
        $class_info = mysqli_query($conn, "SELECT *
                FROM tbl_enrolled_subjects 
                LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id
                LEFT JOIN tbl_schoolyears ON tbl_schoolyears.stud_id = tbl_enrolled_subjects.stud_id
                LEFT JOIN tbl_schedules ON tbl_schedules.class_id = tbl_enrolled_subjects.class_id
                WHERE tbl_schedules.class_id = '$class_id'
                AND tbl_schedules.section = '$section' 
                AND tbl_schoolyears.ay_id = '$acadyear'
                AND tbl_schoolyears.sem_id = '$semester'
                AND tbl_schoolyears.remark = 'Approved'");
        
        $class_size = mysqli_num_rows($class_info);
        $row = mysqli_fetch_array($class_info);

        $this->SetFont('Arial', '', '11');
        $this->Cell(25, 5, 'Course Code:', 0, 0);

        $fontsize3 = 11;
        $tempFontSize3 = $fontsize3;
        $cellwidth3 = 23;
        while ($this->GetStringWidth($class_code) > $cellwidth3) {
            $this->SetFontSize($tempFontSize3 -= 0.1);
        }
        $this->Cell(23, 5, $class_code, 'B', 0, 'C');
        $this->SetFont('Arial', '', '11');
        $this->Cell(23, 5, 'Course Title:', 0, 0);
        $fontsize = 11;
        $tempFontSize = $fontsize;
        $cellwidth = 77;
        while ($this->GetStringWidth($row['subj_desc']) > $cellwidth) {
            $this->SetFontSize($tempFontSize -= 0.1);
        }
        $this->Cell(77, 5, $row['subj_desc'], 'B', 0, 'C');
        $this->SetFont('Arial', '', '11');
        $this->Cell(25, 5, 'No. of Units:', 0, 0);
        $this->Cell(22, 5, $row['unit_total'], 'B', 1, 'C');

        $this->Cell(51, 5, 'Schedule (Time/Day/Room):', 0, 0);
        $this->Cell(102, 5, $row['time'] . ' / ' . $row['day'] . ' / ' . $row['room'], 'B', 0, 'C');
        $this->Cell(20, 5, 'Class Size:', 0, 0);
        $this->Cell(22, 5, $class_size, 'B', 1, 'C');

        $this->Image('../../docs/assets/img/rog.PNG', 10, 57, 197, 40);


        $this->Rect(10, 96.7, 8.87, 5);
        $this->Rect(18.87, 96.7, 53.3, 5);
        $this->Rect(72.17, 96.7, 23.43, 5);
        $this->Rect(95.6, 96.7, 10.43, 5);
        $this->Rect(106.03, 96.7, 9.63, 5);
        $this->Rect(115.66, 96.7, 10.45, 5);
        $this->Rect(126.11, 96.7, 9.35, 5);
        $this->Rect(135.46, 96.7, 11.75, 5);
        $this->Rect(147.21, 96.7, 14.9, 5);
        $this->Rect(162.11, 96.7, 44.55, 5);

        $this->Rect(10, 101.7, 8.87, 5);
        $this->Rect(18.87, 101.7, 53.3, 5);
        $this->Rect(72.17, 101.7, 23.43, 5);
        $this->Rect(95.6, 101.7, 10.43, 5);
        $this->Rect(106.03, 101.7, 9.63, 5);
        $this->Rect(115.66, 101.7, 10.45, 5);
        $this->Rect(126.11, 101.7, 9.35, 5);
        $this->Rect(135.46, 101.7, 11.75, 5);
        $this->Rect(147.21, 101.7, 14.9, 5);
        $this->Rect(162.11, 101.7, 44.55, 5);

        $this->Rect(10, 106.7, 8.87, 5);
        $this->Rect(18.87, 106.7, 53.3, 5);
        $this->Rect(72.17, 106.7, 23.43, 5);
        $this->Rect(95.6, 106.7, 10.43, 5);
        $this->Rect(106.03, 106.7, 9.63, 5);
        $this->Rect(115.66, 106.7, 10.45, 5);
        $this->Rect(126.11, 106.7, 9.35, 5);
        $this->Rect(135.46, 106.7, 11.75, 5);
        $this->Rect(147.21, 106.7, 14.9, 5);
        $this->Rect(162.11, 106.7, 44.55, 5);

        $this->Rect(10, 111.7, 8.87, 5);
        $this->Rect(18.87, 111.7, 53.3, 5);
        $this->Rect(72.17, 111.7, 23.43, 5);
        $this->Rect(95.6, 111.7, 10.43, 5);
        $this->Rect(106.03, 111.7, 9.63, 5);
        $this->Rect(115.66, 111.7, 10.45, 5);
        $this->Rect(126.11, 111.7, 9.35, 5);
        $this->Rect(135.46, 111.7, 11.75, 5);
        $this->Rect(147.21, 111.7, 14.9, 5);
        $this->Rect(162.11, 111.7, 44.55, 5);

        $this->Rect(10, 116.7, 8.87, 5);
        $this->Rect(18.87, 116.7, 53.3, 5);
        $this->Rect(72.17, 116.7, 23.43, 5);
        $this->Rect(95.6, 116.7, 10.43, 5);
        $this->Rect(106.03, 116.7, 9.63, 5);
        $this->Rect(115.66, 116.7, 10.45, 5);
        $this->Rect(126.11, 116.7, 9.35, 5);
        $this->Rect(135.46, 116.7, 11.75, 5);
        $this->Rect(147.21, 116.7, 14.9, 5);
        $this->Rect(162.11, 116.7, 44.55, 5);

        $this->Rect(10, 121.7, 8.87, 5);
        $this->Rect(18.87, 121.7, 53.3, 5);
        $this->Rect(72.17, 121.7, 23.43, 5);
        $this->Rect(95.6, 121.7, 10.43, 5);
        $this->Rect(106.03, 121.7, 9.63, 5);
        $this->Rect(115.66, 121.7, 10.45, 5);
        $this->Rect(126.11, 121.7, 9.35, 5);
        $this->Rect(135.46, 121.7, 11.75, 5);
        $this->Rect(147.21, 121.7, 14.9, 5);
        $this->Rect(162.11, 121.7, 44.55, 5);
        //77777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777
        $this->Rect(10, 126.7, 8.87, 5);
        $this->Rect(18.87, 126.7, 53.3, 5);
        $this->Rect(72.17, 126.7, 23.43, 5);
        $this->Rect(95.6, 126.7, 10.43, 5);
        $this->Rect(106.03, 126.7, 9.63, 5);
        $this->Rect(115.66, 126.7, 10.45, 5);
        $this->Rect(126.11, 126.7, 9.35, 5);
        $this->Rect(135.46, 126.7, 11.75, 5);
        $this->Rect(147.21, 126.7, 14.9, 5);
        $this->Rect(162.11, 126.7, 44.55, 5);

        $this->Rect(10, 131.7, 8.87, 5);
        $this->Rect(18.87, 131.7, 53.3, 5);
        $this->Rect(72.17, 131.7, 23.43, 5);
        $this->Rect(95.6, 131.7, 10.43, 5);
        $this->Rect(106.03, 131.7, 9.63, 5);
        $this->Rect(115.66, 131.7, 10.45, 5);
        $this->Rect(126.11, 131.7, 9.35, 5);
        $this->Rect(135.46, 131.7, 11.75, 5);
        $this->Rect(147.21, 131.7, 14.9, 5);
        $this->Rect(162.11, 131.7, 44.55, 5);

        $this->Rect(10, 136.7, 8.87, 5);
        $this->Rect(18.87, 136.7, 53.3, 5);
        $this->Rect(72.17, 136.7, 23.43, 5);
        $this->Rect(95.6, 136.7, 10.43, 5);
        $this->Rect(106.03, 136.7, 9.63, 5);
        $this->Rect(115.66, 136.7, 10.45, 5);
        $this->Rect(126.11, 136.7, 9.35, 5);
        $this->Rect(135.46, 136.7, 11.75, 5);
        $this->Rect(147.21, 136.7, 14.9, 5);
        $this->Rect(162.11, 136.7, 44.55, 5);

        $this->Rect(10, 141.7, 8.87, 5);
        $this->Rect(18.87, 141.7, 53.3, 5);
        $this->Rect(72.17, 141.7, 23.43, 5);
        $this->Rect(95.6, 141.7, 10.43, 5);
        $this->Rect(106.03, 141.7, 9.63, 5);
        $this->Rect(115.66, 141.7, 10.45, 5);
        $this->Rect(126.11, 141.7, 9.35, 5);
        $this->Rect(135.46, 141.7, 11.75, 5);
        $this->Rect(147.21, 141.7, 14.9, 5);
        $this->Rect(162.11, 141.7, 44.55, 5);

        $this->Rect(10, 146.7, 8.87, 5);
        $this->Rect(18.87, 146.7, 53.3, 5);
        $this->Rect(72.17, 146.7, 23.43, 5);
        $this->Rect(95.6, 146.7, 10.43, 5);
        $this->Rect(106.03, 146.7, 9.63, 5);
        $this->Rect(115.66, 146.7, 10.45, 5);
        $this->Rect(126.11, 146.7, 9.35, 5);
        $this->Rect(135.46, 146.7, 11.75, 5);
        $this->Rect(147.21, 146.7, 14.9, 5);
        $this->Rect(162.11, 146.7, 44.55, 5);

        $this->Rect(10, 151.7, 8.87, 5);
        $this->Rect(18.87, 151.7, 53.3, 5);
        $this->Rect(72.17, 151.7, 23.43, 5);
        $this->Rect(95.6, 151.7, 10.43, 5);
        $this->Rect(106.03, 151.7, 9.63, 5);
        $this->Rect(115.66, 151.7, 10.45, 5);
        $this->Rect(126.11, 151.7, 9.35, 5);
        $this->Rect(135.46, 151.7, 11.75, 5);
        $this->Rect(147.21, 151.7, 14.9, 5);
        $this->Rect(162.11, 151.7, 44.55, 5);

        $this->Rect(10, 156.7, 8.87, 5);
        $this->Rect(18.87, 156.7, 53.3, 5);
        $this->Rect(72.17, 156.7, 23.43, 5);
        $this->Rect(95.6, 156.7, 10.43, 5);
        $this->Rect(106.03, 156.7, 9.63, 5);
        $this->Rect(115.66, 156.7, 10.45, 5);
        $this->Rect(126.11, 156.7, 9.35, 5);
        $this->Rect(135.46, 156.7, 11.75, 5);
        $this->Rect(147.21, 156.7, 14.9, 5);
        $this->Rect(162.11, 156.7, 44.55, 5);

        $this->Rect(10, 161.7, 8.87, 5);
        $this->Rect(18.87, 161.7, 53.3, 5);
        $this->Rect(72.17, 161.7, 23.43, 5);
        $this->Rect(95.6, 161.7, 10.43, 5);
        $this->Rect(106.03, 161.7, 9.63, 5);
        $this->Rect(115.66, 161.7, 10.45, 5);
        $this->Rect(126.11, 161.7, 9.35, 5);
        $this->Rect(135.46, 161.7, 11.75, 5);
        $this->Rect(147.21, 161.7, 14.9, 5);
        $this->Rect(162.11, 161.7, 44.55, 5);

        $this->Rect(10, 166.7, 8.87, 5);
        $this->Rect(18.87, 166.7, 53.3, 5);
        $this->Rect(72.17, 166.7, 23.43, 5);
        $this->Rect(95.6, 166.7, 10.43, 5);
        $this->Rect(106.03, 166.7, 9.63, 5);
        $this->Rect(115.66, 166.7, 10.45, 5);
        $this->Rect(126.11, 166.7, 9.35, 5);
        $this->Rect(135.46, 166.7, 11.75, 5);
        $this->Rect(147.21, 166.7, 14.9, 5);
        $this->Rect(162.11, 166.7, 44.55, 5);

        $this->Rect(10, 171.7, 8.87, 5);
        $this->Rect(18.87, 171.7, 53.3, 5);
        $this->Rect(72.17, 171.7, 23.43, 5);
        $this->Rect(95.6, 171.7, 10.43, 5);
        $this->Rect(106.03, 171.7, 9.63, 5);
        $this->Rect(115.66, 171.7, 10.45, 5);
        $this->Rect(126.11, 171.7, 9.35, 5);
        $this->Rect(135.46, 171.7, 11.75, 5);
        $this->Rect(147.21, 171.7, 14.9, 5);
        $this->Rect(162.11, 171.7, 44.55, 5);

        $this->Rect(10, 176.7, 8.87, 5);
        $this->Rect(18.87, 176.7, 53.3, 5);
        $this->Rect(72.17, 176.7, 23.43, 5);
        $this->Rect(95.6, 176.7, 10.43, 5);
        $this->Rect(106.03, 176.7, 9.63, 5);
        $this->Rect(115.66, 176.7, 10.45, 5);
        $this->Rect(126.11, 176.7, 9.35, 5);
        $this->Rect(135.46, 176.7, 11.75, 5);
        $this->Rect(147.21, 176.7, 14.9, 5);
        $this->Rect(162.11, 176.7, 44.55, 5);

        $this->Rect(10, 181.7, 8.87, 5);
        $this->Rect(18.87, 181.7, 53.3, 5);
        $this->Rect(72.17, 181.7, 23.43, 5);
        $this->Rect(95.6, 181.7, 10.43, 5);
        $this->Rect(106.03, 181.7, 9.63, 5);
        $this->Rect(115.66, 181.7, 10.45, 5);
        $this->Rect(126.11, 181.7, 9.35, 5);
        $this->Rect(135.46, 181.7, 11.75, 5);
        $this->Rect(147.21, 181.7, 14.9, 5);
        $this->Rect(162.11, 181.7, 44.55, 5);

        $this->Rect(10, 186.7, 8.87, 5);
        $this->Rect(18.87, 186.7, 53.3, 5);
        $this->Rect(72.17, 186.7, 23.43, 5);
        $this->Rect(95.6, 186.7, 10.43, 5);
        $this->Rect(106.03, 186.7, 9.63, 5);
        $this->Rect(115.66, 186.7, 10.45, 5);
        $this->Rect(126.11, 186.7, 9.35, 5);
        $this->Rect(135.46, 186.7, 11.75, 5);
        $this->Rect(147.21, 186.7, 14.9, 5);
        $this->Rect(162.11, 186.7, 44.55, 5);

        $this->Rect(10, 191.7, 8.87, 5);
        $this->Rect(18.87, 191.7, 53.3, 5);
        $this->Rect(72.17, 191.7, 23.43, 5);
        $this->Rect(95.6, 191.7, 10.43, 5);
        $this->Rect(106.03, 191.7, 9.63, 5);
        $this->Rect(115.66, 191.7, 10.45, 5);
        $this->Rect(126.11, 191.7, 9.35, 5);
        $this->Rect(135.46, 191.7, 11.75, 5);
        $this->Rect(147.21, 191.7, 14.9, 5);
        $this->Rect(162.11, 191.7, 44.55, 5);

        $this->Rect(10, 196.7, 8.87, 5);
        $this->Rect(18.87, 196.7, 53.3, 5);
        $this->Rect(72.17, 196.7, 23.43, 5);
        $this->Rect(95.6, 196.7, 10.43, 5);
        $this->Rect(106.03, 196.7, 9.63, 5);
        $this->Rect(115.66, 196.7, 10.45, 5);
        $this->Rect(126.11, 196.7, 9.35, 5);
        $this->Rect(135.46, 196.7, 11.75, 5);
        $this->Rect(147.21, 196.7, 14.9, 5);
        $this->Rect(162.11, 196.7, 44.55, 5);

        $this->Rect(10, 201.7, 8.87, 5);
        $this->Rect(18.87, 201.7, 53.3, 5);
        $this->Rect(72.17, 201.7, 23.43, 5);
        $this->Rect(95.6, 201.7, 10.43, 5);
        $this->Rect(106.03, 201.7, 9.63, 5);
        $this->Rect(115.66, 201.7, 10.45, 5);
        $this->Rect(126.11, 201.7, 9.35, 5);
        $this->Rect(135.46, 201.7, 11.75, 5);
        $this->Rect(147.21, 201.7, 14.9, 5);
        $this->Rect(162.11, 201.7, 44.55, 5);

        $this->Rect(10, 206.7, 8.87, 5);
        $this->Rect(18.87, 206.7, 53.3, 5);
        $this->Rect(72.17, 206.7, 23.43, 5);
        $this->Rect(95.6, 206.7, 10.43, 5);
        $this->Rect(106.03, 206.7, 9.63, 5);
        $this->Rect(115.66, 206.7, 10.45, 5);
        $this->Rect(126.11, 206.7, 9.35, 5);
        $this->Rect(135.46, 206.7, 11.75, 5);
        $this->Rect(147.21, 206.7, 14.9, 5);
        $this->Rect(162.11, 206.7, 44.55, 5);

        $this->Rect(10, 211.7, 8.87, 5);
        $this->Rect(18.87, 211.7, 53.3, 5);
        $this->Rect(72.17, 211.7, 23.43, 5);
        $this->Rect(95.6, 211.7, 10.43, 5);
        $this->Rect(106.03, 211.7, 9.63, 5);
        $this->Rect(115.66, 211.7, 10.45, 5);
        $this->Rect(126.11, 211.7, 9.35, 5);
        $this->Rect(135.46, 211.7, 11.75, 5);
        $this->Rect(147.21, 211.7, 14.9, 5);
        $this->Rect(162.11, 211.7, 44.55, 5);

        $this->Rect(10, 216.7, 8.87, 5);
        $this->Rect(18.87, 216.7, 53.3, 5);
        $this->Rect(72.17, 216.7, 23.43, 5);
        $this->Rect(95.6, 216.7, 10.43, 5);
        $this->Rect(106.03, 216.7, 9.63, 5);
        $this->Rect(115.66, 216.7, 10.45, 5);
        $this->Rect(126.11, 216.7, 9.35, 5);
        $this->Rect(135.46, 216.7, 11.75, 5);
        $this->Rect(147.21, 216.7, 14.9, 5);
        $this->Rect(162.11, 216.7, 44.55, 5);

        $this->Rect(10, 221.7, 8.87, 5);
        $this->Rect(18.87, 221.7, 53.3, 5);
        $this->Rect(72.17, 221.7, 23.43, 5);
        $this->Rect(95.6, 221.7, 10.43, 5);
        $this->Rect(106.03, 221.7, 9.63, 5);
        $this->Rect(115.66, 221.7, 10.45, 5);
        $this->Rect(126.11, 221.7, 9.35, 5);
        $this->Rect(135.46, 221.7, 11.75, 5);
        $this->Rect(147.21, 221.7, 14.9, 5);
        $this->Rect(162.11, 221.7, 44.55, 5);

        $this->Rect(10, 226.7, 8.87, 5);
        $this->Rect(18.87, 226.7, 53.3, 5);
        $this->Rect(72.17, 226.7, 23.43, 5);
        $this->Rect(95.6, 226.7, 10.43, 5);
        $this->Rect(106.03, 226.7, 9.63, 5);
        $this->Rect(115.66, 226.7, 10.45, 5);
        $this->Rect(126.11, 226.7, 9.35, 5);
        $this->Rect(135.46, 226.7, 11.75, 5);
        $this->Rect(147.21, 226.7, 14.9, 5);
        $this->Rect(162.11, 226.7, 44.55, 5);

        $this->Rect(10, 231.7, 8.87, 5);
        $this->Rect(18.87, 231.7, 53.3, 5);
        $this->Rect(72.17, 231.7, 23.43, 5);
        $this->Rect(95.6, 231.7, 10.43, 5);
        $this->Rect(106.03, 231.7, 9.63, 5);
        $this->Rect(115.66, 231.7, 10.45, 5);
        $this->Rect(126.11, 231.7, 9.35, 5);
        $this->Rect(135.46, 231.7, 11.75, 5);
        $this->Rect(147.21, 231.7, 14.9, 5);
        $this->Rect(162.11, 231.7, 44.55, 5);

        $this->Rect(10, 236.7, 8.87, 5);
        $this->Rect(18.87, 236.7, 53.3, 5);
        $this->Rect(72.17, 236.7, 23.43, 5);
        $this->Rect(95.6, 236.7, 10.43, 5);
        $this->Rect(106.03, 236.7, 9.63, 5);
        $this->Rect(115.66, 236.7, 10.45, 5);
        $this->Rect(126.11, 236.7, 9.35, 5);
        $this->Rect(135.46, 236.7, 11.75, 5);
        $this->Rect(147.21, 236.7, 14.9, 5);
        $this->Rect(162.11, 236.7, 44.55, 5);
    }


    // Page footer
    function Footer()
    {
        include '../../includes/conn.php';
        
        // Position at 1.5 cm from bottom
        $this->Rect(10, 241.7, 196.72, 70);

        $this->SetXY(10, 255);
        $this->SetFontSize(8);
        $this->Cell(20, 5, 'Prepared by:', 0, 0);
        $this->SetFont('Arial', 'B', '10');
        $this->Cell(50, 5, $_SESSION['name'], 'B', 0, 'C'); //=====================PROFESSOR NAME=================
        $this->Cell(5, 5, '', 0, 0);
        $this->Cell(30, 5, date('M d, Y'), 'B', 1, 'C');

        $this->SetFont('Arial', '', '8');
        $this->Cell(20, 5, '', 0, 0);
        $this->Cell(50, 5, 'Professor / Instructor', 0, 0, 'C');
        $this->Cell(5, 5, '', 0, 0);
        $this->Cell(30, 5, 'Date', 0, 1, 'C');

        $this->Cell(120, 5, '', 0, 0);
        $this->Cell(50, 5, 'Verified by:', 0, 0);

        $this->Ln(10);

        $this->Cell(20, 5, 'Checked by:', 0, 0);
        $this->SetFont('Arial', 'B', '10');
        $this->Cell(50, 5, '', 'B', 0, 'C'); //=================ACADEMIC HEAD=================
        $this->SetFont('Arial', '', '8');
        $this->Cell(5, 5, '', 0, 0);
        $this->Cell(30, 5, '', 'B', 0);
        $this->Cell(15, 5, '', 0, 0);
        $this->SetFont('Arial', 'B', '10');
        $this->Cell(30, 5, ' Rebecca Dela Cruz-Vicente, LPT', 'B', 0, 'C');
        $this->Cell(20, 5, '', 'B', 1); //=========================REGISTRAR NAME====================
        $this->SetFont('Arial', '', '8');
        $this->Cell(20, 5, '', 0, 0);
        $this->Cell(50, 5, 'Program Director', 0, 0, 'C');
        $this->Cell(5, 5, '', 0, 0);
        $this->Cell(30, 5, 'Date', 0, 0, 'C');
        $this->Cell(15, 5, '', 0, 0);
        $this->Cell(50, 5, 'Registrar', 0, 1);

        $this->Ln(10);

        $this->Cell(20, 5, 'Received by:', 0, 0);
        $this->SetFont('Arial', 'B', '10');
        $this->Cell(50, 5, 'Sheryl Sajo', 'B', 0, 'C'); //=================RECORD VERIFIER=================
        $this->SetFont('Arial', '', '8');
        $this->Cell(5, 5, '', 0, 0);
        $this->Cell(30, 5, '', 'B', 0);
        $this->Cell(5, 5, '', 0, 1);


        $this->Cell(20, 4, '', 0, 0);
        $this->Cell(50, 4, 'Record Verifier', 0, 0, 'C');
        $this->Cell(5, 4, '', 0, 0);
        $this->Cell(30, 4, 'Date', 0, 0, 'C');
        $this->Cell(5, 4, '', 0, 1);

        $this->Cell(20, 4, '', 0, 0);
        $this->SetFont('Arial', 'I', '7');
        $this->Cell(50, 4, '(Signature over printed name)', 0, 0, 'C');
        $this->Cell(5, 5, '', 0, 0);
        $this->Cell(30, 4, '', 0, 0);
        $this->Cell(15, 4, '', 0, 0);
        $this->Cell(0, 4, 'Note: PLEASE READ ALL THE INSTRUCTIONS CAREFULLY AT', 0, 1);
        $this->Cell(120, 4, '', 0, 0);
        $this->Cell(0, 4, 'THE BACK BEFORE ACCOMPLISHING THIS FORM.', 0, 0, 'C');

        $this->SetY(-45);
        // Select Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Print current and total page numbers
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'Legal');
$pdf->AliasNbPages();

//left top right
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();
// $pdf->SetAutoPageBreak(true,112);
if (isset($_GET['semester']) && isset($_GET['acadyear'])) {
    $acadyear = $_GET['acadyear'];
    $semester = $_GET['semester'];
  
  } else {
    $acadyear = $_SESSION['active_acadyear'];
    $semester = $_SESSION['active_semester'];
    
  }

$pdf->SetFont('Arial', '', '11');
$pdf->SetXY(10, 91.7);
$pdf->SetFont('Arial', '', '11');
$pdf->SetXY(10, 91.7);
$que = mysqli_query($conn, "SELECT *, CONCAT(tbl_students.lastname, ', ', tbl_students.firstname, ' ', tbl_students.middlename)  as fullname
                FROM tbl_enrolled_subjects 
                LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id
                LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
                LEFT JOIN tbl_schoolyears ON tbl_schoolyears.stud_id = tbl_students.stud_id
                LEFT JOIN tbl_schedules ON tbl_schedules.class_id = tbl_enrolled_subjects.class_id
                LEFT JOIN tbl_courses ON tbl_courses.course_id = tbl_schoolyears.course_id
                LEFT JOIN tbl_year_levels ON tbl_year_levels.year_id = tbl_schoolyears.year_id
                WHERE tbl_schedules.class_id = '$class_id'
                AND tbl_schedules.section = '$section' 
                AND tbl_schoolyears.ay_id = '$acadyear'
                AND tbl_schoolyears.sem_id = '$semester'
                AND tbl_schoolyears.remark = 'Approved'
                ORDER BY fullname");

$y = $pdf->Gety();
$xy = 5;
$x = 1;

while ($row = mysqli_fetch_array($que)) {
        // $pdf ->SetXY(10,$y+$xy);
        $fullname = strtoupper($row['fullname']);
        # code...
        $pdf->Cell(8.98, 5, $x, 1, 0);
        $fontsize = 9;
        $tempFontSize = $fontsize;
        $cellwidth = 52;
        while ($pdf->GetStringWidth($fullname) > $cellwidth) {
            $pdf->SetFontSize($tempFontSize -= 0.1);
        }
        $pdf->Cell(53.2, 5, utf8_decode($fullname), 1, 0);
        $pdf->SetFont('Arial', '', '9');
        $fontsize1 = 10;
        $tempFontSize2 = $fontsize1;
        $cellwidth1 = 22;
        while ($pdf->GetStringWidth($row['course_abv'] . '-' . $row['year_abv']) > $cellwidth1) {
            $pdf->SetFontSize($tempFontSize2 -= 0.1);
        }
        $pdf->Cell(23.4, 5, $row['course_abv'] . '-' . $row['year_abv'], 1, 0);
        $pdf->SetFont('Arial', '', '9');
        $pdf->Cell(10.5, 5, $row['prelim'], 1, 0, 'C');
        $pdf->Cell(9.5, 5, $row['midterm'], 1, 0, 'C');
        $pdf->Cell(10.5, 5, $row['finalterm'], 1, 0, 'C');
        $pdf->Cell(9.4, 5, $row['absences'], 1, 0, 'C');
        $pdf->Cell(11.7, 5, $row['ofgrade'], 1, 0, 'C');

        if ($row['remarks'] == 'Failed' || $row['remarks'] == 'INC') {
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Cell(14.9, 5, $row['numgrade'], 1, 0, 'C');
            
            if (empty($row['finalterm']) || empty($row['midterm']) || empty($row['prelim'])) {
                $pdf->Cell(44.6, 5, 'INC-A', 1, 1, 'C');
            } else {
                $pdf->Cell(44.6, 5, $row['remarks'], 1, 1, 'C');
            }
            $pdf->SetTextColor(0, 0, 0);
        } else {
            $pdf->Cell(14.9, 5, $row['numgrade'], 1, 0, 'C');
            if ($row['tuition_status'] == 'Unpaid') {
                $pdf->SetTextColor(255, 0, 0);
                $pdf->Cell(44.6, 5, 'INC-T', 1, 1, 'C');
                $pdf->SetTextColor(0, 0, 0);
            } else {
                $pdf->Cell(44.6, 5, $row['remarks'], 1, 1, 'C');
            }
        }


        $xy += 5;
        $x += 1;
        if ($x == '31') {
            # code...
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', '9');
            $pdf->SetXY(10, 91.7);
        } else if ($x == '61') {
            # code...
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', '9');
            $pdf->SetXY(10, 91.7);
        }
    
}
$pdf->SetFont('Arial', 'B', '12');
$pdf->Cell(200, 5, '*********sfac****************************Nothing Follows ' . ($x - 1) . ' Students****************************sfac**********', 0, 1, 'C');




$pdf->Output();
