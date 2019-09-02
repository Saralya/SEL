<?php
session_start();
if(!($_SESSION['id']=='10001'||$_SESSION['name']=='data_entry'||$_SESSION['id']==$_GET['id']||$_SESSION['head']=='Yes'||$_SESSION['reporter']=='Yes')){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php
function redirect($url){
    if (!headers_sent())
    {    
        header('Location: '.$url);
        exit;
    }
    else
    {  
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}
?>
<?php
$h_r=$_SESSION['id'];
$e_id=$_GET['id'];
$sql="SELECT * FROM employee WHERE ID='$e_id'";
$res=mysqli_query($db,$sql);
$row=mysqli_fetch_array($res);
$dep_id=$row['department_id'];
$sql="SELECT * FROM department WHERE dep_id='$dep_id' AND (head_id='$h_r' OR reporter_id='$h_r')";
$res=mysqli_query($db,$sql);
if($res->num_rows==0&&$_SESSION['name']!='admin'&&$_SESSION['id']!=$_GET['id'])
{
    redirect("department_list_2.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Employee History</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">

        <style>
            pre {
                white-space: pre-wrap;       /* Since CSS 2.1 */
                white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
                white-space: -pre-wrap;      /* Opera 4-6 */
                white-space: -o-pre-wrap;    /* Opera 7 */
                word-wrap: break-word;       /* Internet Explorer 5.5+ */
                font-family: ;
            }

        </style>
    </head>
    <body>
        <?php include 'html/navbar.php'; ?>
        <div class="container-fluid" style="">
            <?php $emp_id = $_GET['id']; ?>
            <?php
            date_default_timezone_set('Asia/Dhaka');
            $date = date('m/d/Y', time());

            ?>
            <?php 
            $sql="SELECT * FROM employee WHERE ID='$emp_id'";
            $res=mysqli_query($db,$sql);
            $line=mysqli_fetch_array($res);
            ?>
            <center>
                <img class="img img-circle" src="<?php echo $line['image'];?>" width="100px" height="100px" >
                <h4>History of <a href="jobdetails.php?id=<?php echo $emp_id; ?>"><i><?php echo $line['First Name']." ".$line['Last Name']; ?></i></a><br></h4>
                ID: <b><?php echo $emp_id; ?></b><br><br>
            </center>
            <?php
            if(isset($_POST['join']))
            {
                $updater=$_SESSION['id'];
                $sql="SELECT * FROM employee WHERE ID='$updater'";
                $res=mysqli_query($db,$sql);
                $row=mysqli_fetch_array($res);
                if($_SESSION['name']=='admin')
                {
                    $updater_name='Admin';
                }
                else
                {
                    $updater_name=$row['First Name']." ".$row['Last Name'];
                }
                $id=$_POST['id'];
                $day_before = date( 'Y-m-d', strtotime( $date . ' -1 day' ) );
                $joining_date=date('Y-m-d',time());
                //$remarks=$_POST['remarks'];

                $remark=mysqli_real_escape_string($db,$_POST['remarks']);
                //$query1="UPDATE `leaves` SET remarks='$remarks' WHERE LeaveID='$id'";
                //mysqli_query($db,$query1);
                $query1="SELECT * FROM leaves WHERE LeaveID='$id'";
                $result1 = mysqli_query($db, $query1);
                $row2= mysqli_fetch_array($result1);
                $late=0;
                $days_spent=0;
                $old_remarks=$row2['remarks'];


                $remark .= "
(Updated By: ".$updater_name.", ";
                $remark .= "Time: ".date("M d, Y h:i:s a", time()).")";
                $remark = $remark."
-----------
".$old_remarks;

                $to_date=date_format(date_create($row2['To Date']),'M d, Y');
                if($row2['To Date']<$row2['From Date'])
                {
                    $to_date="No Leaves";

                }
                if((date_create($row2['From Date'])<=date_create($joining_date) && date_create($joining_date)<= date_create($row2['To Date']))||(date_create($row2['To Date'])==date_create($day_before)))
                {
                    $diff = date_diff(date_create($row2['From Date']), date_create($joining_date));
                    $a = $diff->days;
                    $a = (int) $a;
                    $query1="UPDATE `leaves` SET `To Date`='$day_before',days='$a',joining_date='$joining_date',joined='Yes',`remarks`='$remark' WHERE LeaveID='$id'";
                    mysqli_query($db,$query1);
                    $days_spent=$a;
                }
                else
                {
                    $diff = date_diff(date_create($joining_date), date_create($row2['To Date']));
                    $a = $diff->days;
                    $a = (int) $a;
                    $a--;
                    $query1="UPDATE `leaves` SET `late`='$a',joined='Yes',joining_date='$joining_date',`remarks`='$remark' WHERE LeaveID='$id'";
                    mysqli_query($db,$query1);
                    $late=$a;
                    $diff_2= date_diff(date_create($joining_date), date_create($row2['From Date']));
                    $days_spent=$diff_2->days;
                    $days_spent=(int)$days_spent;
                }
                $sql="SELECT * FROM employee WHERE ID='$emp_id'";
                $res=mysqli_query($db, $sql);
                $emp_details=mysqli_fetch_array($res);
                $dep_id=$emp_details['department_id'];
                $sql="SELECT * FROM department WHERE dep_id='$dep_id'";
                $res=mysqli_query($db, $sql);
                $dep_name=mysqli_fetch_array($res);
                $head=$dep_name['reporting_mail'];
                $reporter=$dep_name['reporting_mail_2'];

                $msg="<h3>Joining Request</h3><p><big>Hello,<br><br>".$emp_details['First Name']." ".$emp_details['Last Name']."<br> ID: <b>".$emp_id."</b> <br>Department: <i>".$dep_name['dep_name']."</i>
            <br>Phone: ".$emp_details['Cell Phone']."
            <br><br>Leave From <font color='#668cff'>".date_format(date_create($row2['From Date']),"M d, Y")."</font> To <font color='#668cff'>".$to_date."</font>
            <br>Joining Date: ".date_format(date_create($joining_date),"M d, Y")."<br>Late: ".$late." Day(s)<br>Days Spent: ".$days_spent." Day(s)</big></p><p><a href='http://selhrd.com'>
            <button>Click Here to Verify</button>
            </a></p>" ;



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
                $mail->AddAddress($head);
                $mail->AddReplyTo('noreply@selhrd.com');
                $mail->isHTML(true);
                $mail->Subject='Joining Request';
                $mail->Body=$msg;
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
                $mail->AddAddress($reporter);
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
            ?>

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab1">Leaves</a></li>
                <li><a data-toggle="tab"  href="#tab2">Department</a></li>
                <li><a data-toggle="tab"  href="#tab3">Salary</a></li>
                <li><a data-toggle="tab" href="#tab4">Designation</a></li>
                <li><a data-toggle="tab" href="#tab5">Employment Type</a></li>
                <li><a data-toggle="tab" href="#tab7">Bonus</a></li>
                <li><a data-toggle="tab" href="#tab8">Facility</a></li>
                <li><a data-toggle="tab" href="#tab9">Leave Allocation History</a></li>
                <li><a data-toggle="tab" href="#tab6">Head/Reporter Assignment</a></li>
            </ul>
            <?php $emp_id = $_GET['id']; ?>
            <div class="tab-content" style="padding-top:20px; padding-bottom:20px;">
                <div id="tab1" class="tab-pane fade in active">
                    <?php
                    date_default_timezone_set('Asia/Dhaka');
                    $date = date('m/d/Y', time());

                    ?>


                    <?php

                    function check_in_range($start_date, $end_date, $date_from_user)
                    {
                        // Convert to timestamp
                        $start_ts = strtotime($start_date);
                        $end_ts = strtotime($end_date);
                        $user_ts = strtotime($date_from_user);

                        // Check that user date is between start & end
                        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
                    }

                    $sql = "SELECT MAX(LeaveID) AS serial FROM leaves WHERE status='Approved' AND EmployeeID='$emp_id' AND joined='No'";
                    $res = mysqli_query($db,$sql);
                    $latest=mysqli_fetch_array($res);
                    $leave_id=$latest['serial'];
                    $sql = "SELECT * FROM leaves WHERE status='Approved' AND LeaveID='$leave_id' AND joined='No'";
                    $res = mysqli_query($db,$sql);
                    //echo $leave_id;
                    $data = mysqli_fetch_array($res);

                    if (date_create($data['From Date'])<=date_create(date('Y-m-d',time())))
                    {
                        echo "Leave Status: <font color='red'>On Leave</font><br><br>";
                        if($_SESSION['name']=='admin'||$_SESSION['id']==$emp_id)
                        {
                            echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Join Now</button>';
                            echo "<br><br>";
                        }
                    }
                    else {echo "Leave Status: <font color='blue'>On Duty</font><br><br>";}
                    ?>

                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Join Now</h4>
                                </div>
                                <div class="modal-body">
                                    <p><form method='post' action=''>
                                    <input type='hidden' name='id' value='<?php echo $leave_id; ?>'>
                                    Remarks<textarea name='remarks' style="height:50px" class="form-control"></textarea><br>
                                    <input type='submit' name='join' value="Confirm" class='btn btn-success'></form><br></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
                date_default_timezone_set('Asia/Dhaka');
                $leave_year = date('Y', time());
                $sql ="SELECT * FROM `leave_types` WHERE emp_id='$emp_id' AND `year`='$leave_year'";
                $result = mysqli_query($db, $sql);
                $row = mysqli_fetch_array($result);



                //Gets total casual leaves    
                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp_id' AND status='Approved' AND type='Casual' AND year='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_casual=mysqli_fetch_array($result);
                $day_casual=$row_casual['Total'];

                //Gets total sick leaves
                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp_id' AND status='Approved' AND type='Sick' AND year='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_sick=mysqli_fetch_array($result);
                $day_sick=$row_sick['Total'];

                //Gets total annual leaves
                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp_id' AND status='Approved' AND type='Annual' AND year='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_annual=mysqli_fetch_array($result);
                $day_annual=$row_annual['Total'];

                //Gets total maternity leaves
                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp_id' AND status='Approved' AND type='Maternity' AND year='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_maternity=mysqli_fetch_array($result);
                $day_maternity=$row_maternity['Total'];

                //Gets total paternity leaves
                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp_id' AND status='Approved' AND type='Paternity' AND year='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_paternity=mysqli_fetch_array($result);
                $day_paternity=$row_paternity['Total']; 

                //Gets total wpl leaves
                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp_id' AND status='Approved' AND type='Without Pay Leave' AND year='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_wpl=mysqli_fetch_array($result);
                $day_wpl=$row_wpl['Total'];

                $existing_casual= $row['casual']-$day_casual; 
                $existing_sick= $row['sick']-$day_sick;
                $existing_annual= $row['annual']-$day_annual;
                $existing_maternity= $row['maternity']-$day_maternity;
                $existing_paternity= $row['paternity']-$day_paternity;
                $existing_wpl= $row['wpl']-$day_wpl;

                echo "";
                ?>
                <div style='padding-left:400px;padding-right:400px'>
                    <big><b>Year: </b><?php echo $leave_year;?></big><br><br>
                    <table border="1" cellpadding='10' cellspacing='2' align='center' class=' table table-bordered'>
                        <tr>
                            <th width='150px'><center>Types</center></th>
                            <th width='150px'><center>Casual</center></th>
                            <th width='150px'><center>Sick</center></th>
                            <th width='150px'><center>Annual</center></th>
                            <th width='150px'><center>Parental</center></th>
                            <th width='150px'><center>Alternative</center></th>
                            <th width='150px'><center>Without Pay Leaves</center></th>
                        </tr>
                        <tr>
                            <td>Allocated</td>
                            <td><center><?php echo $row['casual'];  ?></center></td>
                            <td><center><?php echo $row['sick'];  ?></center></td>
                            <td><center><?php echo $row['annual'];  ?></center></td>
                            <td><center><?php echo $row['maternity'];  ?></center></td>
                            <td><center><?php echo $row['paternity'];  ?></center></td>
                            <td><center><?php echo $row['wpl'];  ?></center></td>

                        </tr>
                        <tr>
                            <td>Taken</td>
                            <td><center><?php echo $day_casual;?></center></td>
                            <td><center><?php echo $day_sick; ?></center></td>
                            <td><center><?php echo $day_annual; ?></center></td>
                            <td><center><?php echo $day_maternity; ?></center></td>
                            <td><center><?php echo $day_paternity; ?></center></td>
                            <td><center><?php echo $day_wpl; ?></center></td>
                        </tr>
                        <tr>
                            <td>Existing</td>
                            <td><center><?php echo $existing_casual;?></center></td>
                            <td><center><?php echo $existing_sick; ?></center></td>
                            <td><center><?php echo $existing_annual; ?></center></td>
                            <td><center><?php echo $existing_maternity; ?></center></td>
                            <td><center><?php echo $existing_paternity; ?></center></td>
                            <td><center><?php echo $existing_wpl; ?></center></td>
                        </tr>
                    </table></div><br>


                <?php
                if($_SESSION['name']=='admin')
                {
                    echo "<a class='btn btn-success' href='update_leaves.php?id=".$emp_id."'>Update</a><br><br>";
                }
                ?>
                <div class="col-sm-2">
                    <input type="text" name="from_date_lv" id="from_date_lv" class="form-control" placeholder="From Date">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="to_date_lv" id="to_date_lv" class="form-control" placeholder="To Date">
                </div>
                <div class="col-sm-5">
                    <input type="button" name="filter_lv" id="filter_lv" value="Filter" class="btn btn-sm btn-primary">

                    <input type="button" name="filter_all" id="filter_all" value="Show All" class="btn btn-sm btn-primary">
                </div>
                <input type="hidden" name="filter_id" id="filter_id" value="<?php echo $emp_id;?>">
                <br><br><br>

                <div id="tbl_lv">

                    <?php


                    echo "<table cellpadding='5' cellspacing='2' align='center' class='table table-striped table-bordered'> 
                    <tr>
                    <th width='70px'><center>Apply Date</center></th>
                    <th width='70px'><center>From</center></th>
                    <th width='70px'><center>To</center></th>
                    <th width=''><center>Days</center></th>

                    <th width='70px'><center>Action Date</center></th>
                    <th width=''><center>Type</center></th>
                    <th width='15%'><center>Reasons</center></th>
                    <th width=''><center>Status</center></th>
                    <th width='70px'><center>Joining Date</center></th>
                    <th width=''><center>Late</center></th>
                    <th width='25%'><center>Remarks</center></th>
                    <th width='150px'><center>Reference</center></th>";

                    if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry') echo "<th width='20px'>Edit</th>";
                    echo "</tr>";

                    $query = "SELECT * FROM `leaves` WHERE employeeID='$emp_id' ORDER BY `LeaveID` DESC LIMIT 10";
                    $result = mysqli_query($db, $query);

                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td><center>" . date_format(date_create($row['apply_date']),"M d, Y"). "</center></td>";
                        echo "<td><center>" . date_format(date_create($row['From Date']),"M d, Y"). "</center></td>";
                        if(date_create($row['From Date'])>date_create($row['To Date']))
                        {
                            echo "<td><center>No Leaves</center></td>";
                        }
                        else
                        {
                            echo "<td><center>" . date_format(date_create($row['To Date']),"M d, Y"). "</center></td>";
                        }
                        echo "<td><center>".$row['days']."</center></td>";
                        if($row['approval_date']=='0000-00-00')
                        {
                            echo "<td><center>---------</center></td>";
                        }
                        else
                        {
                            echo "<td><center>" . date_format(date_create($row['approval_date']),"M d, Y"). "</center></td>";
                        }

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
                        
                        echo "<td><center>".$row['Reason']."</center></td>";
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
                        if($row['joined']=='No')
                        {
                            echo "<td><center>Didn't Joined</center></td>";
                        }
                        else
                        {
                            echo "<td><center>".date_format(date_create($row['joining_date']),"d M, Y")."</center></td>";
                        }

                        $today=date('Y-m-d',time());
                        $today=date( 'Y-m-d', strtotime( $today . ' -1 day' ) );
                        if(date_create($today)>date_create($row['To Date'])&&$row['joined']=='No'&&$row['status']=='Approved')
                        {
                            $diff = date_diff(date_create($today),date_create($row['To Date']));
                            $a = $diff->days;
                            echo "<td><center>".$a."</center></td>";

                        }
                        else
                        {
                            echo "<td><center>".$row['late']."</center></td>"; 
                        }

                        echo "<td><pre>".$row['remarks']."</pre></td>";
                        echo "<td><center>".$row['ref']."</center></td>";
                        if($_SESSION['name']=='admin'||$_SESSION['head']=='Yes'||$_SESSION['reporter']=='Yes')
                        {
                            if($row['joined']=='Yes')   echo "<td><a href='edit_remark.php?id=".$row['LeaveID']."' class='glyphicon glyphicon-pencil'></a></td>";
                            else "<td></td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";

                    ?>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $.datepicker.setDefaults({
                        dateFormat: 'yy-mm-dd'
                    });
                    $(function(){
                        $("#from_date_lv").datepicker();
                        $("#to_date_lv").datepicker();
                    });
                    $('#filter_lv').click(function(){
                        var from_date = $("#from_date_lv").val();
                        var to_date = $("#to_date_lv").val();
                        var id =$("#filter_id").val();
                        if(from_date != '' && to_date != '')
                        {
                            $.ajax({
                                url:"filter_lv.php",
                                method:"POST",
                                data:{from_date:from_date, to_date:to_date, id:id},
                                success:function(data)
                                {
                                    $("#tbl_lv").html(data);
                                }

                            });
                        }
                        else
                        {
                            alert("Please Select Date!");
                        }
                    });
                    $('#filter_all').click(function(){
                        var id =$("#filter_id").val();
                        $.ajax({
                            url:"filter_lv_all.php",
                            method:"POST",
                            data:{id:id},
                            success:function(data)
                            {
                                $("#tbl_lv").html(data);
                            }
                        });
                    });

                });
            </script>
            <div id="tab2" class="tab-pane fade">

                <div class="col-sm-2">
                    <input type="text" name="from_date_dep" id="from_date_dep" class="form-control" placeholder="From Date">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="to_date_dep" id="to_date_dep" class="form-control" placeholder="To Date">
                </div>
                <div class="col-sm-5">
                    <input type="button" name="filter_dep" id="filter_dep" value="Filter" class="btn btn-sm btn-primary">

                    <input type="button" name="filter_dep_all" id="filter_dep_all" value="Show All" class="btn btn-sm btn-primary">
                </div>
                <br><br><br>
                <?php
                $query="SELECT * FROM job_status WHERE emp_id='$emp_id'";
                $result=mysqli_query($db, $query);
                $line=mysqli_fetch_array($result);
                $sql = "SELECT * FROM department WHERE dep_id=".$line['curr_department'];
                $result=mysqli_query($db, $sql);
                $line=mysqli_fetch_array($result);
                echo "<b>Current Department: </b>".$line['dep_name']."<br><br>";
                $sql="SELECT * FROM history_department  WHERE emp_id='$emp_id' ORDER BY `serial` DESC LIMIT 10";
                $res=mysqli_query($db, $sql);
                echo "<div id='tbl_dep'>";
                echo "<table align='center' class='table table-striped table-bordered'>";
                echo "<tr>";
                echo "<th width='150px'>Entrier</th>";
                echo "<th width='70px'>Entry Date</th>";
                echo "<th width='150px'>From</th>";
                echo "<th width='150px'>To</th>";
                echo "<th width='70px'>Approval Date</th>";
                echo "<th width='70px'>Effective Date</th>";
                echo "<th width='150px'>Reference</th>";
                echo "<th width='25%'>Remarks</th>";
                echo "<th width='5px'>Edit</th>";
                echo "</tr>";
                while($row=mysqli_fetch_array($res))
                {
                    echo "<tr>";
                    if($row[2]=='10001')
                    {
                        echo "<td>Admin</td>";
                    }
                    else
                    {
                        $id=$row[2];
                        $sql ="SELECT * FROM employee WHERE ID='$id'";
                        $result=mysqli_query($db, $sql);
                        $line=mysqli_fetch_array($result);
                        echo "<td>".$line['First Name']." ".$line['Last Name']."</td>";
                    }
                    echo "<td>".date_format(date_create($row['entry_date']),"M d, Y")."</td>";
                    $a=$row['from'];
                    $sql = "SELECT * FROM department WHERE dep_id='$a'";
                    $result=mysqli_query($db, $sql);
                    $line=mysqli_fetch_array($result);
                    echo "<td>".$line['dep_name']."</td>";
                    $sql = "SELECT * FROM department WHERE dep_id=".$row['tos'];
                    $result=mysqli_query($db, $sql);
                    $line=mysqli_fetch_array($result);
                    echo "<td>".$line['dep_name']."</td>";

                    echo "<td>".date_format(date_create($row['approval_date']),"M d, Y")."</td>";
                    echo "<td>".date_format(date_create($row['date']),"M d, Y")."</td>";
                    echo "<td>".$row['ref']."</td>";
                    echo "<td><pre>".$row['remarks']."</pre></td>";
                    echo "<td><a href='edit_remark_dep.php?id=".$row['serial']."' class='glyphicon glyphicon-pencil'></a></td>";
                    echo "</tr>";
                }
                echo "</table></div>";
                ?></div>
            <script>
                $(document).ready(function(){
                    $.datepicker.setDefaults({
                        dateFormat: 'yy-mm-dd'
                    });
                    $(function(){
                        $("#from_date_dep").datepicker();
                        $("#to_date_dep").datepicker();
                    });
                    $('#filter_dep').click(function(){
                        var from_date = $("#from_date_dep").val();
                        var to_date = $("#to_date_dep").val();
                        var id =$("#filter_id").val();
                        if(from_date != '' && to_date != '')
                        {
                            $.ajax({
                                url:"filter_dep.php",
                                method:"POST",
                                data:{from_date:from_date, to_date:to_date, id:id},
                                success:function(data)
                                {
                                    $("#tbl_dep").html(data);
                                }

                            });
                        }
                        else
                        {
                            alert("Please Select Date!");
                        }
                    });
                    $('#filter_dep_all').click(function(){
                        var id =$("#filter_id").val();
                        $.ajax({
                            url:"filter_dep_all.php",
                            method:"POST",
                            data:{id:id},
                            success:function(data)
                            {
                                $("#tbl_dep").html(data);
                            }
                        });
                    });

                });
            </script>
            <div id="tab3" class="tab-pane fade">

                <div class="col-sm-2">
                    <input type="text" name="from_date_sal" id="from_date_sal" class="form-control" placeholder="From Date">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="to_date_sal" id="to_date_sal" class="form-control" placeholder="To Date">
                </div>
                <div class="col-sm-5">
                    <input type="button" name="filter_sal" id="filter_sal" value="Filter" class="btn btn-sm btn-primary">

                    <input type="button" name="filter_sal_all" id="filter_sal_all" value="Show All" class="btn btn-sm btn-primary">
                </div>
                <br><br><br>
                <script>
                    $(document).ready(function(){
                        $.datepicker.setDefaults({
                            dateFormat: 'yy-mm-dd'
                        });
                        $(function(){
                            $("#from_date_sal").datepicker();
                            $("#to_date_sal").datepicker();
                        });
                        $('#filter_sal').click(function(){
                            var from_date = $("#from_date_sal").val();
                            var to_date = $("#to_date_sal").val();
                            var id =$("#filter_id").val();
                            if(from_date != '' && to_date != '')
                            {
                                $.ajax({
                                    url:"filter_sal.php",
                                    method:"POST",
                                    data:{from_date:from_date, to_date:to_date, id:id},
                                    success:function(data)
                                    {
                                        $("#tbl_sal").html(data);
                                    }

                                });
                            }
                            else
                            {
                                alert("Please Select Date!");
                            }
                        });
                        $('#filter_sal_all').click(function(){
                            var id =$("#filter_id").val();
                            $.ajax({
                                url:"filter_sal_all.php",
                                method:"POST",
                                data:{id:id},
                                success:function(data)
                                {
                                    $("#tbl_sal").html(data);
                                }
                            });
                        });

                    });
                </script>
                <?php
                $query="SELECT * FROM job_status WHERE emp_id='$emp_id'";
                $result=mysqli_query($db, $query);
                $line=mysqli_fetch_array($result);
                echo "<b>Joining Salary(Taka): </b>".$line['joining_gross']." <br><br>";
                echo "<b>Current Salary(Taka): </b>".$line['current_gross']." <br><br>";
                $sql="SELECT * FROM history_salary WHERE emp_id='$emp_id' ORDER BY `serial` DESC LIMIT 10";
                $res=mysqli_query($db, $sql);
                echo "<div id='tbl_sal'>";
                echo "<table align='center' class='table table-striped table-bordered'>";
                echo "<tr>";
                echo "<th width='150px'>Entrier</th>";
                echo "<th width='150px'>Entry Date</th>";
                echo "<th width='150px'>Amount</th>";
                echo "<th width='150px'>Approval Date</th>";
                echo "<th width='150px'>Effective Date</th>";
                echo "<th width='150px'>Reference</th>";
                echo "<th width='150px'>Remarks</th>";
                echo "<th width='20px'>Edit</th>";
                echo "</tr>";
                while($row=mysqli_fetch_array($res))
                {
                    echo "<tr>";
                    if($row[2]=='10001')
                    {
                        echo "<td>Admin</td>";
                    }
                    else
                    {
                        $id=$row[2];
                        $sql ="SELECT * FROM employee WHERE ID='$id'";
                        $result=mysqli_query($db, $sql);
                        $line=mysqli_fetch_array($result);
                        echo "<td>".$line['First Name']." ".$line['Last Name']."</td>";
                    }

                    echo "<td>".date_format(date_create($row['entry_date']),"M d, Y")."</td>";
                    echo "<td>".$row[5]."</td>";

                    echo "<td>".date_format(date_create($row['approval_date']),"M d, Y")."</td>";
                    echo "<td>".date_format(date_create($row['date']),"M d, Y")."</td>";
                    echo "<td>".$row['ref']."</td>";
                    echo "<td><pre>".$row['remarks']."</pre></td>";
                    echo "<td><a href='edit_remark_sal.php?id=".$row['serial']."' class='glyphicon glyphicon-pencil'></a></td>";
                    echo "</tr>";
                }
                echo "</table></div>"; ?></div>     
            <div id="tab4" class="tab-pane fade">
                <h5><b>Search By Effective Date: </b></h5>
                <div class="col-sm-2">
                    <input type="text" name="from_date_des" id="from_date_des" class="form-control" placeholder="From Date">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="to_date_des" id="to_date_des" class="form-control" placeholder="To Date">
                </div>
                <div class="col-sm-5">
                    <input type="button" name="filter_des" id="filter_des" value="Filter" class="btn btn-sm btn-primary">

                    <input type="button" name="filter_des_all" id="filter_des_all" value="Show All" class="btn btn-sm btn-primary">
                </div>
                <br><br><br>
                <script>
                    $(document).ready(function(){
                        $.datepicker.setDefaults({
                            dateFormat: 'yy-mm-dd'
                        });
                        $(function(){
                            $("#from_date_des").datepicker();
                            $("#to_date_des").datepicker();
                        });
                        $('#filter_des').click(function(){
                            var from_date = $("#from_date_des").val();
                            var to_date = $("#to_date_des").val();
                            var id =$("#filter_id").val();
                            if(from_date != '' && to_date != '')
                            {
                                $.ajax({
                                    url:"filter_des.php",
                                    method:"POST",
                                    data:{from_date:from_date, to_date:to_date, id:id},
                                    success:function(data)
                                    {
                                        $("#tbl_des").html(data);
                                    }

                                });
                            }
                            else
                            {
                                alert("Please Select Date!");
                            }
                        });
                        $('#filter_des_all').click(function(){
                            var id =$("#filter_id").val();
                            $.ajax({
                                url:"filter_des_all.php",
                                method:"POST",
                                data:{id:id},
                                success:function(data)
                                {
                                    $("#tbl_des").html(data);
                                }
                            });
                        });

                    });
                </script>
                <?php
                $query="SELECT * FROM job_status WHERE emp_id='$emp_id'";
                $result=mysqli_query($db, $query);
                $line=mysqli_fetch_array($result);
                echo "<b>Current Designation: </b>".$line['curr_designation']."<br><br>";
                $sql="SELECT * FROM history_designation  WHERE emp_id='$emp_id' ORDER BY `serial` DESC LIMIT 10";
                $res=mysqli_query($db, $sql);
                echo "<div id='tbl_des'>";
                echo "<table align='center' class='table table-striped table-bordered'> ";
                echo "<tr>";
                echo "<th width='150px'>Entrier</th>";
                echo "<th width='150px'>Entry Date</th>";
                //echo "<th width='150px'>From</th>";
                echo "<th width='150px'>To</th>";
                echo "<th width='150px'>Approval Date</th>";
                echo "<th width='150px'>Effective Date</th>";
                echo "<th width='150px'>Reference</th>";
                echo "<th width='150px'>Remarks</th>";
                echo "<th width='20px'>Edit</th>";
                echo "</tr>";
                while($row=mysqli_fetch_array($res))
                {
                    echo "<tr>";
                    if($row[2]=='10001')
                    {
                        echo "<td>Admin</td>";
                    }
                    else
                    {
                        $id=$row[2];
                        $sql ="SELECT * FROM employee WHERE ID='$id'";
                        $result=mysqli_query($db, $sql);
                        $line=mysqli_fetch_array($result);
                        echo "<td>".$line['First Name']." ".$line['Last Name']."</td>";
                    }
                    echo "<td>".date_format(date_create($row['entry_date']),"M d, Y")."</td>"; 

                    //echo "<td>".$row[4]."</td>";
                    echo "<td>".$row['to_des']."</td>";

                    echo "<td>".date_format(date_create($row['approval_date']),"M d, Y")."</td>";
                    echo "<td>".date_format(date_create($row['date']),"M d, Y")."</td>";
                    echo "<td>".$row['ref']."</td>";
                    echo "<td><pre>".$row['remarks']."</pre></td>";
                    echo "<td><a href='edit_remark_des.php?id=".$row['serial']."' class='glyphicon glyphicon-pencil'></a></td>";
                    echo "</tr>";
                }
                echo "</table></div>"; ?></div>
            <div id="tab5" class="tab-pane fade">
                <div class="col-sm-2">
                    <input type="text" name="from_date_emp" id="from_date_emp" class="form-control" placeholder="From Date">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="to_date_emp" id="to_date_emp" class="form-control" placeholder="To Date">
                </div>
                <div class="col-sm-5">
                    <input type="button" name="filter_emp" id="filter_emp" value="Filter" class="btn btn-sm btn-primary">

                    <input type="button" name="filter_emp_all" id="filter_emp_all" value="Show All" class="btn btn-sm btn-primary">
                </div>
                <br><br><br>
                <script>
                    $(document).ready(function(){
                        $.datepicker.setDefaults({
                            dateFormat: 'yy-mm-dd'
                        });
                        $(function(){
                            $("#from_date_emp").datepicker();
                            $("#to_date_emp").datepicker();
                        });
                        $('#filter_emp').click(function(){
                            var from_date = $("#from_date_emp").val();
                            var to_date = $("#to_date_emp").val();
                            var id =$("#filter_id").val();
                            if(from_date != '' && to_date != '')
                            {
                                $.ajax({
                                    url:"filter_emp.php",
                                    method:"POST",
                                    data:{from_date:from_date, to_date:to_date, id:id},
                                    success:function(data)
                                    {
                                        $("#tbl_emp").html(data);
                                    }

                                });
                            }
                            else
                            {
                                alert("Please Select Date!");
                            }
                        });
                        $('#filter_emp_all').click(function(){
                            var id =$("#filter_id").val();
                            $.ajax({
                                url:"filter_emp_all.php",
                                method:"POST",
                                data:{id:id},
                                success:function(data)
                                {
                                    $("#tbl_emp").html(data);
                                }
                            });
                        });

                    });
                </script>
                <?php
                $query="SELECT * FROM job_status WHERE emp_id='$emp_id'";
                $result=mysqli_query($db, $query);
                $line=mysqli_fetch_array($result);
                if($line['employment_type']=='Fired')
                {echo "<b>Current Employment Type: </b><font color='red'>".$line['employment_type']."</font><br><br>";
                }
                else 
                {
                    echo "<b>Current Employment Type: </b>".$line['employment_type']."<br><br>";
                }
                $sql="SELECT * FROM history_employment  WHERE emp_id='$emp_id' ORDER BY `serial` DESC LIMIT 10";
                $res=mysqli_query($db, $sql);
                echo "<div id='tbl_emp'>";
                echo "<table align='center' class='table table-striped table-bordered'> ";
                echo "<tr>";
                echo "<th width='150px'>Entrier</th>";
                echo "<th width='150px'>Entry Date</th>";
                echo "<th width='150px'>Type</th>";
                echo "<th width='150px'>Approval</th>";
                echo "<th width='150px'>Effective Date</th>";
                echo "<th width='150px'>Separation Date</th>";
                echo "<th width='150px'>Reference</th>";
                echo "<th width='150px'>Remarks</th>";
                echo "<th width='20px'>Edit</th>";
                echo "</tr>";
                while($row=mysqli_fetch_array($res))
                {
                    echo "<tr>";
                    if($row[3]=='10001')
                    {
                        echo "<td>Admin</td>";
                    }
                    else
                    {
                        $id=$row[3];
                        $sql ="SELECT * FROM employee WHERE ID='$id'";
                        $result=mysqli_query($db, $sql);
                        $line=mysqli_fetch_array($result);
                        echo "<td>".$line['First Name']." ".$line['Last Name']."</td>";
                    }
                    echo "<td>".date_format(date_create($row['entry_date']),"M d, Y")."</td>";
                    echo "<td>".$row['employment_type']."</td>";

                    echo "<td>".date_format(date_create($row['approval_date']),"M d, Y")."</td>";
                    echo "<td>".date_format(date_create($row['eff_date']),"M d, Y")."</td>";
                    echo "<td>".date_format(date_create($row['date']),"M d, Y")."</td>";
                    echo "<td>".$row['ref']."</td>";
                    echo "<td><pre>".$row['remarks']."</pre></td>";
                    echo "<td><a href='edit_remark_emp.php?id=".$row['serial']."' class='glyphicon glyphicon-pencil'></a></td>";
                    echo "</tr>";
                }
                echo "</table></div>"; ?>
            </div>
            <div id="tab7" class="tab-pane fade">
                <h5><b>Search By Effective Date: </b></h5>
                <div class="col-sm-2">
                    <input type="text" name="from_date_bon" id="from_date_bon" class="form-control" placeholder="From Date">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="to_date_bon" id="to_date_bon" class="form-control" placeholder="To Date">
                </div>
                <div class="col-sm-5">
                    <input type="button" name="filter_bon" id="filter_bon" value="Filter" class="btn btn-sm btn-primary">

                    <input type="button" name="filter_bon_all" id="filter_bon_all" value="Show All" class="btn btn-sm btn-primary">
                </div>
                <br><br><br>
                <script>
                    $(document).ready(function(){
                        $.datepicker.setDefaults({
                            dateFormat: 'yy-mm-dd'
                        });
                        $(function(){
                            $("#from_date_bon").datepicker();
                            $("#to_date_bon").datepicker();
                        });
                        $('#filter_bon').click(function(){
                            var from_date = $("#from_date_bon").val();
                            var to_date = $("#to_date_bon").val();
                            var id =$("#filter_id").val();
                            if(from_date != '' && to_date != '')
                            {
                                $.ajax({
                                    url:"filter_bon.php",
                                    method:"POST",
                                    data:{from_date:from_date, to_date:to_date, id:id},
                                    success:function(data)
                                    {
                                        $("#tbl_bon").html(data);
                                    }

                                });
                            }
                            else
                            {
                                alert("Please Select Date!");
                            }
                        });
                        $('#filter_bon_all').click(function(){
                            var id =$("#filter_id").val();
                            $.ajax({
                                url:"filter_bon_all.php",
                                method:"POST",
                                data:{id:id},
                                success:function(data)
                                {
                                    $("#tbl_bon").html(data);
                                }
                            });
                        });

                    });
                </script>
                <?php
                $sql="SELECT * FROM history_bonus WHERE emp_id='$emp_id' ORDER BY `serial` DESC LIMIT 10";
                $res=mysqli_query($db, $sql);
                echo "<div id='tbl_bon'>";
                echo "<table align='center' class='table table-striped table-bordered'>";
                echo "<tr>";
                echo "<th width='150px'>Entrier</th>";
                echo "<th width='150px'>Entry Date</th>";
                echo "<th width='150px'>Amount</th>";
                echo "<th width='150px'>Approval Date</th>";
                echo "<th width='150px'>Effective Date</th>";
                echo "<th width='150px'>Reference</th>";
                echo "<th width='150px'>Remarks</th>";
                echo "<th width='20px'>Edit</th>";
                echo "</tr>";
                while($row=mysqli_fetch_array($res))
                {
                    echo "<tr>";
                    if($row[2]=='10001')
                    {
                        echo "<td>Admin</td>";
                    }
                    else
                    {
                        $id=$row[2];
                        $sql ="SELECT * FROM employee WHERE ID='$id'";
                        $result=mysqli_query($db, $sql);
                        $line=mysqli_fetch_array($result);
                        echo "<td>".$line['First Name']." ".$line['Last Name']."</td>";
                    }

                    echo "<td>".date_format(date_create($row['entry_date']),"M d, Y")."</td>";
                    echo "<td>".$row['amount']."</td>";

                    echo "<td>".date_format(date_create($row['approval_date']),"M d, Y")."</td>";
                    echo "<td>".date_format(date_create($row['date']),"M d, Y")."</td>";
                    echo "<td>".$row['ref']."</td>";
                    echo "<td><pre>".$row['remarks']."</pre></td>";
                    echo "<td><a href='edit_remark_bon.php?id=".$row['serial']."' class='glyphicon glyphicon-pencil'></a></td>";
                    echo "</tr>";
                }
                echo "</table></div>"; ?></div>
            <div id="tab8" class="tab-pane fade">
                <h5><b>Search By Effective Date: </b></h5>
                <div class="col-sm-2">
                    <input type="text" name="from_date_fac" id="from_date_fac" class="form-control" placeholder="From Date">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="to_date_fac" id="to_date_fac" class="form-control" placeholder="To Date">
                </div>
                <div class="col-sm-5">
                    <input type="button" name="filter_fac" id="filter_fac" value="Filter" class="btn btn-sm btn-primary">

                    <input type="button" name="filter_fac_all" id="filter_fac_all" value="Show All" class="btn btn-sm btn-primary">
                </div>
                <br><br><br>
                <script>
                    $(document).ready(function(){
                        $.datepicker.setDefaults({
                            dateFormat: 'yy-mm-dd'
                        });
                        $(function(){
                            $("#from_date_fac").datepicker();
                            $("#to_date_fac").datepicker();
                        });
                        $('#filter_fac').click(function(){
                            var from_date = $("#from_date_fac").val();
                            var to_date = $("#to_date_fac").val();
                            var id =$("#filter_id").val();
                            if(from_date != '' && to_date != '')
                            {
                                $.ajax({
                                    url:"filter_fac.php",
                                    method:"POST",
                                    data:{from_date:from_date, to_date:to_date, id:id},
                                    success:function(data)
                                    {
                                        $("#tbl_fac").html(data);
                                    }

                                });
                            }
                            else
                            {
                                alert("Please Select Date!");
                            }
                        });
                        $('#filter_fac_all').click(function(){
                            var id =$("#filter_id").val();
                            $.ajax({
                                url:"filter_fac_all.php",
                                method:"POST",
                                data:{id:id},
                                success:function(data)
                                {
                                    $("#tbl_fac").html(data);
                                }
                            });
                        });

                    });
                </script>
                <?php
                $sql="SELECT * FROM history_facility WHERE emp_id='$emp_id' ORDER BY `serial` DESC";
                $res=mysqli_query($db, $sql);
                echo "<div id='tbl_fac'>";
                echo "<table align='center' class='table table-striped table-bordered'>";
                echo "<tr>";
                echo "<th width=''>Entrier</th>";
                echo "<th width='10%'>Entry Date</th>"; 
                echo "<th width='12%'>Type</th>"; 
                echo "<th width='24%'>Facility</th>";
                echo "<th width='24%'>Remarks</th>";
                echo "<th width='20%'>Reference</th>"; 
                echo "<th width='20px'>Edit</th>";
                echo "</tr>";
                while($row=mysqli_fetch_array($res))
                {
                    echo "<tr>";
                    if($row[2]=='10001')
                    {
                        echo "<td>Admin</td>";
                    }
                    else
                    {
                        $id=$row[2];
                        $sql ="SELECT * FROM employee WHERE ID='$id'";
                        $result=mysqli_query($db, $sql);
                        $line=mysqli_fetch_array($result);
                        echo "<td>".$line['First Name']." ".$line['Last Name']."</td>";
                    }

                    echo "<td>".date_format(date_create($row['entry_date']),"M d, Y")."</td>";


                    echo "<td>".$row['type']."</td>";
                    echo "<td><pre>".$row['facility']."</pre></td>";
                    echo "<td><pre>".$row['remarks']."</pre></td>";
                    echo "<td>".$row['ref']."</td>";

                    echo "<td><a href='edit_remark_fac.php?id=".$row['serial']."' class='glyphicon glyphicon-pencil'></a></td>";
                    echo "</tr>";
                }
                echo "</table></div>"; ?></div>
            <div id="tab9" class="tab-pane fade">

                <?php
                $sql="SELECT * FROM leave_types WHERE emp_id='$emp_id' ORDER BY `year` DESC";
                $result=mysqli_query($db, $sql);

                if($result->num_rows === 0)
                {
                    echo '<div class="alert alert-danger" align="center">
                        <strong>No history to display!!!</strong>
                        </div>';
                }
                else
                {

                    echo '<table width="100%" id="emp_table" class="table table-striped table-bordered">';
                ?>
                <tr>
                    <th width='150px'><center>Year</center></th>
                    <th width='150px'><center>Casual</center></th>
                    <th width='150px'><center>Sick</center></th>
                    <th width='150px'><center>Annual</center></th>
                    <th width='150px'><center>Parental</center></th>
                    <th width='150px'><center>Alternative</center></th>
                    <th width='150px'><center>Without Pay Leaves</center></th>

                </tr>

                <?php
                    echo '<tbody id="myTable">';

                    while($row=mysqli_fetch_array($result))
                    {

                        echo "<tr>";
                        echo "<td>".$row['year']."</td>";
                        echo "<td>".$row['casual']."</td>";
                        echo "<td>".$row['sick']."</td>";
                        echo "<td>".$row['annual']."</td>";
                        echo "<td>".$row['maternity']."</td>";

                        echo "<td>".$row['paternity']."</td>";
                        echo "<td>".$row['wpl']."</td>";

                        echo "</tr>";
                    }

                    echo '</table>';

                }

                ?>


            </div>
            <div id="tab6" class="tab-pane fade">

                <?php
                $sql="SELECT * FROM department_record WHERE history='$emp_id' ORDER BY `serial` DESC";

                $result=mysqli_query($db, $sql);

                if($result->num_rows === 0)
                {
                    echo '<div class="alert alert-danger" align="center">
                        <strong>No history to display!!!</strong>
                        </div>';
                }
                else
                {

                    echo '<table width="100%" id="emp_table" class="table table-striped table-bordered">';
                    echo '<thead>';
                    echo '<tr class="tr_header">';
                    echo '<th>Type</th>';
                    echo '<th>Department</th>';
                    echo '<th>Entrier</th>';
                    echo '<th>Entry Date</th>';
                    echo '<th>Approval Date</th>'; 
                    echo '<th>Effective Date</th>'; 
                    echo '</thead>';
                    echo '</tr>';
                    echo '<tbody id="myTable">';

                    while($row=mysqli_fetch_array($result))
                    {
                        $dir=$row['dep_id'];
                        $sql="SELECT * FROM department WHERE dep_id='$dir'";
                        $res=mysqli_query($db, $sql);
                        $data=mysqli_fetch_array($res);
                        echo "<tr>";
                        if($row['type']=='head')
                        {
                            echo "<td class='success'>Head Assignment</td>";


                        }
                        else if($row['type']=='reporter')
                        {
                            echo "<td class='warning'>Reporter Assignment</td>";


                        }
                        echo "<td>".$data['dep_name']."</td>";
                        if($row['entrier']=='10001')
                        {
                            echo "<td>Admin</td>"; 
                        }
                        else
                        {
                            $entry_id=$row['entrier'];
                            $query="SELECT * employee WHERE ID='$entry_id'";
                            $res_2=mysqli_query($db,$query);
                            $row_2=mysqli_fetch_array($res_2);
                            echo "<td>".$row_2['First Name']." ".$row_2['Last Name']."</td>";
                        }

                        echo "<td>".date_format(date_create($row['entry_date']),"d M, Y")."</td>"; 
                        echo "<td>".date_format(date_create($row['approval_date']),"d M, Y")."</td>"; 
                        echo "<td>".date_format(date_create($row['eff_date']),"d M, Y")."</td>"; 
                        echo "</tr>";
                    }

                    echo '</table>';

                }

                ?>


            </div>
        </div>
        </div>
    <?php include "html/footer.html"; ?>
    </body>
</html>
