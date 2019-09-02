<?php
session_start();
include "connect.php";
$entrier=$_SESSION['id'];
date_default_timezone_set('Asia/Dhaka');
$date = date('Y-m-d', time());
$emp=$_GET['id'];
$ref = "REF-"; 
$ref .= date("Ymd-his-", time());
$ref .= rand(10,99);
$ref .= "-".$_SESSION['id'];
$ref .= "-".$emp;

if($_POST['mc']!='')
{
    $mc=mysqli_real_escape_string($db,$_POST['mc']);
    $hos_date=$_POST['hos_date'];
    $pc=$_POST['pc'];
    $hos_remark=mysqli_real_escape_string($db,$_POST['hos_remark']);

    $comment= "Medical Coverage: ".$mc."
";
    $comment .= "Joining Date to HS: ".date_format(date_create($hos_date),"M d, Y")."
";
    $comment .= "Monthly Premium Charged: ".$pc."
";

    mysqli_query($db,"INSERT INTO `history_facility`(`emp_id`, `entrier_id`,`remarks`, `entry_date`, `ref`, `facility`, `type`) VALUES ('$emp','$entrier','$hos_remark','$date','$ref' ,'$comment','Hospitalization Scheme')");
}

if($_POST['bp'] != '')
{
    $bp=mysqli_real_escape_string($db,$_POST['bp']);
    $gd_tk=$_POST['gd_tk'];
    $gd_y=$_POST['gd_y'];
    $gratuity_remark=mysqli_real_escape_string($db,$_POST['gratuity_remark']);

    $comment = "Benefit Package: ".$bp."
";
    $comment .= "Gratuity Disbursent: ".$gd_tk."(Tk.) X ".$gd_y."(Years) = ".$gd_tk*$gd_y." BDT
";
    mysqli_query($db,"INSERT INTO `history_facility`(`emp_id`, `entrier_id`,`remarks`, `entry_date`, `ref`, `facility`, `type`) VALUES ('$emp','$entrier','$gratuity_remark','$date','$ref' ,'$comment','Gratuity')");

}

if($_POST['tin'] != '')
{
    $tin=mysqli_real_escape_string($db,$_POST['tin']);
    $tax_d=$_POST['tax_d'];
    $tax_remark=mysqli_real_escape_string($db,$_POST['tax_remark']);

    $comment = "TIN No.: ".$tin."
";
    $comment .= "Monthly Deduction: ".$tax_d."
";
    mysqli_query($db,"INSERT INTO `history_facility`(`emp_id`, `entrier_id`,`remarks`, `entry_date`, `ref`, `facility`, `type`) VALUES ('$emp','$entrier','$tax_remark','$date','$ref' ,'$comment','Income Tax')");

}

if($_POST['pf_con'] != '')
{
    $pf_date = $_POST['pf_date'];
    $pf_con = $_POST['pf_con'];
    $pf_remark=mysqli_real_escape_string($db,$_POST['pf_remark']);

    $comment = "Joining Date to PF: ".date_format(date_create($pf_date),"M d, Y")."
";
    $comment .= "Monthly PF Contribution: ".$pf_con."
";
    mysqli_query($db,"INSERT INTO `history_facility`(`emp_id`, `entrier_id`,`remarks`, `entry_date`, `ref`, `facility`, `type`) VALUES ('$emp','$entrier','$pf_remark','$date','$ref' ,'$comment','Provident Fund')");
}
header("location:history.php?id=".$emp);
?>
