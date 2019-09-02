<?php
ob_start ();
session_start();
require('fpdf.php');
require('exfpdf.php');
require('easyTable.php');
include('connect.php');
if(isset($_GET['ID'])){
    $id = $_GET['ID'];

    if(($_SESSION['name']!='admin' && $_SESSION['id']!=$id)) {
        header("location:admin.php");
    }

    $personal = $_GET['personal'];
    $job = $_GET['job'];
    $experience = $_GET['experience'];
    $qualification = $_GET['qualification'];
    $training = $_GET['training'];
    $awards = $_GET['awards'];
    $disciplinary = $_GET['disciplinary'];
    $leaves_all = $_GET['leaves_all'];
    $leaves_date = $_GET['leaves_date'];
    $employment = $_GET['employment'];
    $department = $_GET['department'];
    $designation = $_GET['designation'];
    $salary = $_GET['salary'];
    $bonus = $_GET['bonus'];
    $facility = $_GET['facility'];

    $sql = "SELECT * FROM employee WHERE `ID`='$id'";
    $res = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($res);

    $date = date('m.d.y');
    $image = $row['image'];
    if(!$image){
        $image = 'photo/sample.jpg';
    }
    if(!file_exists($image)){
        $image = 'photo/sample.jpg';
    }
    $fname = $row['First Name'];
    $lname = $row['Last Name'];
    $lname = $row['Last Name'];
    $dob = $row['Date of Birth'];
    $email = $row['Email'];
    $gender = $row['Gender'];
    $phone = $row['Cell Phone'];
    $father = $row['father'];
    $mother = $row['mother'];
    $spouse = $row['spouse'];
    $nid = $row['NID'];
    $passport = $row['passport'];
    $dep_id = $row['department_id'];
    $saluation='';
    if($gender=='Male')
        $saluation='Mr.';
    else
        $saluation='Ms.';


    $sql = "SELECT * FROM address WHERE `emp_id`='$id'";
    $res = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($res);

    $village = $row['pre_village'];
    $post_office = $row['pre_post_office'];
    $thana = $row['pre_thana'];
    $district = $row['pre_district'];
    $division = $row['pre_division'];

    $sql = "SELECT * FROM job_status WHERE `emp_id`='$id'";
    $res = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($res);

    $curr_designation = $row['curr_designation'];
    $joining_date = $row['joining_date'];
    $joining_gross = $row['joining_gross'];
    $current_gross = $row['current_gross'];
    $present_working_station = $row['present_working_station'];
    $employee_status = $row['employee_status'];
    $confirmation_status = $row['confirmation_status'];
    $confirmation_date = $row['confirmation_date'];
    $employement_type = $row['employment_type'];
    $employee_separation = $row['employee_separation'];
    $employee_separation_date = $row['employee_separation_date'];
    $pf_deduction = $row['pf_deduction'];
    $gratuity = $row['gratuity'];
    $hos_scheme = $row['hos_schema'];
    $hos_range = $row['hos_range'];
    $salary_account = $row['salary_account'];
    $bank = $row['bank'];
    $corporate_sim= $row['corporate_sim'];
    $income_tax_deduction= $row['income_tax_deduction'];

    $sql = "SELECT * FROM department WHERE `dep_id`='$dep_id'";
    $res = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($res);

    $dep_name = $row['dep_name'];

    $pdf=new exFPDF();
    $pdf -> AddPage();
    $pdf -> SetFont('Arial', 'B', 12);
    $pdf -> Cell(0,10, 'System Engineering Limited', 0, 0, 'C');
    $pdf -> setXY(10,19);
    $pdf -> SetFont('Arial', '', 10);
    $pdf -> Cell(0,5, 'Employee ID- '.$id);
    $pdf -> setXY(-50,16);
    $pdf -> Cell(0,5, 'Date- '.$date);
    $pdf -> Line(10,25,200,25);
    $pdf-> Image($image,160,28,30,30);
    $pdf -> SetFont('Arial', '', 10);
    $pdf -> setXY(10,30);
    $pdf -> Cell(0,5,'Saluation      : '.$saluation);
    $pdf -> setXY(10,35);
    $pdf -> Cell(0,5,'First Name   : '.$fname);
    $pdf -> setXY(10,40);
    $pdf -> Cell(0,5,'Last Name   : '.$lname);
    $pdf -> setXY(10,45);
    $pdf -> Cell(0,5,'Position        : '.$curr_designation);
    $pdf -> setXY(10,50);
    $pdf -> Cell(0,5,'Phone          : '.$phone);
    $pdf -> setXY(80,50);
    $pdf -> Cell(0,5,'Email : '.$email);
    $pdf -> setXY(10,55);
    $pdf -> Cell(0,5,'Department  : '.$dep_name);
    $pdf -> Line(10,60,200,60);
    $y = $pdf-> GetY();
    $y = $y + 8;
    $pdf -> setXY(10,$y);
    if($personal){
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5,'Personal Infromation:');
        $pdf -> SetFont('Arial', '', 10);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Father\'s Name  : '.$father);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Mother\'s Name : '.$mother);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Spouse Name  : '.$spouse);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Date of Birth     : '.$dob);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Sex                   : '.$gender);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Passport No     : '.$passport);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'National ID       : '.$nid);
        $pdf -> setXY(110,68);
        $y = $pdf-> GetY();
        $pdf -> Cell(0,5, 'Residential Address:');
        $pdf -> setXY(110,$y = $y+5);
        $pdf -> Cell(0,5, $village);
        $pdf -> setXY(110,$y = $y+5);
        $pdf -> Cell(0,5, 'Post Office  : '.$post_office);
        $pdf -> setXY(110,$y = $y+5);
        $pdf -> Cell(0,5, 'Thana          : '.$thana);
        $pdf -> setXY(110,$y = $y+5);
        $pdf -> Cell(0,5, 'District         : '.$district);
        $pdf -> setXY(110,$y = $y+5);
        $pdf -> Cell(0,5, 'Division       : '.$division);
        $y = $y+10;
        $pdf -> setXY(10,$y);
        $pdf -> Line(10,$y,200,$y);
        $y = $pdf-> GetY();
        $y = $y + 3;
        $pdf -> setXY(10,$y);
    }

    if($job) {
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Job Status:');
        $pdf -> SetFont('Arial', '', 10);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Current Designation           : '.$curr_designation);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Current Department           : '.$dep_name);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Joining Date                       : '.$joining_date);
        $y1 = $y;
        $y2 = $y1;
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Joining Gross Salary          : '.$joining_gross);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Current Gross Salary         : '.$current_gross);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Present Working Station    : '.$present_working_station);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Employee Status                : '.$employee_status);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Confirmation Status           : '.$confirmation_status);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Confirmation Date              : '.$confirmation_date);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Employment Type              : '.$employement_type);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Employee Separation         : '.$employee_separation);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Employee Separation Date: '.$employee_separation_date);

        $sql = "SELECT * FROM emergency_contact WHERE emp_id=$id";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result);

        $pdf -> setXY(130,$y1 = $y1 - 2.5);
        $pdf -> Cell(0,5,'Emergency Contact:');
        $pdf -> setXY(130,$y1 = $y1+5);
        $pdf -> Cell(0,5,'Name       : '.$row['name']);
        $pdf -> setXY(130,$y1 = $y1+5);
        $pdf -> Cell(0,5,'Relation   : '.$row['relation']);
        $pdf -> setXY(130,$y1 = $y1+5);
        $pdf -> Cell(0,5,'Phone      : '.$row['cell']);
        $y1 =$y2;
        $pdf -> Line(164,$y1,200,$y1);
        $pdf -> Line(200,$y1,200,$y1 = $y1+18.5);
        $pdf -> Line(125,$y1,200,$y1);
        $pdf -> Line(125,$y1 = $y1-18.5,125,$y1 = $y1+18.5);
        $pdf -> Line(125,$y1 = $y1-18.5,130,$y1);

        $pdf -> Line(10,$y = $y+5,200,$y);
        $pdf -> setXY(10,$y = $y+3);
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Others:');
        $pdf -> SetFont('Arial', '', 10);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'PF Deduction                  : '.$pf_deduction);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Gratuity                           : '.$gratuity);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Hospital Scheme             : '.$hos_scheme);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Hospital Scheme Range : '.$hos_range);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Salary Account Number  : '.$salary_account);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Bank Name                     : '.$bank);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Corporate Sim Number   : '.$corporate_sim);
        $pdf -> setXY(10,$y = $y+5);
        $pdf -> Cell(0,5, 'Income Tax Deduction    : '.$income_tax_deduction);
        $y = $y+5;
        $pdf -> setXY(10,$y);
        $pdf -> Line(10,$y,200,$y);
        $y = $pdf-> GetY();
        $y = $y + 3;
        $pdf -> setXY(10,$y);

    }

    if($experience){
        $y = $pdf -> getY();
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Job Experience:');
        $pdf -> SetFont('Arial', '', 10);
        $pdf -> setXY(10,$y = $y+7);

        $sql = "SELECT * FROM job_experience WHERE emp_id=$id";
        $res = mysqli_query($db, $sql);

        $table=new easyTable($pdf, 6, 'border:1;');
        // second row
        $table->easyCell('Previous Employer','valign:T'); 
        $table->easyCell('Designation','align:C');
        $table->easyCell('Job Field','align:C');
        $table->easyCell('Job Experience','align:C');
        $table->easyCell('Address','align:C');
        $table->easyCell('Refference','align:C');
        $table->printRow();

        while($row = mysqli_fetch_array($res)){
            $previous_employer = $row['previous_employer'];
            $desig = $row['designation'];
            $job_field = $row['job_field'];
            $job_experience = $row['job_experience'];
            $address = $row['address'];
            $refference = $row['refference'];

            $table->easyCell($previous_employer, 'align:C');
            $table->easyCell($desig, 'align:C');
            $table->easyCell($job_field, 'align:C');
            $table->easyCell($job_experience, 'align:C');
            $table->easyCell($address, 'align:C');
            $table->easyCell($refference, 'align:C');
            $table->printRow();
        }
        $table->endTable(10);
    }

    if($qualification){
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Education:');

        $pdf -> SetFont('Arial', '', 10);
        $y = $pdf->getY();
        $y=$y+7;
        $pdf->setY($y);
        $table=new easyTable($pdf, 6, 'border:1;');
        // first row 
        $table->easyCell('Degree','align:C');
        $table->easyCell('Field','align:C');
        $table->easyCell('Instition','align:C');
        $table->easyCell('Passing Year','align:C');
        $table->easyCell('Marks','align:C');
        $table->easyCell('Location','align:C');
        $table->printRow();

        $sql = "SELECT * FROM qualification WHERE emp_id=$id ORDER BY year";
        $result = mysqli_query($db, $sql);


        while($row = mysqli_fetch_array($result)){
            $table->easyCell($row['degree'],'align:C');
            $table->easyCell($row['field'],'align:C');
            $table->easyCell($row['institution'],'align:C');
            $table->easyCell($row['year'],'align:C');
            $table->easyCell($row['mark'],'align:C');
            $table->easyCell($row['location'],'align:C');
            $table->printRow();
        }
        $table->endTable(10);
    }

    if($training){
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Training:');

        $pdf -> SetFont('Arial', '', 10);
        $y = $pdf->getY();
        $y=$y+7;
        $pdf->setY($y);
        $table=new easyTable($pdf, 5, 'border:1;');
        $table->easyCell('Title','align:C');
        $table->easyCell('Institution','align:C');
        $table->easyCell('Place','align:C');
        $table->easyCell('Days','align:C');
        $table->easyCell('Year','align:C');
        $table->printRow();

        $sql = "SELECT * FROM training WHERE emp_id = $id";
        $res = mysqli_query($db, $sql);
        while($row = mysqli_fetch_array($res)) {
            $title = $row['title'];
            $institution = $row['institution'];
            $place = $row['place'];
            $days = $row['days'];
            $year = $row['year'];
            $table->easyCell($title,'align:C');
            $table->easyCell($institution,'align:C');
            $table->easyCell($place,'align:C');
            $table->easyCell($days,'align:C');
            $table->easyCell($year,'align:C');
            $table->printRow();
        }
        $table->endTable(10);
    }

    if($awards) {
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Awards:');

        $pdf -> SetFont('Arial', '', 10);
        $y = $pdf->getY();
        $y=$y+7;
        $pdf->setY($y);
        $table=new easyTable($pdf, 2, 'border:1;');
        $table->easyCell('Date','align:C');
        $table->easyCell('Remarks','align:C');
        $table->printRow();

        $sql = "SELECT * FROM awards WHERE emp_id = $id";
        $res = mysqli_query($db, $sql);
        while($row = mysqli_fetch_array($res)) {
            $dates = $row['date'];
            $remarks = $row['remarks'];
            $table->easyCell($dates,'align:C');
            $table->easyCell($remarks,'align:C');
            $table->printRow();
        }
        $table->endTable(10);
    }

    if($disciplinary) {
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Disciplinary:');

        $pdf -> SetFont('Arial', '', 10);
        $y = $pdf->getY();
        $y=$y+7;
        $pdf->setY($y);
        $table=new easyTable($pdf, 3, 'border:1;');
        $table->easyCell('Date','align:C');
        $table->easyCell('Type','align:C');
        $table->easyCell('Remarks','align:C');
        $table->printRow();

        $sql = "SELECT * FROM disciplinary WHERE emp_id = $id";
        $res = mysqli_query($db, $sql);
        while($row = mysqli_fetch_array($res)) {
            $dates = $row['date'];
            $remarks = $row['remarks'];
            $type = $row['type'];
            $table->easyCell($dates,'align:C');
            $table->easyCell($type,'align:C');
            $table->easyCell($remarks,'align:C');
            $table->printRow();
        }
        $table->endTable(10);
    }

    if($leaves_all || $leaves_date) {
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
        if($status == "On Duty")
            $print_date = '';

        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5,'Leave Information:                                                                                      Status: '.$status.' '.$print_date);
        $pdf -> SetFont('Arial', '', 10);
        $y = $pdf->getY();
        $y=$y+7;
        $pdf->setY($y);
        $pdf -> Line(10,$y,200,$y);

        $y = $y + 3;
        $pdf -> setXY(10,$y);
    }

    if($leaves_all) {
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'All Leaves:');

        $pdf -> SetFont('Arial', '', 10);
        $y = $pdf->getY();
        $y=$y+7;
        $pdf->setY($y);

        date_default_timezone_set('Asia/Dhaka');
        $leave_year = date('Y', time());

        $sql ="SELECT * FROM `leave_types` WHERE emp_id='$id' AND `year`='$leave_year'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result);


        //Gets total casual leaves    
        $sql="SELECT SUM(days) AS Total FROM leaves WHERE `EmployeeID`='$id' AND `status`='Approved' AND `type`='Casual' AND year='$leave_year'";
        $result=mysqli_query($db, $sql);
        $row_casual=mysqli_fetch_array($result);
        $day_casual=$row_casual['Total'];

        //Gets total sick leaves
        $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Sick' AND year='$leave_year'";
        $result=mysqli_query($db, $sql);
        $row_sick=mysqli_fetch_array($result);
        $day_sick=$row_sick['Total'];

        //Gets total annual leaves
        $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Annual' AND year='$leave_year'";
        $result=mysqli_query($db, $sql);
        $row_annual=mysqli_fetch_array($result);
        $day_annual=$row_annual['Total'];

        //Gets total maternity leaves
        $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Maternity' AND year='$leave_year'";
        $result=mysqli_query($db, $sql);
        $row_maternity=mysqli_fetch_array($result);
        $day_maternity=$row_maternity['Total'];

        //Gets total paternity leaves
        $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Paternity' AND year='$leave_year'";
        $result=mysqli_query($db, $sql);
        $row_paternity=mysqli_fetch_array($result);
        $day_paternity=$row_paternity['Total']; 

        //Gets total wpl leaves
        $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Without Pay Leave' AND year='$leave_year'";
        $result=mysqli_query($db, $sql);
        $row_wpl=mysqli_fetch_array($result);
        $day_wpl=$row_wpl['Total'];

        //Gets total official leaves
        $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Official Tour' AND year='$leave_year'";
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



        $table=new easyTable($pdf, 4, 'border:1;');
        // second row
        $table->easyCell(' ','valign:T'); 
        $table->easyCell('Total Allocation','align:C');
        $table->easyCell('Taken','align:C');
        $table->easyCell('Remaining','align:C');
        $table->printRow();

        $table->easyCell('Casual','align:C');
        $table->easyCell($row['casual'],'align:C');
        $table->easyCell($day_casual,'align:C');
        $table->easyCell($existing_casual,'align:C');
        $table->printRow();

        $table->easyCell('Sick');
        $table->easyCell($row['sick'],'align:C');
        $table->easyCell($row_sick,'align:C');
        $table->easyCell($existing_sick,'align:C');
        $table->printRow();

        $table->easyCell('Annual');
        $table->easyCell($row['annual'],'align:C');
        $table->easyCell($row_annual,'align:C');
        $table->easyCell($existing_annual,'align:C');
        $table->printRow();

        $table->easyCell('Parental');
        $table->easyCell($row['maternity'],'align:C');
        $table->easyCell($row_maternity,'align:C');
        $table->easyCell($existing_maternity,'align:C');
        $table->printRow();

        $table->easyCell('Alternative');
        $table->easyCell($row['paternity'],'align:C');
        $table->easyCell($row_paternity,'align:C');
        $table->easyCell($existing_paternity,'align:C');
        $table->printRow();

        $table->easyCell('Without Pay Leave');
        $table->easyCell($row['wpl'],'align:C');
        $table->easyCell($row_wpl,'align:C');
        $table->easyCell($existing_wpl,'align:C');
        $table->printRow();

        $table->easyCell('Official Tour');
        $table->easyCell($row['official'],'align:C');
        $table->easyCell($row_official,'align:C');
        $table->easyCell($existing_official,'align:C');
        $table->printRow();
        $table->endTable(5);
    }

    if($leaves_date) {
        $y = $pdf -> getY();
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Date to Date:');
        $pdf -> SetFont('Arial', '', 10);
        $pdf -> setXY(10,$y = $y+7);

        $table=new easyTable($pdf, 6, 'border:1;');
        // second row
        $table->easyCell('Entrier','valign:T'); 
        $table->easyCell('Approver','align:C');
        $table->easyCell('From','align:C');
        $table->easyCell('To','align:C');
        $table->easyCell('Days','align:C');
        $table->easyCell('Type','align:C');
        $table->printRow();

        $sql = "SELECT * FROM leaves WHERE EmployeeID=$id AND status='Approved'";
        $res = mysqli_query($db, $sql);
        while($row = mysqli_fetch_array($res)) {
            $entrier_id = $row['entrier_id'];
            $approver_id = $row['approver_id'];
            $from = $row['From Date'];
            $to_ = $row['To Date'];
            $days = $row['days'];
            $type = $row['Type'];
            $sql1 = "SELECT * FROM employee WHERE ID=$entrier_id";
            $res1 = mysqli_query($db, $sql1);
            $row1 = mysqli_fetch_array($res1);
            $entrier_name = $row1['First Name'].' '.$row1['Last Name'];
            $sql2 = "SELECT * FROM employee WHERE ID=$approver_id";
            $res2 = mysqli_query($db, $sql2);
            $row2 = mysqli_fetch_array($res2);
            $approver_name = $row2['First Name'].' '.$row2['Last Name'];

            $table->easyCell($entrier_name, 'align:C');
            $table->easyCell($approver_name, 'align:C');
            $table->easyCell($from, 'align:C');
            $table->easyCell($to_, 'align:C');
            $table->easyCell($days, 'align:C');
            $table->easyCell($type, 'align:C');
            $table->printRow();
        }
        $table->endTable(10);
    }

    if($employment || $department || $designation || $salary || $bonus || $facility){
        $y = $pdf->GetY();
        $y=$y-2;
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'History:');
        $y = $y + 10;
        $pdf -> setXY(10,$y);

        $y = $pdf->GetY();
        $y=$y-2;
        $pdf -> Line(10,$y,200,$y);
    }

    if($employment) {
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Employment:');

        $pdf -> SetFont('Arial', '', 10);
        $y = $pdf->getY();
        $y=$y+7;
        $pdf->setY($y);

        $table=new easyTable($pdf, 3, 'border:1;');
        // first row 
        $table->easyCell('Start Date','align:C');
        $table->easyCell('End Date','align:C');
        $table->easyCell('Employee Type','align:C');
        $table->printRow();

        $sql = "SELECT * FROM history_employment WHERE emp_id=$id ORDER BY date";
        $result=mysqli_query($db,$sql);
        $result1 = mysqli_query($db,$sql);
        $row1 = mysqli_fetch_array($result1);

        while($row = mysqli_fetch_array($result)){
            $row1 = mysqli_fetch_array($result1);
            $table->easyCell($row['date'],'align:C');
            if($row1['date']==null){
                $end_date = '-';
            } else {
                $end_date = $row1['date'];
            }
            $table->easyCell($end_date,'align:C');
            $table->easyCell($row['employment_type'],'align:C');
            $table->printRow();
        }
        $table ->endTable(5);  
    }

    if($department) {
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Department:');
        $pdf -> SetFont('Arial', '', 10);
        $y = $pdf->getY();
        $y=$y+7;
        $pdf->setY($y);

        $table=new easyTable($pdf, 3, 'border:1;');
        // first row 
        $table->easyCell('Start Date','align:C');
        $table->easyCell('End Date','align:C');
        $table->easyCell('Department','align:C');
        $table->printRow();

        $sql = "SELECT * FROM history_department WHERE emp_id=$id ORDER BY date";
        $result=mysqli_query($db,$sql);
        $result1 = mysqli_query($db,$sql);
        $row1 = mysqli_fetch_array($result1);

        while($row = mysqli_fetch_array($result)){
            $row1 = mysqli_fetch_array($result1);
            $table->easyCell($row['date'],'align:C');
            if($row1['date']==null){
                $end_date = '-';
            } else {
                $end_date = $row1['date'];
            }
            $table->easyCell($end_date,'align:C');
            $dep_id = $row['tos'];
            $sql2= "SELECT * FROM department WHERE dep_id=$dep_id";
            $result2 = mysqli_query($db, $sql2);
            $row2 = mysqli_fetch_array($result2);
            $dep_name = $row2['dep_name'];
            $table->easyCell($dep_name,'align:C');
            $table->printRow();
        }
        $table ->endTable(5);
    }

    if($designation) {
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Position:');
        $pdf -> SetFont('Arial', '', 10);
        $y = $pdf->getY();
        $y=$y+7;
        $pdf->setY($y);

        $table=new easyTable($pdf, 3, 'border:1;');
        // first row 
        $table->easyCell('Start Date','align:C');
        $table->easyCell('End Date','align:C');
        $table->easyCell('Position','align:C');
        $table->printRow();

        $sql = "SELECT * FROM history_designation WHERE emp_id=$id ORDER BY date";
        $result=mysqli_query($db,$sql);
        $result1 = mysqli_query($db,$sql);
        $row1 = mysqli_fetch_array($result1);

        while($row = mysqli_fetch_array($result)){
            $row1 = mysqli_fetch_array($result1);
            $table->easyCell($row['date'],'align:C');
            if($row1['date']==null){
                $end_date = '-';
            } else {
                $end_date = $row1['date'];
            }
            $table->easyCell($end_date,'align:C');
            $table->easyCell($row['to_dep'],'align:C');
            $table->printRow();
        }
        $table ->endTable(5);
    }

    if($salary) {
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Salary:');
        $pdf -> SetFont('Arial', '', 10);
        $y = $pdf->getY();
        $y=$y+7;
        $pdf->setY($y);


        $table=new easyTable($pdf, 3, 'border:1;');
        // first row 
        $table->easyCell('Start Date','align:C');
        $table->easyCell('End Date','align:C');
        $table->easyCell('Salary','align:C');
        $table->printRow();

        $sql = "SELECT * FROM history_salary WHERE emp_id=$id ORDER BY date";
        $result=mysqli_query($db,$sql);
        $result1 = mysqli_query($db,$sql);
        $row1 = mysqli_fetch_array($result1);

        while($row = mysqli_fetch_array($result)){
            $row1 = mysqli_fetch_array($result1);
            $table->easyCell($row['date'],'align:C');
            if($row1['date']==null){
                $end_date = '-';
            } else {
                $end_date = $row1['date'];
            }
            $table->easyCell($end_date,'align:C');
            $table->easyCell($row['amount'],'align:C');
            $table->printRow();
        }
        $table ->endTable(5);
    }

    if($bonus) {
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Bonus:');
        $pdf -> SetFont('Arial', '', 10);
        $y = $pdf->getY();
        $y=$y+7;
        $pdf->setY($y);


        $table=new easyTable($pdf, 3, 'border:1;');
        // first row 
        $table->easyCell('Start Date','align:C');
        $table->easyCell('End Date','align:C');
        $table->easyCell('Bonus','align:C');
        $table->printRow();

        $sql = "SELECT * FROM history_bonus WHERE emp_id=$id ORDER BY date";
        $result=mysqli_query($db,$sql);
        $result1 = mysqli_query($db,$sql);
        $row1 = mysqli_fetch_array($result1);

        while($row = mysqli_fetch_array($result)){
            $row1 = mysqli_fetch_array($result1);
            $table->easyCell($row['date'],'align:C');
            if($row1['date']==null){
                $end_date = '-';
            } else {
                $end_date = $row1['date'];
            }
            $table->easyCell($end_date,'align:C');
            $table->easyCell($row['amount'],'align:C');
            $table->printRow();
        }
        $table ->endTable(5);
    }

    if($facility) {
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(0,5, 'Facility:');
        $pdf -> SetFont('Arial', '', 10);
        $y = $pdf->getY();
        $y=$y+7;
        $pdf->setY($y);


        $table=new easyTable($pdf, 4, 'border:1;');
        // first row 
        $table->easyCell('Start Date','align:C');
        $table->easyCell('End Date','align:C');
        $table->easyCell('Reference','align:C');
        $table->easyCell('Remarks','align:C');
        $table->printRow();

        $sql = "SELECT * FROM history_facility WHERE emp_id=$id ORDER BY date";
        $result=mysqli_query($db,$sql);
        $result1 = mysqli_query($db,$sql);
        $row1 = mysqli_fetch_array($result1);

        while($row = mysqli_fetch_array($result)){
            $row1 = mysqli_fetch_array($result1);
            $table->easyCell($row['date'],'align:C');
            if($row1['date']==null){
                $end_date = '-';
            } else {
                $end_date = $row1['date'];
            }
            $table->easyCell($end_date,'align:C');
            $table->easyCell($row['ref'],'align:C');
            $table->easyCell($row['remarks'],'align:C');
            $table->printRow();
        }
        $table ->endTable(5);
    }

    $pdf ->output('I','employee_profile_'.$id.'.pdf');
}
ob_end_flush(); 
?>