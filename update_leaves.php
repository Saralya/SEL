<?php
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php include "connect.php"; ?>
<?php //include "html/navbar.html"; ?>
<?php include "html/bootstrap.html" ?>
<html>
    <head> 
        <title>Leave Update</title>    
    </head>
    <body>
        <?php include "html/navbar.php" ?>
        <div class='container'>

            <?php 
    $emp=$_GET['id'];
date_default_timezone_set('Asia/Dhaka');
$leave_year = date('Y', time());
$sql = "SELECT * FROM `leave_types` WHERE emp_id='$emp' AND `year`='$leave_year'";
$result = mysqli_query($db ,$sql);
$row = mysqli_fetch_array($result);
            ?>
            <h3 style="color:#00BFFF">Allocated Leaves:</h3><br><br>
            <form method="post" action="update_leaves_process.php?id=<?php echo $emp; ?>">  
                <div class="form-group"> Casual: <input type="number" class="form-control" style="width:300px" name="casual" value="<?php echo $row['casual']; ?>" min="0" step="1"></div>
                <div class="form-group"> Annual: <input type="number" class="form-control" style="width:300px" name="annual" value="<?php echo $row['annual']; ?>" min="0" step="1"></div>
                <div class="form-group"> Sick: <input type="number" class="form-control" style="width:300px" name="sick" value="<?php echo $row['sick']; ?>" min="0" step="1"></div>
                <div class="form-group"> Parental: <input type="number" class="form-control" style="width:300px" name="maternity" value="<?php echo $row['maternity']; ?>" min="0" step="1"></div>
                <div class="form-group"> Alternative: <input type="number" class="form-control" style="width:300px" name="paternity" value="<?php echo $row['paternity']; ?>" min="0" step="1"></div>
                <div class="form-group"> Without Pay Leaves: <input type="number"  class="form-control" style="width:300px"name="wpl" value="<?php echo $row['wpl']; ?>" min="0" step="1"></div>
                <button type="submit" name="submit" value="Confirm" class="btn btn-info">Confirm</button>
            </form>
        </div>
    </body>
</html>
