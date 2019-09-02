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
                <form role="form" action="department_info_print.php?" method="get" >
                <div class="radio"><label><input type="radio" name="radiot"value='A' checked>Select All Employee</label></div>
                <div class="radio"><label><input type="radio" name="radiot" value='B'>Select Employee From Joining Date </label><input type="date" name="join_date" class="form-control" style="width:400px"></div>
                <input type='hidden' name='id' value="<?php echo $ID ?>" >
                <button type='submit' class="btn btn-success" name='submit' value="submit">Submit</button>
        </form>
            </div>
    </div>
    
    <body>
        
    </body>