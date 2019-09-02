<?php
session_start();
if(!($_SESSION['name']=='admin')){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Employee Details</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </head>
    <body>
        <?php include 'html/navbar.php'; ?>
        <div class="container">
            <center>
                <div style="padding-left:400px; padding-right:400px">
                <div class="panel panel-success">
                    <div class="panel-heading"><center>You Are Superuser!!</center></div>
                    <div class="panel-body"><img src="images.jfif"></div> 
                    <div class="panel-footer">User ID: <?php echo $_SESSION['id']; ?></div>
                    </div></div></center>
        </div>
        </div>


    </body>
</html>