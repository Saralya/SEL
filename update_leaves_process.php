<?php
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php include "connect.php"; ?>
<?php 
if(isset($_POST['submit']))
{
    $emp=$_GET['id'];
    $casual=(int)$_POST['casual'];
    $sick=(int)$_POST['sick'];
    $annual=(int)$_POST['annual'];
    $maternity=(int)$_POST['maternity'];
    $paternity=(int)$_POST['paternity'];
    $wpl=(int)$_POST['wpl'];


    date_default_timezone_set('Asia/Dhaka');
    $leave_year = date('Y', time());

    $sql = "SELECT * FROM `leave_types` WHERE emp_id='$emp' AND `year`='$leave_year'";
    $result = mysqli_query($db ,$sql);
    if($result->num_rows==0)
    {
        mysqli_query($db,"INSERT INTO `leave_types`(`emp_id`, `casual`, `sick`, `annual`, `maternity`, `paternity`, `wpl`, `year`) VALUES ('$emp','$casual','$sick','$annual','$maternity','$paternity','$wpl','$leave_year')");
    }
    else
    {


        if(!empty($_POST['casual']))
        {
            $sql="UPDATE `leave_types` SET `casual`=$casual WHERE emp_id='$emp' AND `year`='$leave_year'";
            mysqli_query($db, $sql);        
        }
        if(!empty($_POST['sick']))
        {
            $sql="UPDATE `leave_types` SET `sick`=$sick WHERE emp_id='$emp' AND `year`='$leave_year'";
            mysqli_query($db, $sql);        
        }
        if(!empty($_POST['annual']))
        {
            $sql="UPDATE `leave_types` SET `annual`=$annual WHERE emp_id='$emp' AND `year`='$leave_year'";
            mysqli_query($db, $sql);        
        }
        if(!empty($_POST['maternity']))
        {
            $sql="UPDATE `leave_types` SET `maternity`=$maternity WHERE emp_id='$emp' AND `year`='$leave_year'";
            mysqli_query($db, $sql);        
        }
        if(!empty($_POST['paternity']))
        {
            $sql="UPDATE `leave_types` SET `paternity`=$paternity WHERE emp_id='$emp' AND `year`='$leave_year'";
            mysqli_query($db, $sql);        
        }
        if(!empty($_POST['wpl']))
        {
            $sql="UPDATE `leave_types` SET `wpl`=$wpl WHERE emp_id='$emp' AND `year`='$leave_year'";
            mysqli_query($db, $sql);        
        }
    }




}


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
redirect("history.php?id=$emp");


?>