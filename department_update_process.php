<?php
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php include 'connect.php';?>
<?php //include "html/navbar.html"; ?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body><?php include "html/navbar.php" ?>
        <div class="container"> 

            <?php 
    function redirect($url){
    if (!headers_sent())
    {    
        header('Location: '.$url);
        exit;
    }
    else
    {  
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
} 

        $id=$_GET['id'];
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d', time());
        $entrier= $_SESSION['id'];
        $eff_date=$_POST['eff_date'];
        $appr_date=$_POST['appr_date'];
        $eff_date_2=$_POST['eff_date_2'];
        $appr_date_2=$_POST['appr_date_2'];

        if(isset($_POST['submit']))
        {

            $dep_name = mysqli_real_escape_string($db, $_POST['dep_name']);
            $head =$_POST['head'];
            $reporter=$_POST['reporter'];


            if($_POST['dep_name']!=='')	
            {

                $query1 = "UPDATE `department` SET `dep_name`='$dep_name' WHERE dep_id='$id'";
                mysqli_query($db, $query1);
                echo '<div class="alert alert-success" align="center">
            <strong>Success!</strong> Department Name Changed Successfully.
            </div>';


            }

            if($_POST['head']!=='')	
            {
                $sql ="SELECT * FROM `login` WHERE Username='$head'";
                $result= mysqli_query($db, $sql);
                if($result->num_rows === 0)
                {
                    echo '<div class="alert alert-danger" align="center">
            <strong>Warning!</strong> Head Does not have an account!!
            </div>';
                }
                else
                {
                    $query1 = "UPDATE `department` SET `head_id`='$head' WHERE dep_id=".$id;
                    mysqli_query($db, $query1);
                    $query1 = "SELECT * FROM employee WHERE ID='$head'";
                    $result=mysqli_query($db, $query1);
                    $row=mysqli_fetch_array($result);
                    $query2 = "UPDATE `department` SET `reporting_mail`='".$row['Email']."' WHERE dep_id=".$id;
                    mysqli_query($db, $query2);
                    echo '<div class="alert alert-success" align="center">
            <strong>Success!</strong> Head Changed Successfully.
            </div>';
                    $sql="INSERT INTO `department_record`(`dep_id`, `type`, `history`,`entry_date`, `entrier`,`approval_date`,`eff_date`) VALUES ('$id','head', '$head','$date','$entrier','$appr_date','$eff_date')";
                    mysqli_query($db,$sql);
                }

            }

            if($_POST['reporter']!=='')	
            {
                $sql1 ="SELECT * FROM `login` WHERE Username='$reporter'";
                $result1= mysqli_query($db, $sql1);
                if($result1->num_rows===0)
                {

                    echo '<div class="alert alert-danger" align="center">
            <strong>Warning!</strong> Reporter Does not have an account!!
            </div>';

                }
                else
                {
                    $query1 = "UPDATE `department` SET `reporter_id`='$reporter' WHERE dep_id=".$id;
                    mysqli_query($db, $query1);
                    $query1 = "SELECT * FROM employee WHERE ID='$reporter'";
                    $result=mysqli_query($db, $query1);
                    $row=mysqli_fetch_array($result);
                    $query2 = "UPDATE `department` SET `reporting_mail_2`='".$row['Email']."' WHERE dep_id=".$id;
                    mysqli_query($db, $query2);

                    echo '<div class="alert alert-success" align="center">
            <strong>Success!</strong> Reporter Changed Successfully.
            </div>';
                    $sql="INSERT INTO `department_record`(`dep_id`, `type`, `history`,`entry_date`, `entrier`,`approval_date`,`eff_date`) VALUES ('$id','reporter', '$reporter','$date','$entrier','$appr_date_2','$eff_date_2')";
                    mysqli_query($db,$sql);
                }

            }





        }
            ?></div>
    </body></html>