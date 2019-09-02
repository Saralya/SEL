<?php
session_start();
if(!($_SESSION['id']=='10001'||$_SESSION['head']=='Yes'||$_SESSION['reporter']=='Yes')){
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
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

    </head>
    <body><?php include 'html/navbar.php'; ?>
        <div class="container">



            <?php
            $id=$_GET['id'];
            $sql="SELECT * FROM history_fire WHERE emp_id='$id'";
            $res=mysqli_query($db,$sql);

            if($res->num_rows!=0)
            {
                echo '<div class="alert alert-danger" align="center">
        He is already Fired!!
        </div>';

            }
            else
            {


                if(isset($_POST['keep']))
                {
                    redirect("jobdetails.php?id=".$_GET['id']); 

                }
                if(isset($_POST['fire']))
                {
                    date_default_timezone_set('Asia/Dhaka');
                    $date = date('Y-m-d', time());
                    $app_date=$_POST['app_date'];
                    $eff_date=$_POST['eff_date'];
                    $entry_date=$date;
                    $remarks=mysqli_real_escape_string($db,$_POST['remarks']);
                    $reason=mysqli_real_escape_string($db,$_POST['reason']);
                    $entrier=$_SESSION['id'];

                    $ref = "REF-"; 
                    $ref .= date("Ymd-his-", time());
                    $ref .= rand(10,99);
                    $ref .= "-".$_SESSION['id'];
                    $ref .= "-".$id;

                    $query ="INSERT INTO `history_fire`(`emp_id`, `reason`, `entry_date`, `entrier`, `eff_date`, `approval_date`, `remarks`,`ref`) VALUES ('$id','$reason','$entry_date','$entrier','$eff_date','$app_date','$remarks','$ref')";
                    mysqli_query($db, $query);

                    $query ="UPDATE `job_status` SET fired='Yes' WHERE emp_id='$id'";
                    mysqli_query($db, $query);

                    $query="UPDATE `employee` SET department_id='000' WHERE ID='$id'";
                    mysqli_query($db, $query);


                    echo '<div class="alert alert-success" align="center">
           Employee Fired Successfully!!
           </div>';


                }
                else
                {  


                    $sql="SELECT * FROM department WHERE head_id='$id' OR reporter_id='$id'";
                    $res=mysqli_query($db,$sql);
                    if($res->num_rows!=0)
                    {
                        echo '<div class="alert alert-danger" align="center">
            <strong>Warning!!!</strong> He is a Head/Reporter!! Can not Fire.
            </div>';
                    }

                    else
                    {
                        $sql="SELECT * FROM employee WHERE ID='$id' AND department_id='101'";
                        $res=mysqli_query($db,$sql);
                        if($res->num_rows===0)
                        {
                            echo '<div class="alert alert-danger" align="center">
                <strong>Warning!!!</strong> He is not in Head Office!! Can not Fire. Transfer him to Head Office. Then Try Again!
                </div>';
                        }

                        else
                        {
                            $h_r=$_SESSION['id'];
                            $sql="SELECT * FROM department WHERE dep_id='101' AND (head_id='$h_r' OR reporter_id='$h_r')";
                            $row=mysqli_query($db,$sql);
                            if($row->num_rows==0&&$_SESSION['name']!='admin')
                            {
                                redirect("index.php");
                            }

            ?>


            <div class="alert alert-danger" align="center">
                <strong>Are you Sure you want to Fire this Employee???</strong><br><br>
                <form action="" method="post">
                    Approval Date: <input type="date" class="form-control" name="app_date" style="width:150px" required="required"><br>
                    Effective Date: <input type="date" class="form-control" name="eff_date" style="width:150px" required="required"><br>
                    Reason:
                    <select name="reason" class="form-control" style="width: 150px" required="required">
                        <option value="">------</option>
                        <option value="Contract Expired">Contract Expired</option>
                        <option value="Release">Release</option>
                        <option value="Resignation">Resignation</option>
                        <option value="Termination">Termination</option>
                        <option value="Dismissed">Dismissed</option>
                        <option value="Left Without Info.">Left Without Info.</option>
                    </select>
                    Remarks: <textarea type="text" class="form-control" name="remarks" style="width:400px" required="required"></textarea><br>
                    <input class="btn btn-info btn-sm" type="submit" value="Yes" name="fire">
                    <input class="btn btn-info btn-sm" type="submit" value="No" name="keep">
                </form>
            </div>

            <?php
                        }
                    }
                }
            }
            ?>


        </div>
    </body>



</html>