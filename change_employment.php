<?php
session_start();
if(!($_SESSION['name']=='admin')){
    header("location:admin.php");
}
?>
<?php include 'connect.php';?>


<html>
<head>
    <?php include 'html/bootstrap.html'; ?> 
    <title>Change Employment</title>  
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
            $separation_date=$_POST['separation_date'];
            $curr_employ=mysqli_real_escape_string($db,$_POST['employment_type']);
            $sql="SELECT * FROM `job_status` WHERE emp_id='$emp'";
            $result=mysqli_query($db, $sql);
            $row=mysqli_fetch_array($result);
            $prev_employ=$row['employment_type'];
            $remarks=mysqli_real_escape_string($db,$_POST['remarks']);

            $ref = "REF-";
            $ref .= date("Ymd-his-", time());
            $ref .= rand(10,99);
            $ref .= "-".$_SESSION['id'];
            $ref .= "-".$emp;

            $sql="UPDATE `job_status` SET employment_type='$curr_employ',employee_separation_date='$separation_date' WHERE emp_id='$emp'";
            mysqli_query($db, $sql);
            $sql="INSERT INTO `history_employment`(`emp_id`, `employment_type`, `entrier`,`entry_date`, `remarks`,`date`,`approval_date`,`eff_date`,`ref`) VALUES ('$emp','$curr_employ','$entrier','$date','$remarks','$separation_date','$appr_date','$eff_date','$ref')";
            mysqli_query($db, $sql);
            $comment="Your Employment Type has been Changed to `".$curr_employ."` Till ".date_format(date_create($separation_date),'d M, Y');
            $sql="INSERT INTO `notification`(`emp_id`, `type`, `date`, `comment`,`ref`) VALUES ('$emp','Employment','$date','$comment','$ref')";
            mysqli_query($db,$sql);
            echo '<div class="alert alert-success" align="center">
            Employment Type Changed Successfully!!!!
            </div>'; 

            if($_POST['inc']!=0) {
                
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
       }
       ?>




       <?php 
       $emp=$_GET['id'];
       $sql="SELECT * FROM `employee` WHERE ID='$emp'";
       $result=mysqli_query($db, $sql);
       $row=mysqli_fetch_array($result);
       $name=$row['First Name']." ".$row['Last Name'];
       $image=$row['image'];
       $sql="SELECT * FROM `job_status` WHERE emp_id='$emp'";
       $result=mysqli_query($db, $sql);
       $row=mysqli_fetch_array($result);
       $employment=$row['employment_type'];
       echo "<img src='".$image."' height='50px' width='50px' class='img-rounded'>"." <a href='history.php?id=$emp'><big>".$name."</big></a><br><br>"; 
       echo "<b>Current Employment: </b>".$employment;
       echo "<br><b>Separation Date: </b>".date_format(date_create($row['employee_separation_date']),'M d, Y');
       echo "<br><br>";
       ?>

       <?php
       if (!isset($_POST['submit']))
       {
        ?>
        <form action="" method="post">
            <div class="form-group">Employment Type:  
                <select name="employment_type"  class="form-control" style="width:500px" required>
                    <option value="<?php echo $employment?>" selected><?php echo $employment?></option>
                    <option value="Regular">Regular</option>
                    <option value="Contractual">Contractual</option>
                    <option value="On Probation">On Probation</option>
                    <option value="Part Time">Part Time</option>
                    <option value="Intern">Intern</option>
                </select></div>
                Remarks<textarea name="remarks" class='form-control' style='width:700px; height:80px' required="required"></textarea><br>
                Approval Date: <input type='date' name='appr_date' class="form-control" style='width:300px' required><br>
                Effective Date: <input type='date' name='eff_date' class="form-control" style='width:300px' required><br>
                Separation Date: <input type='date' name='separation_date' class="form-control" style='width:300px' required><br>
                <hr><hr>
                <b>Increase Salary(If Necessary)</b><br>
                Amount(Taka): <input name='inc' value="0" type='number' class="form-control" style='width:200px'><br>
                <input type='submit' class="btn btn-primary" name='submit' value='Submit'><br>
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