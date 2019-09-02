<?php
session_start();
if(!($_SESSION['name']=='admin'||$_SESSION['head']=='Yes'||$_SESSION['reporter']=='Yes')){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php // include "html/navbar.html"; ?>
<?php include "html/bootstrap.html" ?>


<html>
    <head>
        <title>Requests</title>
        <meta charset="utf-8">
        <script>
            function ValidateEndDate() {
                var objFromDate = document.getElementById("from_date").value;
                var objToDate = document.getElementById("to_date").value;
                if(objToDate){

                    if(objFromDate > objToDate)
                    {
                        alert("Invalid Date Range!!");
                        document.getElementById("approve").disabled=true;
                        return false;
                    }
                }
                document.getElementById("approve").disabled=false; 
            }
        </script>
    </head>
    <body>
        <?php include "html/navbar.php" ?>
        <div> 

            <div class="container-fluid" style="padding-left:20px; padding-right:20px">



                <div>
                    <div>
                        <?php

    if(isset($_POST['approve']))
    {
        $id=$_POST['id'];
        $approver=$_SESSION['id'];

        $remark=mysqli_real_escape_string($db,$_POST['remark']);
        date_default_timezone_set('Asia/Dhaka');
        $today= date('Y-m-d', time());

        $new_from=$_POST['from_date'];
        $new_to=$_POST['to_date'];

        $sql="SELECT * FROM leaves WHERE LeaveID='$id'";
        $res=mysqli_query($db, $sql);
        $m=mysqli_fetch_array($res);
        $emp_id=$m['EmployeeID'];
        $from=$m['From Date'];
        $to=$m['To Date'];
        $ref=$m['ref'];
        $app_date=$m['apply_date'];
        $type=$m['Type'];

        $sql="SELECT * FROM employee WHERE ID='$emp_id'";
        $res=mysqli_query($db, $sql);
        $m=mysqli_fetch_array($res);

        $emailTo = $m['Email'];

        if(date_create($from)==date_create($new_from) && date_create($to)==date_create($new_to))
        {
            if($approver=='10001')
            {
                $comment="<b>Admin</b> has <font color=green>Approved</font> your leave From <font color=#668cff>".date_format(date_create($from),"M d, Y")."</font> To <font color=#668cff>".date_format(date_create($to),"M d, Y") ."</font> (Approval Date: <i>". date_format(date_create($today),"M d, Y")."</i>)" ;
            }
            else
            {
                $sql="SELECT * FROM employee WHERE ID='$approver'";
                $res=mysqli_query($db, $sql);
                $m=mysqli_fetch_array($res);
                $name=$m['First Name']." ".$m['Last Name'];
                $comment="<b>".$name."</b>(ID: ".$approver.")"." has <font color=green>Approved</font>  your Leave Request From <font color=#668cff>".date_format(date_create($from),"M d, Y")."</font> To <font color=#668cff>".date_format(date_create($to),"M d, Y") ."</font> (Approval Date: <i>". date_format(date_create($today),"M d, Y")."</i>)" ;
            }

            $query1="UPDATE `leaves` SET approver_id='$approver',status='Approved',approval_date='$today',remarks='$remark' WHERE LeaveID='$id'";
            mysqli_query($db,$query1);

            $sql="INSERT INTO `notification`(`emp_id`, `type`, `date`, `comment`,`ref`) VALUES ('$emp_id','Leave','$today','$comment','$ref')";
            if(!mysqli_query($db,$sql))
            {
                printf("Errormessage: %s\n", mysqli_error($db));
            }
        }
        else //if date is changed
        {
            $from=$new_from;
            $to=$new_to;
            if(date_create($from)>date_create($to))
            {
                echo "<div class='alert alert-danger'><center><stong>Invalid Date!!</strong></center></div>";
            }
            else
            {  
                if($approver=='10001')
                {
                    $comment="<b>Admin</b> has changed your leave application and <font color=green>Approved</font> your leave From <font color=#668cff>".date_format(date_create($from),"M d, Y")."</font> To <font color=#668cff>".date_format(date_create($to),"M d, Y") ."</font> (Approval Date: <i>". date_format(date_create($today),"M d, Y")."</i>)" ;
                }
                else
                {
                    $sql="SELECT * FROM employee WHERE ID='$approver'";
                    $res=mysqli_query($db, $sql);
                    $m=mysqli_fetch_array($res);
                    $name=$m['First Name']." ".$m['Last Name'];
                    $comment="<b>".$name."</b>(ID: ".$approver.")"." has has changed your leave application and <font color=green>Approved</font>  your Leave Request From <font color=#668cff>".date_format(date_create($from),"M d, Y")."</font> To <font color=#668cff>".date_format(date_create($to),"M d, Y") ."</font> (Approval Date: <i>". date_format(date_create($today),"M d, Y")."</i>)" ;
                }

                if($type=='Casual') $leave_type='casual';
                if($type=='Sick') $leave_type='sick';
                if($type=='Annual') $leave_type='annual';
                if($type=='Maternity') $leave_type='maternity';
                if($type=='Paternity') $leave_type='paternity';
                if($type=='Without Pay Leave') $leave_type='wpl';


                date_default_timezone_set('Asia/Dhaka');
                $leave_year = date('Y', time());
                $sql="SELECT * FROM `leave_types` WHERE emp_id = '$emp_id' AND `year`='$leave_year'";
                $result_1 = mysqli_query ($db, $sql);
                $row = mysqli_fetch_array($result_1);
                $day_type=$row[$leave_type];

                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp_id' AND status='Approved' AND type='$type' AND `year`='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_day=mysqli_fetch_array($result);
                $day=$row_day['Total'];
                $left=(int)$day_type-(int)$row_day;

                $diff = date_diff(date_create($from), date_create($to));
                $a = $diff->days;
                $a = (int) $a;
                $a++;

                if($left<$a)
                {
                    echo "<div class='alert alert-danger'><center><stong>Not Enough Leaves in Selected Type</strong></center></div>";

                }
                else
                {

                    $query1="UPDATE `leaves` SET approver_id='$approver',`From Date`='$from',`To Date`='$to',status='Approved',approval_date='$today',days='$a',remarks='$remark' WHERE LeaveID='$id'";
                    mysqli_query($db,$query1);

                    $sql="INSERT INTO `notification`(`emp_id`, `type`, `date`, `comment`,`ref`) VALUES ('$emp_id','Leave','$today','$comment','$ref')"; 
                    if(!mysqli_query($db,$sql))
                    {
                        printf("Errormessage: %s\n", mysqli_error($db));
                    }

                }



            }
        }
    }
if(isset($_POST['reject']))
{
    $id=$_POST['id'];
    $approver=$_SESSION['id'];

    $remark=mysqli_real_escape_string($db,$_POST['remark']);
    date_default_timezone_set('Asia/Dhaka');
    $today= date('Y/m/d', time());
    $query1="UPDATE `leaves` SET approval_date='$today',approver_id='$approver',status='Rejected',remarks='$remark' WHERE LeaveID=".$id;
    mysqli_query($db,$query1);
    $sql="SELECT * FROM leaves WHERE LeaveID='$id'";
    $res=mysqli_query($db, $sql);
    $m=mysqli_fetch_array($res);
    $emp_id=$m['EmployeeID'];
    $from=$m['From Date'];
    $to=$m['To Date'];
    $ref=$m['ref'];

    $app_date=$m['apply_date'];
    $sql="SELECT * FROM employee WHERE ID='$emp_id'";
    $res=mysqli_query($db, $sql);
    $m=mysqli_fetch_array($res);

    $emailTo   = $m['Email'];

    if($approver=='10001')
    {

        $comment="<b>Admin</b> has <font color=red>Rejected</font> your leave From <font color=#668cff>".date_format(date_create($from),"M d, Y")."</font> To <font color=#668cff>".date_format(date_create($to),"M d, Y") ."</font> (Rejection Date: <i>". date_format(date_create($today),"M d, Y")."</i>)" ;
    }
    else
    {
        $sql="SELECT * FROM employee WHERE ID='$approver'";
        $res=mysqli_query($db, $sql);
        $m=mysqli_fetch_array($res);
        $name=$m['First Name']." ".$m['Last Name'];
        $comment="<b>".$name."</b>(ID: ".$approver.")"." has <font color=red>Rejected</font>  your Leave Request From <font color=#668cff>".date_format(date_create($from),"M d, Y")."</font> To <font color=#668cff>".date_format(date_create($to),"M d, Y") ."</font> (Rejection Date: <i>". date_format(date_create($today),"M d, Y")."</i>)" ;

    }
    $sql="INSERT INTO `notification`(`emp_id`, `type`, `date`, `comment`,`ref`) VALUES ('$emp_id','Leave','$today','$comment','$ref')";
    if(!mysqli_query($db,$sql))
    {
        printf("Errormessage: %s\n", mysqli_error($db));
    }

}

//Mail to employee
if(isset($_POST['reject'])||isset($_POST['approve']))
{

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
    $mail->Subject='Leave Notification';
    //$mail->Body=$comment;
    //if(!$mail->send())
    {
        //    echo "Mailer Error: " . $mail->ErrorInfo;
    }

}



$head_reporter = $_SESSION['id'];
$sql = "SELECT * FROM department WHERE head_id='$head_reporter' OR reporter_id='$head_reporter'";
$result = mysqli_query($db, $sql);
$array=array();
$count=0;
while($row=mysqli_fetch_array($result))
{
    $array[]=(int)$row['dep_id'];
    $count++;
}
for($i=0; $i<$count; $i++)
{
    $dep = $array[$i];
    $sql = "SELECT * FROM department WHERE dep_id='$dep'";
    $result= mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    
    $query = "SELECT leaves.*, employee.* FROM leaves JOIN employee ON leaves.EmployeeID=employee.ID WHERE leaves.status='Pending' AND employee.department_id=$dep";
    $result= mysqli_query($db, $query);

    if($result->num_rows === 0)
    {
        continue;

    }
    else       
    {
        echo "<big><b>Department: </b>".$row['dep_name']."<br></big>";
        echo "<br><table  border='1' align='center' class='table table-striped'> 
                        <tr>
                        <th fixed-width='5%'>ID</th>
                        <th fixed-width='5%'>Image</th>
                        <th width='150px'>Name</th>
                        <th width='150px'>Apply Date</th> 
                        <th width='10%'><center>From</center></th> 
                        <th width='10%'><center>To</center></th>
                        <th width='50px'>Days</th>
                        <th width='100px'>Type</th>
                        <th width='15%px'>Reason</th>
                        <th fixed-width='15%'>Remarks</th>
                        <th width='100px'>Approve/Reject</th>
                        <th width='100px'>Status</th>
                        </tr>";
        while($row = mysqli_fetch_assoc($result))
        {
            $employee=$row['EmployeeID'];
            $sql="SELECT * FROM employee WHERE ID='$employee'";
            $employee_res=mysqli_query($db,$sql);
            $employee_fin=mysqli_fetch_array($employee_res);

            echo "<tr>";
            echo "<td><center>" .$row['EmployeeID'] . "</center></td>";
            echo "<td><center><img src='" .$row['image'] . "' width='50px' height='50px' class='img img-rounded'></center></td>";   
            echo "<td><center><a href='jobdetails.php?id=".$employee."'>".$employee_fin['First Name']." ".$employee_fin['Last Name']."<a/></center></td>";
            echo "<td>" .date_format(date_create($row['apply_date']),"M d, Y") ."</td>";
            echo "<td><form method='post' action=''><center>" .date_format(date_create($row['From Date']),"M d, Y") ."</center><b>Edit (If Necessary):</b><input type='date' id='from_date' value='".$row['From Date']."' class='form-control' name='from_date' onchange='ValidateEndDate()' style='width:150px'></td>";
            echo "<td><center>" .date_format(date_create($row['To Date']),"M d, Y"). "</center><b>Edit (If Necessary):</b><input type='date' id='to_date' value='".$row['To Date']."' class='form-control' name='to_date' onchange='ValidateEndDate()' style='width:150px'></td>";
            echo "<td><center>" . $row['days'] . "</center></td>";
            if($row['Type']=='Maternity') 
            {
                echo "<td><center>Parental</center></td>";
            }
            else if($row['Type']=='Paternity')
            {
                echo "<td><center>Alternative</center></td>";
            }
            else
            {
                echo "<td><center>" . $row['Type'] . "</center></td>"; 
            }

            echo "<td><center>" . $row['Reason'] . "</center></td>";
            echo "<td><center><textarea style='width:220px;height:80px' name='remark' required></textarea></center></td>";
            echo "<td><center>
                            <input type='hidden' name='id' value='".$row['LeaveID']."'>
                            <button class='btn btn-success' type='submit' name='approve' id='approve'>Approve</button><br><br>
                            <button class='btn btn-danger' type='submit' name='reject'>Reject</button>
                            </center></form></td>"; 
            if($row['status']=='Approved')
            {
                echo "<td><center><font color='green'>Approved</font></center></td>";
            }
            else if($row['status']=='Rejected')
            {
                echo "<td><center><font color='red'>Rejected</font></center></td>";
            }
            else if($row['status']=='Pending')
            {
                echo "<td><center><font color='blue'>Pending</font></center></td>";
            }
            echo "</tr>";


        }
        echo "</table><br><hr>"; 
    }
}
$query = "SELECT * FROM `leaves` WHERE status='Pending'";

if($_SESSION['name']=='admin')
{
    $sql = "SELECT * FROM department";
    $result = mysqli_query($db, $sql);
    $array=array();
    $count=0;
    while($row=mysqli_fetch_array($result))
    {
        $array[]=(int)$row['dep_id'];
        $count++;
    }
    for($i=0; $i<$count; $i++)
    {
        $dep = $array[$i];
        $sql = "SELECT * FROM department WHERE dep_id='$dep'";
        $result= mysqli_query($db, $sql);
        $row=mysqli_fetch_array($result);
        $query = "SELECT leaves.*, employee.* FROM leaves JOIN employee ON leaves.EmployeeID=employee.ID WHERE leaves.status='Pending' AND employee.department_id='$dep'";
        $result= mysqli_query($db, $query);

        if($result->num_rows === 0)
        {
             continue;

        }
        else 
        {
            echo "<big><b>Department: </b>".$row['dep_name']."<br></big>";
            echo "<br><table  border='1' align='center' class='table table-striped'> 
                            <tr>
                            <th fixed-width='5%'>ID</th>
                            <th fixed-width='5%'>Image</th>
                            <th width='150px'>Name</th>
                            <th width='150px'>Apply Date</th> 
                            <th width='10%'><center>From</center></th> 
                            <th width='10%'><center>To</center></th>
                            <th width='50px'>Days</th>
                            <th width='100px'>Type</th>
                            <th width='15%px'>Reason</th>
                            <th fixed-width='15%'>Remarks</th>
                            <th width='100px'>Approve/Reject</th>
                            <th width='100px'>Status</th>
                            </tr>";
            while($row = mysqli_fetch_assoc($result))
            {
                $employee=$row['EmployeeID'];
                $sql="SELECT * FROM employee WHERE ID='$employee'";
                $employee_res=mysqli_query($db,$sql);
                $employee_fin=mysqli_fetch_array($employee_res);

                echo "<tr>";
                echo "<td><center>" .$row['EmployeeID'] . "</center></td>";
                echo "<td><center><img src='" .$row['image'] . "' width='50px' height='50px' class='img img-rounded'></center></td>";	
                echo "<td><center><a href='jobdetails.php?id=".$employee."'>".$employee_fin['First Name']." ".$employee_fin['Last Name']."<a/></center></td>";
                echo "<td>" .date_format(date_create($row['apply_date']),"M d, Y") ."</td>";
                echo "<td><form method='post' action=''><center>" .date_format(date_create($row['From Date']),"M d, Y") ."</center><b>Edit (If Necessary):</b><input type='date' id='from_date' value='".$row['From Date']."' class='form-control' name='from_date' onchange='ValidateEndDate()' style='width:150px'></td>";
                echo "<td><center>" .date_format(date_create($row['To Date']),"M d, Y"). "</center><b>Edit (If Necessary):</b><input type='date' id='to_date' value='".$row['To Date']."' class='form-control' name='to_date' onchange='ValidateEndDate()' style='width:150px'></td>";
                echo "<td><center>" . $row['days'] . "</center></td>";
                if($row['Type']=='Maternity') 
                {
                    echo "<td><center>Parental</center></td>";
                }
                else if($row['Type']=='Paternity')
                {
                    echo "<td><center>Alternative</center></td>";
                }
                else
                {
                    echo "<td><center>" . $row['Type'] . "</center></td>"; 
                }
                echo "<td><center>" . $row['Reason'] . "</center></td>";
                echo "<td><center><textarea style='width:220px;height:80px' name='remark' required></textarea></center></td>";
                echo "<td><center>
                                <input type='hidden' name='id' value='".$row['LeaveID']."'>
                                <button class='btn btn-success' type='submit' name='approve' id='approve'>Approve</button><br><br>
                                <button class='btn btn-danger' type='submit' name='reject'>Reject</button>
                                </center></form></td>";	
                if($row['status']=='Approved')
                {
                    echo "<td><center><font color='green'>Approved</font></center></td>";
                }
                else if($row['status']=='Rejected')
                {
                    echo "<td><center><font color='red'>Rejected</font></center></td>";
                }
                else if($row['status']=='Pending')
                {
                    echo "<td><center><font color='blue'>Pending</font></center></td>";
                }
                echo "</tr>";


            }
            echo "</table><br><hr>"; 
        }
    }



}


                        ?>


                    </div>
                </div>
                <!--/span-->
                <!--/span-->

            </div>
        </div>
    </body>	
</html>