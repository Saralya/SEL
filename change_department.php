<?php
session_start();
if(!($_SESSION['name']=='admin')){
    header("location:admin.php");
}
?>
<?php include 'connect.php';?>


<html>
    <head>
        <title>Change Department</title>
        <?php include 'html/bootstrap.html'; ?>   
    </head>

    <body>
        <?php include 'html/navbar.php'; ?> 
        <div class="container">
            <?php 
            if(isset($_POST['submit']))
            {
                date_default_timezone_set('Asia/Dhaka');
                $date = date('Y-m-d', time());
                $entrier=$_SESSION['id'];
                $emp=$_GET['id'];
                $eff_date=$_POST['eff_date'];
                $appr_date=$_POST['appr_date'];
                $new_dep=$_POST['department'];
                $sql="SELECT * FROM `job_status` WHERE emp_id='$emp'";
                $result=mysqli_query($db, $sql);
                $row=mysqli_fetch_array($result);
                $prev_dep=$row['curr_department'];
                $remarks=mysqli_real_escape_string($db,$_POST['remarks']);

                $ref = "REF-"; 
                $ref .= date("Ymd-his-", time());
                $ref .= rand(10,99);
                $ref .= "-".$_SESSION['id'];
                $ref .= "-".$emp;

                $sql="UPDATE `job_status` SET curr_department=".$new_dep.", prev_department=".$prev_dep.", transfer_date='$eff_date' WHERE emp_id='$emp'";
                mysqli_query($db, $sql);
                $sql="UPDATE `employee` SET department_id=".$new_dep." WHERE ID='$emp'";
                mysqli_query($db, $sql);
                $sql="INSERT INTO `history_department`(`emp_id`, `entrier_id`,`date`, `tos`, `from`,`remarks`,`entry_date`,`approval_date`,`ref`) VALUES ('$emp','$entrier','$eff_date','$new_dep','$prev_dep','$remarks','$date','$appr_date','$ref')";
                mysqli_query($db, $sql);
                $sql="SELECT * FROM department WHERE dep_id='$prev_dep'";
                $res=mysqli_query($db,$sql);
                $row=mysqli_fetch_array($res);
                $sql="SELECT * FROM department WHERE dep_id='$new_dep'";
                $res=mysqli_query($db,$sql);
                $row1=mysqli_fetch_array($res);
                $comment="You have been <font color=brown>Transfered</font> From `".$row['dep_name']."` To `".$row1['dep_name']."` (Effective Date: ".date_format(date_create($eff_date),"d-M-Y") . ").";
                $sql="INSERT INTO `notification`(`emp_id`, `type`, `date`, `comment`,`ref`) VALUES ('$emp','Transfer','$date','$comment','$ref')";
                mysqli_query($db,$sql);
                echo '<div class="alert alert-success" align="center">
            Department Changed Successfully!!!!
            </div>';

                if($_POST['inc']!=0)
                {
                    $sql="SELECT * FROM `job_status` WHERE emp_id='$emp'";
                    $result=mysqli_query($db, $sql);
                    $row=mysqli_fetch_array($result);
                    $salary=(int)$row['current_gross'];
                    $increment=(int)$_POST['inc'];
                    $salary_inc=$salary+$increment;


                    $sql="UPDATE `job_status` SET last_inc=".$increment.", current_gross=".$salary_inc.", last_inc_date='$date' WHERE emp_id='$emp'";
                    mysqli_query($db, $sql);
                    $sql="INSERT INTO `history_salary`(`emp_id`, `entrier_id`,`date`, `amount`,`remarks`,`entry_date`,`approval_date`,`ref`) VALUES ('$emp','$entrier','$eff_date','$increment','$remarks','$date','$appr_date','$ref')";
                    mysqli_query($db, $sql);
                    $comment="Your Salary has been Incremented Taka ".$increment." (Effective Date: ".date_format(date_create($eff_date),"d-M-Y") . ").";
                    $sql="INSERT INTO `notification`(`emp_id`, `type`, `date`, `comment`,`ref`) VALUES ('$emp','Increment','$date','$comment','$ref')";
                    mysqli_query($db,$sql);
                    echo '<div class="alert alert-success" align="center">
               Salary incremented Successfully!!!!
               </div>'; 

                }  
                else {

                } 
                //sleep(5);
                //redirect("history.php?id=$emp");
            }
            ?>

            <?php 
            $emp=$_GET['id'];
            $sql="SELECT * FROM `employee` WHERE ID='$emp'";
            $result=mysqli_query($db, $sql);
            $row=mysqli_fetch_array($result);
            $name=$row['First Name']." ".$row['Last Name'];
            $image=$row['image'];
            $dep_id=$row['department_id'];
            $sql="SELECT * FROM `department` WHERE dep_id='$dep_id'";
            $result=mysqli_query($db, $sql);
            $row=mysqli_fetch_array($result);
            $dep=$row['dep_name'];
            echo "<img src='".$image."' height='50px' width='50px' class='img-rounded'>"." <a href='history.php?id=$emp'><big>".$name."</big></a><br><br>"; 
            echo "<b>Current Department: </b>".$dep."<br>";
            echo "<br>";
            ?>
            <?php

            ?>
            <?php
            if(!isset($_POST['submit']))
            {


            ?>


            <form action="" method="post">

                New Department:<br> 
                <?php 
                echo "<select name='department' class='form-control' required style='width:400px'>";
                echo "<option value=''>----------------</option>";
                //echo '<option value="" selected disabled hidden>Choose here</option>';
                $sql = "SELECT * FROM `department` ORDER BY `dep_name`";
                $result=mysqli_query($db, $sql);
                //echo "<option>Head</option>";
                while ($row = mysqli_fetch_assoc($result)) {

                    echo "<option value='" . $row['dep_id'] ."'>" . $row['dep_name']."</option>";

                }
                echo "</select><br>";
                ?>
                Remarks<textarea type="text" name="remarks" class='form-control' style='width:700px; height:80px' required="required"></textarea><br>
                Approval Date: <input type='date' name='appr_date' class="form-control" style='width:300px' required><br>
                Effective Date: <input type='date' name='eff_date' class="form-control" style='width:300px' required><br>
                <hr><hr>

                <b>Increase Salary(If Necessary)</b><br>
                Amount(Taka): <input name='inc' value="0" type='number' class="form-control" style='width:200px'><br>
                <input type='submit' class='btn btn-primary' name='submit' value='Submit'><br>
            </form>




            <?php
            }

            ?>
        </div></body>

</html>
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