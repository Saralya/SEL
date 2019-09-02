<?php
session_start();
if(!$_SESSION['name']){
    header("location:admin.php");
}
if(!isset($_GET['ID'])){
    header("location:index.php");
}
include('connect.php');
$ID = $_GET['ID'];
$sql = "SELECT * FROM employee WHERE `ID`='$ID'";
$res = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($res);
$fname = $row['First Name'];
$lname = $row['Last Name'];

$sql1 = "SELECT * FROM address WHERE `emp_id`='$ID'";
$res1 = mysqli_query($db, $sql1);
$row1 = mysqli_fetch_assoc($res1);
$vill = $row1['pre_village'];
$post_office = $row1['pre_post_office'];
$thana = $row1['pre_thana'];
$district = $row1['pre_district'];

$sql2 = "SELECT * FROM job_status WHERE `emp_id`='$ID'";
$res2 = mysqli_query($db, $sql2);
$row2 = mysqli_fetch_assoc($res2);
$des = $row2['curr_designation'];
$pro = $row2['probation_period'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Appointment Letter</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include "html/bootstrap.html" ?>
    </head>
    <body>
        <?php include "html/navbar.php" ?>
        <?php //include "html/navbar.html" ?>
        <div class="container">
<div class="row">
<form role="form" action="appointment_letter.php" method="post" enctype="multipart/form-data">
<h3 style="color:#00BFFF">Appointment Letter</h3>
<div class="form-group">
<div class="form-group">S/O Name:  <input type="text" name="so_name" class="form-control" style="width:500px" onkeyup="showUser(this.value)" required><div id="search"></div></div>
<div class="form-group">Appointee Name:  <input type="text" name="app_name"  class="form-control" style="width:500px" placeholder='<?php echo $fname.' '.$lname ?>'></div>
    <div class="form-group"><b>Appointee Address: </b></div>
<div class="form-group">Address: <input type="text" name="add"  placeholder="<?php echo $vill.' '.$post_office ?>">
Thana: <input type="text" name="thana" placeholder='<?php echo $thana ?>'>
District: <input type="text" name="district" placeholder="<?php echo $district ?>" ></div>
<div class="form-group">Appointee Designation:  <input type="text" name="desig"  class="form-control" style="width:500px"  placeholder='<?php echo $des ?>'></div>
<div class="form-group">Reporter Name:  <input type="text" name="re_name"  class="form-control" style="width:500px"  required></div>
<div class="form-group">Reporter Designation:  <input type="text" name="re_desig"  class="form-control" style="width:500px"  required></div>
<div class="form-group"><b>Salary and Allowance: </b></div>
<div class="form-group">Basic: <input type="text" name="basic" required>
House rent: <input type="text" name="house" required>
Medical: <input type="text" name="medical" required>
Conveyance Allowance: <input type="text" name="allow" required><br><br>
Entertainment: <input type="text" name="enter" required>
Others: <input type="text" name="others" required></div>
<div class="form-group">Probation Period:  <input type="text" name="pro"  class="form-control" style="width:500px" placeholder='<?php echo $pro ?>' ></div>
    <button type="submit" name="submit" value="<?php echo $ID ?>" class="btn btn-info btn-lg">Submit</button>

    </div>
            </form>
            </div>
        </div>
    </body>
</html>
