<?php
session_start();
if(!($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')){
    header("location:admin.php");
}
if(!isset($_GET['ID'])){
 //   header("location:index.php");
}
$ID = $_GET['ID'];
?>
<?php include "connect.php"; ?>
<!DOCTYPE html>

<?php include "html/bootstrap.html"; ?> 
<html lang="en">
    <head>
        <title>Employee Form</title>
        <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
        <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="js/employee_form.js"></script>
        <style>
            article, aside, figure, footer, header, hgroup, 
            menu, nav, section { display: block; } </style>
        <link rel="stylesheet" href="Style/employee_form.css">
    </head>
        <?php include "html/navbar.php" ?>
        <div class="container">
            <div class="row">
                <div style="position:relative;left:525px;width:300px;">
                <!-- <a href="appointment_letter.php?ID=<?php echo $ID ?>" class="list-group-item list-group-item-success">Print Appointment Letter</a> --> </div>
                <?php 
                    if($_SESSION['name']=='admin')
                       echo '<div style="position:relative;left:525px;width:300px;"><a href="department_list.php" class="list-group-item list-group-item-warning">Department List</a></div>';
                  else if($_SESSION['name']=='data entry')
                      echo '<div style="position:relative;left:525px;width:300px;"><a href="index.php" class="list-group-item list-group-item-warning">Go back</a></div>';
                    ?>
            </div>
    </div>
    
    <body>
        
    </body>