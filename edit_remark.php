<?php
session_start();
if(!($_SESSION['id']=='10001')){
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



<html lang="en">
    <head>
        <title>Edit Remarks</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php include 'html/navbar.php'; ?>
        <div class="container" style="">
            <?php
            date_default_timezone_set('Asia/Dhaka');
            $today = date('Y-m-d', time());
            $id=$_GET['id'];
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

            $query="SELECT * FROM leaves WHERE LeaveID='$id'";
            $result=mysqli_query($db,$query);
            $data=mysqli_fetch_array($result);
            $emp_id=$data['EmployeeID'];
            $old_rem=$data['remarks'];
            $old_joining_date=$data['joining_date'];
            $from_date=date_format(date_create($data['From Date']),'M d, Y');
            $to_date=date_format(date_create($data['To Date']),'M d, Y');
            if(date_create($data['From Date'])>date_create($data['To Date']))
            {
                $to_date="No Leaves";
            }

            $query="SELECT * FROM employee WHERE ID='$emp_id'";
            $result=mysqli_query($db,$query);
            $data_2=mysqli_fetch_array($result);
            $name=$data_2['First Name']." ".$data_2['Last Name'];
            $image=$data_2['image'];
            $email=$data_2['Email'];
            $msg=" ";
            //---------------------------------------------
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
            $mail->Subject='Edit Joining Date';
            $mail->Body=$msg;
            if(isset($_POST['sub_rem']))
            {
                $remark = mysqli_real_escape_string($db,$_POST['edit_remark']);
                $remark .= "
(Updated By: ".$updater_name.", ";
                $remark .= "Time: ".date("M d, Y h:i:s a", time()).")";
                $remark = $remark."
-----------
".$old_rem;
                $old_rem=$remark;

                $joining_date=$_POST['joining'];
                if($joining_date!="")
                {
                    if($joining_date==$old_joining_date)
                    {
                        echo '<div class="alert alert-danger" align="center">
                    Same Joining Date not Allowed!!
                    </div>'; 
                    }
                    else 
                    {
                        //if joining date is bigger, then extra days will be counted as late and added to exisiting late whether it was 0 or else
                        //--------------------------
                        if(date_create($joining_date)>date_create($old_joining_date))
                        {
                            $diff = date_diff(date_create($joining_date), date_create($old_joining_date));
                            $a = $diff->days;
                            $a = (int) $a;
                            $a=(int)$data['late']+$a;
                            //echo $a;
                            $sql="UPDATE leaves SET late='$a',joining_date='$joining_date', remarks='$remark' WHERE LeaveID='$id'";
                            mysqli_query($db,$sql);
                            $msg="Hello ".$name. ", Your Head/Reporter has sent a feedback regarding to your leave from ".$from_date." to ".$to_date." as follows:<br><br>Updated Joining Date: ".date_format(date_create($joining_date),'M d, Y')."<br>Late: ".$a." Day(s)<br>Updated Remarks: ".$remark." <br><br>Please Check Your Leave History!!" ;

                        }
                        //if joining date is less, then we have to think there was late or not
                        //---------------
                        else 
                        {
                            if($data['late']==0)
                            {
                                $day_before = date( 'Y-m-d', strtotime( $joining_date . ' -1 day' ) );
                                $diff = date_diff(date_create($joining_date), date_create($data['From Date']));
                                $a = $diff->days;
                                $a = (int) $a;   
                                $sql="UPDATE leaves SET days='$a',`To Date`='$day_before',joining_date='$joining_date', remarks='$remark' WHERE LeaveID='$id'";
                                mysqli_query($db,$sql);
                                $msg="Hello ".$name. ", Your Head/Reporter has sent a feedback regarding to your leave from ".$from_date." to ".$to_date." as follows:<br><br> Updated Joining Date: ".date_format(date_create($joining_date),'M d, Y')."<br>Updated Remarks: ".$remark." <br><br>Please Check Your Leave History!!" ;

                            }
                            //she jei date ta dicche oita late er moddhe portese kina
                            else
                            {
                                //late er moddhe portese
                                if(date_create($joining_date)>date_create($data['To Date']))
                                {
                                    $diff = date_diff(date_create($joining_date), date_create($data['To Date']));
                                    $a = $diff->days;
                                    $a = (int) $a;  
                                    $a--; //karon to date ta late e count hobe na

                                    $sql="UPDATE leaves SET late='$a',joining_date='$joining_date', remarks='$remark' WHERE LeaveID='$id'";
                                    mysqli_query($db,$sql);
                                    $msg="Hello ".$name. ", Your Head/Reporter has sent a feedback regarding to your leave from ".$from_date." to ".$to_date." as follows:<br><br>Updated Joining Date: ".date_format(date_create($joining_date),'M d, Y')."<br>Late: ".$a." Day(s)<br>Updated Remarks: ".$remark." <br><br>Please Check Your Leave History!!" ;
                                }

                                else
                                {

                                    $day_before = date( 'Y-m-d', strtotime( $joining_date . ' -1 day' ) );
                                    $diff = date_diff(date_create($joining_date), date_create($data['From Date']));
                                    $a = $diff->days;
                                    $a = (int) $a; 
                                    $late=0;
                                    $sql="UPDATE leaves SET days='$a',late='$late',`To Date`='$day_before',joining_date='$joining_date', remarks='$remark' WHERE LeaveID='$id'";
                                    mysqli_query($db,$sql);
                                    $msg="Hello ".$name. ", Your Head/Reporter has sent a feedback regarding to your leave from ".$from_date." to ".$to_date." as follows:<br><br>Updated Joining Date: ".date_format(date_create($joining_date),'M d, Y')."<br>Late: ".$late." Day(s)<br>Updated Remarks: ".$remark." <br><br>Please Check Your Leave History!!" ;
                                }
                            }
                        }
                        echo '<div class="alert alert-success" align="center">
                        Successfylly Changed Remarks and Joining Date!
                        </div>';
                        $mail->Body=$msg;
                        if(!$mail->send())
                        {
                            echo "Mailer Error: " . $mail->ErrorInfo;
                            echo '<div class="alert alert-danger" align="center">
                            Mail Sending Failed to Employee!
                            </div>';
                        }
                        else
                        {
                            echo '<div class="alert alert-success" align="center">
                            Mail Sent to Employee!
                            </div>';
                        }
                    }
                }
                else
                {
                    $sql="UPDATE leaves SET remarks='$remark' WHERE LeaveID='$id'";
                    mysqli_query($db,$sql);
                    $msg="Hello ".$name. ", Your Head/Reporter has sent a feedback regarding to your leave from ".$from_date." to ".$to_date." as follows:<br><br><b>Joining Date Unchanged</b><br><br>Updated Remarks: ".$remark." <br><br>Please Check Your Leave History!!" ;
                    echo '<div class="alert alert-success" align="center">
                    Successfylly Changed Remarks!
                    </div>';
                    $mail->Body=$msg;
                    if(!$mail->send())
                    {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                        echo '<div class="alert alert-danger" align="center">
                        Mail Sending Failed to Employee!
                        </div>';
                    }
                    else
                    {
                        echo '<div class="alert alert-success" align="center">
                        Mail Sent to Employee!
                        </div>';
                    }
                }
            }

            else {
            ?>

            <h3>Edit Remarks and Joining Date</h3>
            <?php echo "<img src='".$image."' height='50px' width='50px' class='img-rounded'>"." <a href='history.php?id=$emp_id'><big>".$name."</big></a><br>"; ?>
            <br>
            <form method="post" action="">
                <b>Remarks:</b><textarea class="form-control" name="old_rem" disabled="disabled" style="height:150px" ><?php echo $old_rem; ?></textarea><br>
                <!--<input type="checkbox" name="billingtoo" onclick="FillBilling(this.form)">
<em>Check this box if Remarks are same.</em><br><br> -->

                Update (If necessary)<textarea class="form-control" name="edit_remark" style="height:150px" required></textarea><br>
                <b>From: </b><?php echo date_format(date_create($data['From Date']),'M d, Y'); ?><br>
                <b>To: </b>
                <?php 
                if(date_create($data['To Date'])<date_create($data['From Date']))
                {
                    echo "No Leaves";
                }

                else
                    echo date_format(date_create($data['To Date']),'M d, Y'); ?><br>
                <b>Day(s): </b><?php echo $data['days']; ?><br>
                <b>Late: </b><?php echo $data['late']; ?><br>
                <br> <b>Current Joining Date: </b> 
                <?php echo date_format(date_create($old_joining_date),'M d, Y'); ?><br><br>
                Update (If necessary)<input type="date" class="form-control" name="joining" style="width:200px" min="<?php echo $data['From Date'];?>"><br>
                <input type="submit" value="Confirm" class="btn btn-success" name="sub_rem">  
                <a href="history.php?id=<?php echo $emp_id; ?>" class="btn btn-default">Cancel </a>

                <script>
                    function FillBilling(f) {
                        if(f.billingtoo.checked == true) {
                            f.edit_remark = f.old_remark;         
                        }
                    }
                </script>
            </form>
            <?php
            }
            ?>
        </div>
    </body>
</html>

<?php
mysqli_close($db);
?>
