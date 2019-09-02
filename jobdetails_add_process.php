<?php
session_start();
if(!($_SESSION['name']=='admin'||$_SESSION['name']=='data_entry'))
{
    header("location:admin.php");

}
include 'connect.php';
$id=$_GET['id'];
?>
<?php
if(isset($_POST['experience']))
{
    $prev_employer=mysqli_real_escape_string($db, $_POST['prev_employer']);
    $prev_emp_designation=mysqli_real_escape_string($db, $_POST['prev_emp_designation']);
    $prev_job_field=mysqli_real_escape_string($db, $_POST['prev_job_field']);
    $prev_experience=mysqli_real_escape_string($db, $_POST['prev_experience']);
    $prev_job_address=mysqli_real_escape_string($db, $_POST['prev_job_address']);
    $prev_ref=mysqli_real_escape_string($db, $_POST['prev_ref']);

    $query = "INSERT INTO `job_experience`(`emp_id`, `previous_employer`, `designation`, `job_field`, `job_experience`, `address`, `refference`) VALUES ('$id','$prev_employer','$prev_emp_designation','$prev_job_field','$prev_experience','$prev_job_address','$prev_ref')";
    mysqli_query($db, $query);
}

if(isset($_POST['training']))
{
    $training_title=mysqli_real_escape_string($db, $_POST['training_title']);
    $training_ins=mysqli_real_escape_string($db, $_POST['training_ins']);
    $training_place=mysqli_real_escape_string($db, $_POST['training_place']);
    $training_days=(int)$_POST['training_days'];
    $training_year=mysqli_real_escape_string($db, $_POST['training_year']);

    $query="INSERT INTO `training`(`emp_id`, `title`, `institution`, `place`, `days`, `year`) VALUES ('$id','$training_title', '$training_ins', '$training_place', '$training_days', '$training_year')";
    mysqli_query($db, $query);
}

if(isset($_POST['awards']))
{
    $award_date=$_POST['award_date'];
    $award_remarks=mysqli_real_escape_string($db, $_POST['award_remarks']);

    $query= "INSERT INTO `awards`(`emp_id`, `date`, `remarks`) VALUES ('$id', '$award_date', '$award_remarks')";
    mysqli_query($db, $query);
}

if(isset($_POST['complain']))
{
    $complain_date=$_POST['complain_date'];
    $complain_remarks=mysqli_real_escape_string($db, $_POST['complain_remarks']);

    $query= "INSERT INTO `complain`(`emp_id`, `date`, `remarks`) VALUES ('$id', '$complain_date', '$complain_remarks')";
    mysqli_query($db, $query);
}

if(isset($_POST['disc']))
{
    $disciplinary =mysqli_real_escape_string($db, $_POST['disciplinary']);
    $disciplinary_date = $_POST['disciplinary_date'];
    $disciplinary_remarks =mysqli_real_escape_string($db, $_POST['disciplinary_remarks']);

    $query = "INSERT INTO `disciplinary`(`emp_id`, `type`, `date`, `remarks`) VALUES ('$id','$disciplinary', '$disciplinary_date', '$disciplinary_remarks')";
    mysqli_query($db, $query);
}
?>

<?php
if(isset($_POST['qualification']))
{
    $a1='edu_field';
    $a2='edu_ins';
    $a3='edu_year';
    $a4='edu_mark';
    $a5='edu_loc';
    $a6='edu_degree';   

    $field=mysqli_real_escape_string($db, $_POST[$a1]);
    $ins=mysqli_real_escape_string($db, $_POST[$a2]);
    $year=mysqli_real_escape_string($db, $_POST[$a3]);
    $mark=$_POST[$a4];
    $loc=mysqli_real_escape_string($db, $_POST[$a5]);
    $degree_name=mysqli_real_escape_string($db, $_POST[$a6]);

    /*$query ="INSERT INTO `qualification`( `emp_id`, `field`, `institution`, `year`, `mark`, `location`, `degree`) VALUES ('42mkl', '342343', 'sins', 'year', 'dfd', 'fdsf','dfsd');";*/

    $query ="INSERT INTO `qualification`( `emp_id`, `field`, `institution`, `year`, `mark`, `location`, `degree`) VALUES ('$id', '$field', '$ins', '$year', '$mark', '$loc','$degree_name');";
    mysqli_query($db, $query);

}

?>

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
redirect("jobdetails.php?id=".$id); 

?>