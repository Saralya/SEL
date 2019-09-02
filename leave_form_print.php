<?php
ob_start();
require('fpdf.php');
require('exfpdf.php');
require('easyTable.php');
include('connect.php');

if(isset($_GET['id'])) {
    $id = $_GET['id']; //id
    $from = $_GET['from'];
    $to = $_GET['to'];
    $type = $_GET['type'];
    $reason = $_GET['reason'];
    $sql = "SELECT * FROM employee WHERE `ID`='$id'";
    $res = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($res);
    $fname = $row['First Name'];
    $lname = $row['Last Name'];
    $name = $fname.' '.$lname; //name
    $dep = $row['department_id'];
    $sql = "SELECT * FROM department WHERE `dep_id`='$dep'";
     $res = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($res);
    $reporter = $row['reporter_id'];
    $sql = "SELECT * FROM employee WHERE `ID`='$reporter'";
    $res = mysqli_query($db,$sql);
    $row = mysqli_fetch_assoc($res);
    $first1 = $row['First Name'];
    $second1 = $row['Last Name'];
    $rep_name = $first1.' '.$second1; //reporter name
    $diff = date_diff(date_create($from), date_create($to));
    $a = $diff->days;
    $a = (int) $a;
    $a++; //days
    $date = date('d.m.Y');
    
    date_default_timezone_set('Asia/Dhaka');
    $leave_year = date('Y', time());
    $sql ="SELECT * FROM `leave_types` WHERE emp_id='$id' AND `year`='$leave_year'";
            $result = mysqli_query($db, $sql);
            $row = mysqli_fetch_array($result);
    

//Gets total casual leaves    
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE `EmployeeID`='$id' AND `status`='Approved' AND `type`='Casual' AND `year`='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_casual=mysqli_fetch_array($result);
            $day_casual=$row_casual['Total'];

            //Gets total sick leaves
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Sick' AND `year`='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_sick=mysqli_fetch_array($result);
            $day_sick=$row_sick['Total'];

            //Gets total annual leaves
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Annual' AND `year`='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_annual=mysqli_fetch_array($result);
            $day_annual=$row_annual['Total'];

            //Gets total maternity leaves
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Maternity' AND `year`='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_maternity=mysqli_fetch_array($result);
            $day_maternity=$row_maternity['Total'];

            //Gets total paternity leaves
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Paternity' AND `year`='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_paternity=mysqli_fetch_array($result);
            $day_paternity=$row_paternity['Total']; 

            //Gets total wpl leaves
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Without Pay Leave' AND `year`='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_wpl=mysqli_fetch_array($result);
            $day_wpl=$row_wpl['Total'];
    
            //Gets total official leaves
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Official Tour' AND `year`='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_official=mysqli_fetch_array($result);
            $day_official=$row_official['Total'];

            $existing_casual= $row['casual']-$day_casual; 
            $existing_sick= $row['sick']-$day_sick;
            $existing_annual= $row['annual']-$day_annual;
            $existing_maternity= $row['maternity']-$day_maternity;
            $existing_paternity= $row['paternity']-$day_paternity;
            $existing_wpl= $row['wpl']-$day_wpl;
            $existing_official = $row['official']-$day_official;
    
    $taken1 = '-';
    $taken2 = '-';
    $taken3 = '-';
    $taken4 = '-';
    $taken5 = '-';
    $taken6 = '-';
    $taken7 = '-';
    switch($type) {
        case 'Casual': 
            $taken1 = $a; 
            break;
        case 'Sick': 
            $taken2 = $a; 
            break;
        case 'Annual': 
            $taken3 = $a; 
            break;
        case 'Maternity': 
            $taken4 = $a; 
            break;
         case 'Paternity': 
            $taken5 = $a; 
            break;
         case 'Without Pay Leave': 
            $taken6 = $a; 
            break;
         case 'Official Tour': 
            $taken7 = $a; 
            break;
        
    }
    
    $remaining1 = $existing_casual;
    $remaining2 = $existing_sick;
    $remaining3 = $existing_annual;
    $remaining4 = $existing_maternity;
    $remaining5 = $existing_paternity;
    $remaining6 = $existing_wpl;
    $remaining7 = $existing_official;
    
    switch($type) {
        case 'Casual': 
            $remaining1 = $existing_casual-$a; 
            break;
        case 'Sick': 
            $remaining2 = $existing_sick-$a; 
            break;
        case 'Annual': 
            $remaining3 = $existing_annual-$a; 
            break;
        case 'Maternity': 
            $remaining4 = $existing_maternity-$a; 
            break;
         case 'Paternity': 
            $remaining5 = $existing_paternity-$a; 
            break;
         case 'Without Pay Leave': 
            $remaining6 = $existing_wpl-$a; 
            break;
         case 'Official Tour': 
            $remaining7 = $existing_official-$a; 
            break;
        
    }
    

$pdf=new exFPDF();
$pdf -> AddPage();
$pdf -> SetFont('Arial', 'B', 10);
$pdf -> Cell(0,10, 'System Engineering Limited', 0, 0, 'C');
$pdf -> SetFont('Arial', 'B', 15);
$pdf -> ln(10);
$pdf -> Cell(0,15, 'Leave Application Form', 1, 1, 'C');
$pdf -> ln(15);
$pdf -> SetFont('Arial', '', 10);
$pdf -> multicell(0,10,'I, '.$name.' , ID No '.$id.', under the company System Engineering Limited, reporting to '.$rep_name.' , wish to apply for '.$a.' days of leave from '.$from.' to '.$to.' .',0, 1);
$pdf -> SetFont('Arial', 'B', 10);
$pdf -> Cell(0,10, 'For the following reason(s):', 0, 0);
$pdf -> ln(10);
$pdf -> SetFont('Arial', '', 10);
$pdf -> multicell(0,10,$reason,0,1);
$pdf -> ln(10);



$table=new easyTable($pdf, 5, 'border:1;');
// first row
$table->rowStyle('align:{C}');
$table->easyCell('Leave Requests','colspan:5');
$table->printRow();

// second row
$table->easyCell(' ','valign:T'); 
$table->easyCell('Remaining Allocation','align:C');
$table->easyCell('Applied','align:C');
$table->easyCell('Remaining','align:C');
$table->easyCell('Remarks','align:C');
$table->printRow();

$table->easyCell('Casual');
$table->easyCell($existing_casual,'align:C');
$table->easyCell($taken1,'align:C');
$table->easyCell($remaining1,'align:C');
$table->easyCell('');
$table->printRow();

$table->easyCell('Sick');
$table->easyCell($existing_sick,'align:C');
$table->easyCell($taken2,'align:C');
$table->easyCell($remaining2,'align:C');
$table->easyCell('');
$table->printRow();

$table->easyCell('Annual');
$table->easyCell($existing_annual,'align:C');
$table->easyCell($taken3,'align:C');
$table->easyCell($remaining3,'align:C');
$table->easyCell('');
$table->printRow();

$table->easyCell('Parental');
$table->easyCell($existing_maternity,'align:C');
$table->easyCell($taken4,'align:C');
$table->easyCell($remaining4,'align:C');
$table->easyCell('');
$table->printRow();

$table->easyCell('Alternative');
$table->easyCell($existing_paternity,'align:C');
$table->easyCell($taken5,'align:C');
$table->easyCell($remaining5,'align:C');
$table->easyCell('');
$table->printRow();

$table->easyCell('Without Pay Leave');
$table->easyCell($existing_wpl,'align:C');
$table->easyCell($taken6,'align:C');
$table->easyCell($remaining6,'align:C');
$table->easyCell('');
$table->printRow();

$table->easyCell('Official Tour');
$table->easyCell($existing_official,'align:C');
$table->easyCell($taken7,'align:C');
$table->easyCell($remaining7,'align:C');
$table->easyCell('');
$table->printRow();


$table->endTable(10);

$pdf -> SetFont('Arial', '', 10);
$pdf -> multicell(0,10,'Employee Signature  _______________________________________________      Date-  '.$date,0, 1); 

$pdf -> multicell(0,10,'HR Signature           _______________________________________________      Date-  '.$date,0, 1); 

$pdf -> Output('I','leave_form_'.$id.'.pdf');
}
ob_end_flush();
?>