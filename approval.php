<?php
session_start();
if(!$_SESSION['name']){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php //include "html/navbar.html"; ?>
<?php include "html/bootstrap.html" ?>
<html>
    <head></head>
    <body>
        <?php include "html/navbar.php" ?>
        <div class="container">
            <?php
    if(isset($_POST['submit'])){
        date_default_timezone_set('Asia/Dhaka');
        $date = date('m/d/Y', time());
        $apply_date = date('Y-m-d', time());
        $entrier=$_SESSION['id'];
        $emp = $_POST['id'];
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
            echo "Employee Doesn't Exist!!";
        }
        else {
            if(0)//if($comp<$date)
            {
                echo "Invalid Date!!!";   
            }

            else
            {
                $sql="SELECT MAX(LeaveID) AS maxi WHERE employeeID='$emp'";
                $result_1 =mysqli_query($db, $sql);
                $latest=mysqli_fetch_array($result_1);
                $serial_id=$latest['maxi'];

                $sql="SELECT * FROM `leaves` WHERE joined='No' AND LeaveID='$serial_id'";
                $result_1 =mysqli_query($db, $sql);

                if($result_1->num_rows !== 0)
                {
                    echo "Already Taken!!";
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
                    $type = mysqli_real_escape_string($db, $_POST['type']);
                    $sql="SELECT * FROM `leave_types` WHERE emp_id = '$emp'";
                    $result_1 = mysqli_query ($db, $sql);
                    $row = mysqli_fetch_array($result_1);

                    //Gets total casual leaves    
                    $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Casual'";
                    $result=mysqli_query($db, $sql);
                    $row_casual=mysqli_fetch_array($result);
                    $day_casual=$row_casual['Total'];

                    //Gets total sick leaves
                    $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Sick'";
                    $result=mysqli_query($db, $sql);
                    $row_sick=mysqli_fetch_array($result);
                    $day_sick=$row_sick['Total'];

                    //Gets total annual leaves
                    $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Annual'";
                    $result=mysqli_query($db, $sql);
                    $row_annual=mysqli_fetch_array($result);
                    $day_annual=$row_annual['Total'];

                    //Gets total maternity leaves
                    $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Maternity'";
                    $result=mysqli_query($db, $sql);
                    $row_maternity=mysqli_fetch_array($result);
                    $day_maternity=$row_maternity['Total'];

                    //Gets total paternity leaves
                    $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Paternity'";
                    $result=mysqli_query($db, $sql);
                    $row_paternity=mysqli_fetch_array($result);
                    $day_paternity=$row_paternity['Total']; 

                    //Gets total wpl leaves
                    $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Without Pay Leave'";
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
                    }    
                    if($type=="Without Pay Leave")
                    {

                        $existing_wpl= $existing_wpl-$a;   
                    }

                    if($existing_sick<0||$existing_casual<0||$existing_wpl<0||$existing_maternity<0||$existing_paternity<0||$existing_annual<0)
                    {
                        echo "<h3><font color='red'>You Don't Have enough Leaves!!<br>Request Can't Be Submitted!! Please Check Your Leave Information!!</font></h3>";   
                    }
                    else
                    {
                        if ($result_1->num_rows !== 0)
                        {

                            $query1= "INSERT INTO `leaves`(`EmployeeID`,`apply_date`,`entrier_id`, `From Date`, `To Date`, `Type`, `Reason`, `days`) VALUES ('$emp','$apply_dateF','$entrier','$from_date','$to_date','$type','$reason', '$a')";
                            $query2 ="SELECT department.reporting_mail FROM `department` JOIN `employee` ON department.dep_id=employee.department_id WHERE employee.ID ='$emp'";
                            $result = mysqli_query($db, $query2);
                            $reporting_mail=mysqli_fetch_array($result);




                            if(!mysqli_query($db, $query1))
                            {
                                die('Error!! '.mysqli_error($db));
                            }
                            else 
                            {



                                //echo $reporting_mail['reporting_mail'];
                                $fromTitle = "SEL";
                                $emailTo   = $reporting_mail['reporting_mail'];
                                $subject = "Request Approval"; 
                                $message = "projectskt.com/request_page.php";




                                $mail=mail($emailTo, $subject, $message);
                                echo "<br><h4>Request Submitted Successfully!!!</h4><br><br>"; 
                            }

                            if($mail){
                                echo "Thank you!!!";
                            }else{
                                echo "Mail sending failed."; 
                            }
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


            ?></div></body>
</html>