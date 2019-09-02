<?php
session_start();
if(!$_SESSION['name']){
    header("location:admin.php");
}
if(!isset($_GET['ID'])){
    header("location:index.php");
}
$ID = $_GET['ID'];
?>
<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include "html/bootstrap.html" ?>
    </head>
    <body>
        <?php include "html/navbar.php" ?>
        <?php //include "html/navbar.html" ?> 
        <div style="text-align:center;color:blue;"><div class="list-group-item list-group-item-info">Employee Added Successfully!</div></div><br><br><br>
        <div style="position:relative;left:525px;width:300px;"><a href='appointment_letter_input.php?ID=<?php echo $ID ?>' class="list-group-item list-group-item-success">Print Appointment Letter</a></div>
        <div style="position:relative;left:525px;width:300px;"><a href="employee_list.php" class="list-group-item list-group-item-warning">View Employee List</a></div>
    </body>
</html>
