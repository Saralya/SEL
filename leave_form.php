<?php 
session_start();
if(!$_SESSION['name']){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<html>
    <head>
        <title>Leaves Form</title>
        <?php include "html/bootstrap.html" ?>
        <meta charset="utf-8">
        <script>
            function showUser(str) {
                if (str == "") {
                    document.getElementById("search").innerHTML = "";
                    return;
                } else { 
                    xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("search").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET","check_employee.php?q="+str,true);
                    xmlhttp.send();
                }
            }
            function ValidateEndDate() {
                var objFromDate = document.getElementById("from_date").value;
                var objToDate = document.getElementById("to_date").value;
                if(objToDate){

                    if(objFromDate > objToDate)
                    {
                        alert("Invalid Date Range!!");
                        document.getElementById("submit").disabled=true;
                        return false;
                    }
                }
                document.getElementById("submit").disabled=false; 
            }
        </script>
    </head>
    <body><?php include "html/navbar.php" ?>
        <div class="row row-offcanvas row-offcanvas-left">

            <div class="container">


                <br><h3 style="color:#00BFFF">Job Application Form</h3><br>  
                <div class="row">
                    <div class="col-sm-6">

 

                        <form action="" method="post">
                            <div class="form-group">
                                <?php 
    if($_SESSION['name']=='admin')
    {
        echo 'Employee ID: <input type="text" name="id" placeholder="Existing Employee" onkeyup="showUser(this.value)" required class="form-control" style="width:250px></div>';
    }   
        else
        {

            echo 'Employee ID: <input disabled="disabled" type="text" name="id" value="'.$_SESSION['id'].'" class="form-control" style="width:250px">';


        }
                                ?>
                            </div>
                            <div class="form-group">From: <input id="from_date" type="date" name="from_date" class="form-control" style="width:300px" onchange="ValidateEndDate()" required></div>
                            <div class="form-group">To: <input id="to_date" type="date" name="to_date"  class="form-control" style="width:300px" onchange="ValidateEndDate()" required></div>
                            <div class="form-group">Type: <select name="type"  class="form-control" style="width:500px" required="required">

                                <option value="">------</option>
                                <option value="Casual">Casual</option>
                                <option value="Sick">Sick</option>
                                <option value="Annual">Annual</option>
                                <option value="Maternity">Parental</option>
                                <option value="Paternity">Alternative</option>
                                <option value="Without Pay Leave">Without Pay Leave</option>
                                <option value="Official Tour">Official Tour</option>
                                </select></div>
                            <div class="form-group">Reason: <textarea type="text" class="form-control" style="width:500px" name="reason" required></textarea></div>

                            <input id="submit" type="submit" name="submit" value="Submit" class="btn btn-info">
                        </form>


                    </div>
                    <div class="col-sm-6">
                        <div id="search">
                            <?php


                            if(isset($_POST['submit'])){
                                date_default_timezone_set('Asia/Dhaka');
                                $date = date('m/d/Y', time());
                                $a_date = date('Y-m-d', time());
                                $entrier=$_SESSION['id'];



                                if($_SESSION['name']!='admin')
                                {
                                    $emp=$_SESSION['id'];
                                }
                                else
                                {
                                    $emp = $_POST['id'];
                                }

                                $ref = "REF-"; 
                                $ref .= date("Ymd-his-", time());
                                $ref .= rand(10,99);
                                $ref .= "-".$_SESSION['id'];
                                $ref .= "-".$emp;

                                $reason = mysqli_real_escape_string($db, $_POST['reason']);
                                $to_date = $_POST['to_date']; 
                                $from_date = $_POST['from_date'];
                                $diff = date_diff(date_create($from_date), date_create($to_date));
                                $a = $diff->days;
                                $a = (int) $a;
                                $a++;
                                $comp=date_create($from_date);
                                $date=date_create($date);

                                $emp_sql="SELECT * FROM `employee` WHERE ID='$emp'";
                                $employee_res = mysqli_query($db, $emp_sql);
                                if($employee_res -> num_rows===0)
                                {
                                    echo '<div class="alert alert-danger" align="center">
                            <strong>Warning!</strong> Employee Does not Exist!!!!
                            </div>';

                                }
                                else {
                                    //if($comp<$date)
                                    if(0)
                                    {
                                        echo '<div class="alert alert-danger" align="center">
                                <strong>Warning!</strong> Invalid Date!!!!
                                </div>';   
                                    }

                                    else
                                    {

                                        $sql="SELECT * FROM leaves WHERE EmployeeID='$emp' AND joined='No' AND (status='Approved' OR status='Pending')";
                                        $result_1 =mysqli_query($db, $sql);
                                        if($result_1->num_rows !== 0)
                                        {
                                            echo '<div class="alert alert-danger" align="center">
                                    <strong>Warning!</strong> You have already taken a leave!!!!
                                    </div>';
                                        }
                                        else{
                                            if(isset($_POST['id']))
                                            {
                                                $emp = $_POST['id'];
                                            }
                                            else
                                            {
                                                $emp = $_SESSION['id'];
                                            }

                                            date_default_timezone_set('Asia/Dhaka');
                                            $leave_year = date('Y', time());
                                            
                                            $type = mysqli_real_escape_string($db, $_POST['type']);
                                            
                                            if($type=='Maternity') $type_2='Parental';
                                            else if($type=='Paternity') $type_2='Alternative';
                                            else $type_2=$type;
                                            $sql="SELECT * FROM `leave_types` WHERE emp_id = '$emp' AND `year`='$leave_year'";
                                            $result_1 = mysqli_query ($db, $sql);
                                            $row = mysqli_fetch_array($result_1);

                                            //Gets total casual leaves    
                                            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Casual' AND year='$leave_year'";
                                            $result=mysqli_query($db, $sql);
                                            $row_casual=mysqli_fetch_array($result);
                                            $day_casual=$row_casual['Total'];
                                            //echo $day_casual;

                                            //Gets total sick leaves
                                            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Sick' AND year='$leave_year'";
                                            $result=mysqli_query($db, $sql);
                                            $row_sick=mysqli_fetch_array($result);
                                            $day_sick=$row_sick['Total'];

                                            //Gets total annual leaves
                                            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Annual' AND year='$leave_year'";
                                            $result=mysqli_query($db, $sql);
                                            $row_annual=mysqli_fetch_array($result);
                                            $day_annual=$row_annual['Total'];

                                            //Gets total maternity leaves
                                            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Maternity' AND year='$leave_year'";
                                            $result=mysqli_query($db, $sql);
                                            $row_maternity=mysqli_fetch_array($result);
                                            $day_maternity=$row_maternity['Total'];

                                            //Gets total paternity leaves
                                            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Paternity' AND year='$leave_year'";
                                            $result=mysqli_query($db, $sql);
                                            $row_paternity=mysqli_fetch_array($result);
                                            $day_paternity=$row_paternity['Total']; 

                                            //Gets total wpl leaves
                                            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Without Pay Leave' AND year='$leave_year'";
                                            $result=mysqli_query($db, $sql);
                                            $row_wpl=mysqli_fetch_array($result);
                                            $day_wpl=$row_wpl['Total'];

                                            $existing_casual= $row['casual']-$day_casual; 
                                            $existing_sick= $row['sick']-$day_sick;
                                            $existing_annual= $row['annual']-$day_annual;
                                            $existing_maternity= $row['maternity']-$day_maternity;
                                            $existing_paternity= $row['paternity']-$day_paternity;
                                            $existing_wpl= $row['wpl']-$day_wpl;
                                            
                                          
                                            
                                            if($type=="Casual")
                                            {

                                                $existing_casual= $existing_casual-$a;
                                            }
                                            if($type=="Sick")
                                            {

                                                $existing_sick= $existing_sick-$a;   
                                            }
                                            if($type=="Annual")
                                            {

                                                $existing_annual= $existing_annual-$a;   
                                            }
                                            if($type=="Maternity")
                                            {

                                                $existing_maternity= $existing_maternity-$a;   
                                            }
                                            if($type=="Paternity")
                                            {

                                                $existing_paternity= $existing_paternity-$a;
                                                echo "hellp";
                                            }    
                                            if($type=="Without Pay Leave")
                                            {

                                                $existing_wpl= $existing_wpl-$a;   
                                            }

                                           if($existing_sick<0||$existing_casual<0||$existing_wpl<0||$existing_maternity<0||$existing_paternity<0||$existing_annual<0)
                                            {
                                                echo '<div class="alert alert-danger" align="center">
                                        <strong>Warning!</strong> You Do not Have enough Leaves!!<br>Request Cannot Be Submitted!! Please Check Your Leave Information!!
                                        </div>';
                                    
                                                
                                            }
                                            else
                                            {
                                                if ($result_1->num_rows !== 0)
                                                {

                                                    $query1= "INSERT INTO `leaves`(`EmployeeID`,`apply_date`,`entrier_id`, `From Date`, `To Date`, `Type`, `Reason`, `days`,`ref`,`year`) VALUES ('$emp','$a_date','$entrier','$from_date','$to_date','$type','$reason', '$a','$ref','$leave_year')";
                                                    $query2 ="SELECT department.reporting_mail,department.reporting_mail_2 FROM `department` JOIN `employee` ON department.dep_id=employee.department_id WHERE employee.ID ='$emp'";
                                                    $result = mysqli_query($db, $query2);
                                                    $reporting_mail=mysqli_fetch_array($result);




                                                    if(!mysqli_query($db, $query1))
                                                    {
                                                        die('Error!! '.mysqli_error($db));
                                                    }
                                                    else 
                                                    {



                                                        //echo $reporting_mail['reporting_mail'];           
                                                        $emailTo = $reporting_mail['reporting_mail'];
                                                        $emailTo_2 = $reporting_mail['reporting_mail_2'];

                                                        echo '<div class="alert alert-success" align="center">
                                                Request Submitted Successfully!
                                                </div>';
                                                        $emp_details = mysqli_fetch_array($employee_res);
                                                        $dep_id=$emp_details['department_id'];
                                                        $emp_email=$emp_details['Email'];
                                                        $sql_dep="SELECT * FROM department WHERE dep_id='$dep_id'";
                                                        $res_dep=mysqli_query($db,$sql_dep);
                                                        $dep_name=mysqli_fetch_array($res_dep);

                                                        $msg="<h3>Leave Request</h3><p><big>Hello,<br><br>".$emp_details['First Name']." ".$emp_details['Last Name']."<br> ID: <b>".$emp."</b> <br>Department: <i>".$dep_name['dep_name']."</i>
                                                <br>Phone: ".$emp_details['Cell Phone']."
                                                <br><br>Requested Leave From <font color='#668cff'>".date_format(date_create($from_date),"M d, Y")."</font> To <font color='#668cff'>".date_format(date_create($to_date),"M d, Y")."</font>
                                                <br>Type: ".$type_2."
                                                <br>Application Date: ".date_format(date_create($a_date),"M d, Y")."</big></p><p><a href='http://selhrd.com'>
                                                <button>Click Here to Accept/Reject</button>
                                                </a></p>" ;

                                                        $msg_2="<h3>Leave Request</h3><p><big>Hello ".$emp_details['First Name']." ".$emp_details['Last Name'].",<br> ID: <b>".$emp."</b> <br>Department: <i>".$dep_name['dep_name']."</i>
                                                <br>Phone: ".$emp_details['Cell Phone']."
                                                <br><br>Requested Leave From <font color='#668cff'>".date_format(date_create($from_date),"M d, Y")."</font> To <font color='#668cff'>".date_format(date_create($to_date),"M d, Y")."</font>
                                                <br>Type: ".$type_2."
                                                <br>Application Date: ".date_format(date_create($a_date),"M d, Y")."<br><br>Here is your application.....</big>" ;



                                                    }
                            ?>



                            <?php



                                                    ob_start();
                                                    require('fpdf.php');
                                                    require('exfpdf.php');
                                                    require('easyTable.php');
                                                    //include('connect.php');

                                                    if(isset($_POST['submit'])) {
                                                        $id = $emp; //id
                                                        $from = $from_date;
                                                        $to = $to_date;
                                                        $type = $type;
                                                        $reason = $reason;
                                                        $sql = "SELECT * FROM employee WHERE `ID`='$id'";
                                                        $res = mysqli_query($db, $sql);
                                                        $row = mysqli_fetch_assoc($res);
                                                        $fname = $row['First Name'];
                                                        $lname = $row['Last Name'];
                                                        $email = $row['Email'];
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
                                                        $pdf -> multicell(0,10,'I, '.$name.' , ID No '.$id.', under the company System Engineering Limited, reporting to '.$rep_name.' , wish to apply for '.$a.' days of leave from '.$from.' to '.$to.' (Reference: '.$ref.')',0, 1);
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


                                                        $attachment= $pdf -> Output('leave_form.pdf','S');
                                                        //$attachment = chunk_split(base64_encode($attachment));


                                                        require_once('PHPMailer/PHPMailerAutoload.php');
                                                        $mail = new PHPMailer;
                                                        //$mail->SMTPDebug = 2;
                                                        $mail->isSMTP();
                                                        $mail->Host='sg3plcpnl0194.prod.sin3.secureserver.net';
                                                        $mail->Port=465;
                                                        $mail->SMTPAuth=true;
                                                        $mail->SMTPSecure='ssl';

                                                        $mail->Username='sel@selhrd.com';
                                                        $mail->Password='pglV4^P^7eZn';

                                                        $mail->SetFrom('sel@selhrd.com','SEL-HRD');
                                                        $mail->AddAddress($email);
                                                        $mail->AddReplyTo('noreply@selhrd.com');
                                                        $mail->isHTML(true);
                                                        $mail->Subject='Leave Application';
                                                        $mail->Body=$msg_2;
                                                        $mail->AddStringAttachment($attachment, 'leave_form.pdf');




                                                        if(!$mail->send())
                                                        {
                                                            echo "Mailer Error: " . $mail->ErrorInfo;
                                                            echo '<div class="alert alert-danger" align="center">
                                                        Mail Sending Failed to You!
                                                        </div>';
                                                        }
                                                        else
                                                        {
                                                            echo '<div class="alert alert-success" align="center">
                                                        Mail Sent to You as Attachment!
                                                        </div>';

                                                        }


                                                        require_once('PHPMailer/PHPMailerAutoload.php');
                                                        $mail = new PHPMailer;
                                                        //$mail->SMTPDebug = 2;
                                                        $mail->isSMTP();
                                                        $mail->Host='sg3plcpnl0194.prod.sin3.secureserver.net';
                                                        $mail->Port=465;
                                                        $mail->SMTPAuth=true;
                                                        $mail->SMTPSecure='ssl';

                                                        $mail->Username='sel@selhrd.com';
                                                        $mail->Password='pglV4^P^7eZn';

                                                        $mail->SetFrom('sel@selhrd.com','SEL-HRD');
                                                        $mail->AddAddress($emailTo);
                                                        $mail->AddReplyTo('noreply@selhrd.com');
                                                        $mail->isHTML(true);
                                                        $mail->Subject='Leave Application to Head';
                                                        $mail->Body=$msg;
                                                        $mail->AddStringAttachment($attachment, 'leave_form.pdf');
                                                        if(!$mail->send())
                                                        {
                                                            echo "Mailer Error: " . $mail->ErrorInfo;
                                                            echo '<div class="alert alert-danger" align="center">
                                                Mail Sending Failed to Head!
                                                </div>';
                                                        }
                                                        else
                                                        {
                                                            echo '<div class="alert alert-success" align="center">
                                                Mail Sent to Head!
                                                </div>';
                                                        }





                                                        require_once('PHPMailer/PHPMailerAutoload.php');
                                                        $mail = new PHPMailer;
                                                        //$mail->SMTPDebug = 2;
                                                        $mail->isSMTP();
                                                        $mail->Host='sg3plcpnl0194.prod.sin3.secureserver.net';
                                                        $mail->Port=465;
                                                        $mail->SMTPAuth=true;
                                                        $mail->SMTPSecure='ssl';

                                                        $mail->Username='sel@selhrd.com';
                                                        $mail->Password='pglV4^P^7eZn';

                                                        $mail->SetFrom('sel@selhrd.com','SEL-HRD');
                                                        $mail->AddAddress($emailTo_2);
                                                        $mail->AddReplyTo('noreply@selhrd.com');
                                                        $mail->isHTML(true);
                                                        $mail->Subject='Leave Application to Reporter';
                                                        $mail->Body=$msg;
                                                        $mail->AddStringAttachment($attachment, 'leave_form.pdf');
                                                        if(!$mail->send())
                                                        {
                                                            echo "Mailer Error: " . $mail->ErrorInfo;
                                                            echo '<div class="alert alert-danger" align="center">
                                                Mail Sending Failed to Reporter!
                                                </div>';
                                                        }
                                                        else
                                                        {
                                                            echo '<div class="alert alert-success" align="center">
                                                Mail Sent to Reporter!
                                                </div>';
                                                        }




                                                    }

                                                    ob_end_flush();





                                                    echo '<div align="center"><a href="leave_form_print.php?id='.$emp.'&from='.$from_date.'&to='.$to_date.'&type='.$type.'&reason='.$reason.'" class="btn btn-success" role="button">Print Leave Form</a></div>';
                                                }

                                                else{
                                                    header("location:leave_form_wrong_input.php");
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            mysqli_close($db);


                            ?>
                        </div>

                    </div>
                    <!--/span-->

                    <!--/span-->

                </div>
            </div>


            </body>
        </html>