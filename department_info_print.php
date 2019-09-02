<?php
ob_start ();
session_start();
require('fpdf.php');
require('exfpdf.php');
require('easyTable.php');
include('connect.php');

if(!isset($_GET['submit']))
    header("location:admin.php");

$dep_id = $_GET['id'];

if($_SESSION['name']!='admin') {
    header("location:admin.php");
}
$radiot = $_GET['radiot'];
if($radiot=='B'){
    $join_date = $_GET['join_date'];
} else
    $join_date = '';

$sql5 = "SELECT * FROM department WHERE dep_id = $dep_id";
$result5 = mysqli_query($db, $sql5);
$row5 = mysqli_fetch_array($result5);
$dep = $row5['dep_name'];
$date = date('m.d.y');

$pdf=new exFPDF();
$pdf -> AddPage('L');
$pdf -> SetFont('Arial', 'B', 12);
$pdf -> Cell(0,10, 'System Engineering Limited', 0, 0, 'C');

$sql3 = "SELECT * FROM department WHERE dep_name = '$dep'";
$result3 = mysqli_query($db, $sql3);
$row3 = mysqli_fetch_array($result3);
$head_id = $row3['head_id'];
$reporter_id = $row3['reporter_id'];

$sql4 = "SELECT * FROM employee WHERE ID = $head_id";
$result4 = mysqli_query($db, $sql4);
$row4 = mysqli_fetch_array($result4);
$head_name = $row4['First Name'].' '.$row4['Last Name'];

$sql4 = "SELECT * FROM employee WHERE ID = $reporter_id";
$result4 = mysqli_query($db, $sql4);
$row4 = mysqli_fetch_array($result4);
$reporter_name = $row4['First Name'].' '.$row4['Last Name'];

$pdf -> SetFont('Arial', '', 12);

$pdf -> setXY(10,25);
$pdf -> Cell(0,5,'Department Name : '.$dep);
$pdf -> setXY(-50,25);
$pdf -> Cell(0,5, 'Date- '.$date);
$pdf -> setXY(10,30);
$pdf -> Cell(0,5,'Head    : '.$head_name);
$pdf -> setXY(10,35);
$pdf -> Cell(0,5,'Reporter : '.$reporter_name);

$pdf -> setXY(10,45);

$pdf -> SetFont('Arial', 'B', 12);


$table=new easyTable($pdf, 7, 'border:1;');
// second row
$table->easyCell('Emp ID','align:C'); 
$table->easyCell('Image','align:C'); 
$table->easyCell('Name','align:C');
$table->easyCell('Designation','align:C');
$table->easyCell('Contact No','align:C');
$table->easyCell('Employment Type','align:C');
$table->easyCell('Status','align:C');
$table->printRow();
$pdf -> SetFont('Arial', '', 10);

$sql = "SELECT * FROM `department` WHERE dep_name LIKE '$dep%'";
$result = mysqli_query($db, $sql);
while($row = mysqli_fetch_array($result)){
    $dep_id = $row['dep_id'];
    $sql1 = "SELECT * FROM `employee` WHERE department_id = $dep_id";
    $result1 = mysqli_query($db, $sql1);
    while($row1 = mysqli_fetch_array($result1)){
        $id = $row1['ID'];
        $name = $row1['First Name'].' '.$row1['Last Name'];
        
        $sql2 = "SELECT * FROM `job_status` WHERE emp_id = $id";
        $result2 = mysqli_query($db, $sql2);
        $row2 = mysqli_fetch_array($result2);
        $designation = $row2['curr_designation'];
        $cell_phone = $row1['Cell Phone'];
        $employment_type = $row2['employment_type'];
        $separation = $row2['employee_separation_date'];
        $joining_date = $row2['joining_date'];
        if($joining_date<$join_date)
            continue;
        $image = 'photo/'.$id.'.jpg';
        if(!$image){
            $image = 'photo/sample.jpg';
        }
        if(!file_exists($image)){
            $image = 'photo/sample.jpg';
        }
        $sql3 = "SELECT * FROM employee WHERE ID=$id";
        $result3 = mysqli_query($db, $sql3);
        $row3 = mysqli_fetch_array($result3);
        $blood = $row3['Blood Group'];
        
        $sql = "SELECT MAX(LeaveID) AS serial FROM leaves WHERE EmployeeID='$id'";
        $res = mysqli_query($db,$sql);
        $latest=mysqli_fetch_array($res);
        $leave_id=$latest['serial'];
        $sql = "SELECT * FROM leaves WHERE LeaveID='$leave_id'";
        $res = mysqli_query($db,$sql);

        $data = mysqli_fetch_array($res);
        $from = $data['From Date'];
        $to_ = $data['To Date'];
        $print_date = '('.$from.' to '.$to_.')';
        $status = '';
        if ($data['status']=='Approved'&&$data['joined']=='No'&&date_create($data['From Date'])<=date_create($date))
            $status = "On Leave";
        else 
            $status = "On Duty";
        if($employment_type=="Regular" || $separation=='')
            $separation = '';
        else
            $separation = '  ('.$separation.')';
        
        if($status == "On Duty")
            $print_date = '';
        
        $table->easyCell($id,'align:C'); 
        $table->easyCell('', 'img:'.$image.', w15, h15; align:C');
        $table->easyCell($name.' ('.$blood.')','align:C');
        $table->easyCell($designation,'align:C');
        $table->easyCell($cell_phone,'align:C');
        $table->easyCell($employment_type.' '.$separation,'align:C');
        $table->easyCell($status.' '.$print_date,'align:C');
        $table->printRow();
    }
}
$table->endTable(10);

$pdf -> output('I',"$dep.pdf");

?>