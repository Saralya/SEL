<?php
session_start();
if(!$_SESSION['name']){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php include 'remove_empty_field.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include "html/bootstrap.html" ?>
        <style>
            div.a {
                position:relative;
                left:517px;
                width:300px;
                
            }
        </style>
    </head>
    <body>
        <?php include "html/navbar.php" ?>
        <?php //include "html/navbar.html" ?>
        <br><h3 style="color:#00BFFF; text-align:center">Print Letters</h3><br>  
        <div class='a'>
        <div class="list-group">
            <a href="appointment_letter_input.php" class="list-group-item list-group-item-success">Appointment Letter</a>
            <a href="#" class="list-group-item list-group-item-info">Employee Profile Format</a>
            <a href="#" class="list-group-item list-group-item-warning">Extension of Probation Period</a>
            <a href="#" class="list-group-item list-group-item-danger">Final Payment Sheet</a>
            <a href="#" class="list-group-item list-group-item-success">Letter of Confirmation (With Salary Increase)</a>
            <a href="#" class="list-group-item list-group-item-info">Letter of Confirmation</a>
            <a href="#" class="list-group-item list-group-item-warning">Letter of Promotion (With Salary Increase)</a>
            <a href="#" class="list-group-item list-group-item-danger">Letter of Promotion</a>
            <a href="#" class="list-group-item list-group-item-success">Letter of Yearly Salary Increment</a>
            <a href="#" class="list-group-item list-group-item-info">Performance Appraisal Form_PAF (Managerial)</a>
            <a href="#" class="list-group-item list-group-item-warning">Performance Appraisal Form_PAF (Non-Managerial).pdf</a>
            <a href="#" class="list-group-item list-group-item-danger">Worker Evaluation Sheet-Bangla</a>
        </div>
        </div>
    </body>
</html>
