<?php
session_start();
if(!($_SESSION['name']=='admin')){
    header("location:admin.php");
}
?>
<?php include 'connect.php';?>


<html>
<head>
    <title>Change Designation</title>
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
        $eff_date=$_POST['eff_date'];
        $appr_date=$_POST['appr_date'];
        $entrier=$_SESSION['id'];
        $emp=$_GET['id'];
        $new_des=mysqli_real_escape_string($db,$_POST['designation']);
        $sql="SELECT * FROM `job_status` WHERE emp_id='$emp'";
        $result=mysqli_query($db, $sql);
        $row=mysqli_fetch_array($result);
        $prev_des=$row['curr_designation'];
        $remarks=mysqli_real_escape_string($db,$_POST['remarks']);


        $ref = "REF-";
        $ref .= date("Ymd-his-", time());
        $ref .= rand(10,99);
        $ref .= "-".$_SESSION['id'];
        $ref .= "-".$emp;

        $sql="UPDATE `job_status` SET curr_designation='$new_des', prev_designation='$prev_des', promo_date='$eff_date' WHERE emp_id='$emp'";
        mysqli_query($db, $sql);

        $sql="INSERT INTO `history_designation`(`emp_id`, `entrier_id`, `from`, `to_des`, `date`, `approval_date`, `remarks`, `entry_date`,`ref`) VALUES ('$emp','$entrier','$prev_des','$new_des','$eff_date','$appr_date','$remarks','$date','$ref')";
        mysqli_query($db, $sql);
        $comment="You have been <font color=blue>Promoted</font> From `".$prev_des."` To `".$new_des."` (Effective Date: ".date_format(date_create($eff_date),"d-M-Y") . ").";
        $sql="INSERT INTO `notification`(`emp_id`, `type`, `date`, `comment`,`ref`) VALUES ('$emp','Promotion','$date','$comment','$ref')";
        mysqli_query($db,$sql);
        echo '<div class="alert alert-success" align="center">
        Designation Changed Successfully!!!!
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
 $designation=$row['curr_designation'];
 echo "<img src='".$image."' height='50px' width='50px' class='img-rounded'>"." <a href='history.php?id=$emp'><big>".$name."</big></a><br><br>"; 
 echo "<b>Current Designation: </b>".$designation;
 echo "<br>";
 ?>
 <?php
 if(!isset($_POST['submit']))
 {
    ?>
    <form action="" method="post">
        New Designation:
        <div class="form-group">  
         <div class="form-group">
            <select name="designation"  class="form-control" style="width:500px" required>
                <option value="">------------</option>
                <?php
                $sql="SELECT DISTINCT designations FROM designation ORDER BY designations";
                $res=mysqli_query($db, $sql);
                while($row=mysqli_fetch_array($res))
                {
                    echo "<option value='".$row['designations']."'>".$row['designations']."</option>";
                }
                ?>
            </select></div>
            Remarks<textarea type="text" name="remarks" class='form-control' style='width:700px; height:80px' required="required"></textarea><br>
            Approval Date: <input type='date' name='appr_date' class="form-control" style='width:300px' required><br>
            Effective Date: <input type='date' name='eff_date' class="form-control" style='width:300px' required><br>
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