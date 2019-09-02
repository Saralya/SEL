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
                <form role="form" action="employee_profile_print.php" method="get" >
                <div><label><input name="ID" value="<?php echo $ID ?>" hidden></label></div>
                <div class="checkbox"><label><input name="personal" type="checkbox" value="personal">Personal Info</label></div>
                <div class="checkbox"><label><input name="job" type="checkbox" value="job">Job Status</label></div>
                <div class="checkbox"><label><input name="experience" type="checkbox" value="experience">Job Experience</label></div>
                <div class="checkbox"><label><input name="qualification" type="checkbox" value="qualification">Education</label></div>
                <div class="checkbox"><label><input name="training" type="checkbox" value="training">Training</label></div>
                <div class="checkbox"><label><input name="awards" type="checkbox" value="awards">Awards</label></div>
                <div class="checkbox"><label><input name="disciplinary" type="checkbox" value="disciplinary">Disciplinary</label></div>
                <div class="checkbox"><label><input name="leaves_all" type="checkbox" value="leaves">All Leaves History</label></div>
                <div class="checkbox"><label><input name="leaves_date" type="checkbox" value="leaves">Date to Date Leaves History</label></div>
                <div class="checkbox"><label><input name="employment" type="checkbox" value="employment">Employment Type History</label></div>
                <div class="checkbox"><label><input name="department" type="checkbox" value="department">Department History</label></div>
                <div class="checkbox"><label><input name="designation" type="checkbox" value="designation">Position History</label></div>
                <div class="checkbox"><label><input name="salary" type="checkbox" value="salary">Salary History</label></div>
                <div class="checkbox"><label><input name="bonus" type="checkbox" value="bonus">Bonus History</label></div>
                <div class="checkbox"><label><input name="facility" type="checkbox" value="facility">Facility History</label></div>
                <button type='submit' class="btn btn-success" name='submit' value="submit">Submit</button>
        </form>
            </div>
    </div>
    
    <body>
        
    </body>