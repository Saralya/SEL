<?php
session_start();
if(!($_SESSION['name']=='admin')){
    header("location:admin.php");
}
?>
<?php include 'connect.php';?>


<html>
<head>
    <title>Salary Increment</title>
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
            $increment=(int)$_POST['inc'];
            $sql="SELECT * FROM `job_status` WHERE emp_id='$emp'";
            $result=mysqli_query($db, $sql);
            $row=mysqli_fetch_array($result);
            $salary=(int)$row['current_gross'];
            $salary_inc=$salary+$increment;
            $remarks=mysqli_real_escape_string($db,$_POST['remarks']);

            $ref = "REF-";
            $ref .= date("Ymd-his-", time());
            $ref .= rand(10,99);
            $ref .= "-".$_SESSION['id'];
            $ref .= "-".$emp;

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
        $salary=$row['current_gross'];
        echo "<img src='".$image."' height='50px' width='50px' class='img-rounded'>"." <a href='history.php?id=$emp'><big>".$name."</big></a><br><br>"; 
        echo "<b>Current Salary(BDT): </b>".$salary;
        echo "<br>";
        ?>
        <?php 
        if(!isset($_POST['submit']))
        {

            ?>
            <form action="" method="post">
                Increment Amount(Taka): <input name='inc' type='number' class="form-control" style='width:200px' required><br><br>
                Remarks<textarea name="remarks" class='form-control' style='width:700px; height:80px' required></textarea><br>
                Approval Date: <input type='date' name='appr_date' class="form-control" style="width: 300px" required><br>
                Effective Date: <input type='date' name='eff_date' class="form-control" style='width:300px' required><br>
                <input type='submit' name='submit' value='Submit' class="btn btn-primary"><br>
            </form>
            <?php

        }
        ?>
    </div>
</body>

</html>