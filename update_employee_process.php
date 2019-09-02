<?php include 'connect.php';?>
<?php
session_start();
if(!($_SESSION['name']=='admin'||$_SESSION['name']=='data_entry')){
    header("location:admin.php");
}
?>

<?php 

$id=$_GET['id'];

if(isset($_POST['personal']))
{

    $first_name = mysqli_real_escape_string($db, $_POST['first']);
    $last_name = mysqli_real_escape_string($db, $_POST['last']);
    $date = $_POST['date'];
    $mail = mysqli_real_escape_string($db, $_POST['email']);
    $child =$_POST['child']; 
    $phone=$_POST['phone'];
    $gender=$_POST['gender'];
    $blood=$_POST['blood'];


    if($_POST['first']!=='')	
    {

        $query1 = "UPDATE `employee` SET `First Name`='".$first_name."' WHERE ID=".$id;
        mysqli_query($db, $query1);
    }

    if($_POST['last']!=='')	
    {
        $query1 = "UPDATE `employee` SET `Last Name`='".$last_name."' WHERE ID=".$id;
        mysqli_query($db, $query1);
    }
    if($_POST['email']!=='')	
    {
        $query1 = "UPDATE `department` SET reporting_mail='$mail' WHERE head_id=".$id;
        mysqli_query($db, $query1);
        $query1 = "UPDATE `department` SET reporting_mail_2='$mail' WHERE reporter_id=".$id;
        mysqli_query($db, $query1);
        $query1 = "UPDATE `employee` SET `Email`='".$mail."' WHERE ID=".$id;
        mysqli_query($db, $query1);


    }

    if($_POST['date']!=='')	
    {
        $query1 = "UPDATE `employee` SET `Date of Birth`='".$date."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }

    if($_POST['child']!=='')	
    {
        $query1 = "UPDATE `employee` SET `children`='".$child."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }

    if($_POST['phone']!=='')	
    {
        $query1 = "UPDATE `employee` SET `Cell Phone`='".$phone."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['gender']!=='')	
    {
        $query1 = "UPDATE `employee` SET `Gender`='".$gender."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['blood']!=='')	
    {
        $query1 = "UPDATE `employee` SET `Blood Group`='".$blood."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['height']!=='')	
    {
        $query1 = "UPDATE `employee` SET `height`='".$_POST['height']."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['father']!=='')	
    {
        $query1 = "UPDATE `employee` SET `father`='".$_POST['father']."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['mother']!=='')	
    {
        $query1 = "UPDATE `employee` SET `mother`='".$_POST['mother']."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['spouse']!=='')	
    {
        $query1 = "UPDATE `employee` SET `spouse`='".$_POST['spouse']."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['passport_id']!=='')	
    {
        $query1 = "UPDATE `employee` SET `passport`='".$_POST['passport_id']."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['national_id']!=='')	
    {
        $query1 = "UPDATE `employee` SET `NID`='".$_POST['national_id']."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['tax_id']!=='')	
    {
        $query1 = "UPDATE `employee` SET `tax_id`='".$_POST['tax_id']."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['driving_id']!=='')	
    {
        $query1 = "UPDATE `employee` SET `driving_license`='".$_POST['driving_id']."' WHERE ID=".$id;
        mysqli_query($db, $query1);

    }


}
?>

<?php

if(isset($_POST['pic']))
{
    $sql="SELECT * FROM employee WHERE ID=".$id;
    $result=mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    $link=$row['image'];
    unlink($link);

    $temp = explode(".", $_FILES["image"]["name"]);
    $newfilename = $id. '.' . end($temp);
    move_uploaded_file($_FILES["image"]["tmp_name"], "photo/".$newfilename);
    $file="photo/".$newfilename;

    $query1 = "UPDATE `employee` SET `image`='$file' WHERE ID=".$id;
    mysqli_query($db, $query1);


}

?>


<?php
if(isset($_POST['address']))
{
    if($_POST['pre_vil']!=='')	
    {

        $query1 = "UPDATE `address` SET `pre_village`='".$_POST['pre_vil']."' WHERE emp_id=".$id;
        mysqli_query($db, $query1);

    }

    if($_POST['pre_pos']!=='')	
    {
        $query1 = "UPDATE `address` SET `pre_post_office`='".$_POST['pre_pos']."' WHERE emp_id=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['pre_tha']!=='')	
    {
        $query1 = "UPDATE `address` SET `pre_thana`='".$_POST['pre_tha']."' WHERE emp_id=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['pre_dis']!=='')	
    {
        $query1 = "UPDATE `address` SET `pre_district`='".$_POST['pre_dis']."' WHERE emp_id=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['pre_div']!=='')	
    {
        $query1 = "UPDATE `address` SET `pre_division`='".$_POST['pre_div']."' WHERE emp_id=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['per_vil']!=='')	
    {
        $query1 = "UPDATE `address` SET `per_village`='".$_POST['per_vil']."' WHERE emp_id=".$id;
        mysqli_query($db, $query1);

    }

    if($_POST['per_pos']!=='')	
    {
        $query1 = "UPDATE `address` SET `per_post_office`='".$_POST['per_pos']."' WHERE emp_id=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['per_tha']!=='')	
    {
        $query1 = "UPDATE `address` SET `per_thana`='".$_POST['per_tha']."' WHERE emp_id=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['per_dis']!=='')	
    {
        $query1 = "UPDATE `address` SET `per_district`='".$_POST['per_dis']."' WHERE emp_id=".$id;
        mysqli_query($db, $query1);

    }
    if($_POST['per_div']!=='')	
    {
        $query1 = "UPDATE `address` SET `per_division`='".$_POST['per_div']."' WHERE emp_id=".$id;
        mysqli_query($db, $query1);

    }

}

?>

<?php
if(isset($_POST['job_status']))
{
    $joining_date=$_POST['joining_date'];
    $joining_gross=$_POST['joining_gross'];
    $working_station=$_POST['working_station'];
    $employee_status=$_POST['employee_status'];
    $confirmation_status=$_POST['confirmation_status'];
    $confirmation_date=$_POST['confirmation_date'];
    $pf_deduction=$_POST['pf_deduction'];
    $gratuity=$_POST['gratuity'];
    $scheme=$_POST['scheme'];
    $scheme_range=$_POST['scheme_range'];
    $salary_account=$_POST['salary_account'];
    $bank_name=$_POST['bank_name'];
    $corporate_sim=$_POST['corporate_sim'];
    $ot_status=$_POST['ot_status'];
    $income_tax=$_POST['income_tax'];
    $ref_id=$_POST['ref_id'];
    $ref_name=$_POST['ref_name'];

    if($_POST['ref_id']!=='')
    {
        $sql="UPDATE `job_status` SET `reffered_by`='$ref_id' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }

    if($_POST['joining_date']!=='')
    {
        $sql="UPDATE `job_status` SET `joining_date`='$joining_date' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }
    if($_POST['joining_gross']!=='')
    {
        $sql="UPDATE `job_status` SET `joining_gross`='$joining_gross' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }
    if($_POST['working_station']!=='')
    {
        $sql="UPDATE `job_status` SET `present_working_station`='$working_station' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }
    if($_POST['ref_name']!=='')
    {
        $sql="UPDATE `job_status` SET `name`='$ref_name' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }
    if($_POST['income_tax']!=='')
    {
        $sql="UPDATE `job_status` SET `income_tax_deduction`='$income_tax' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }
    if($_POST['employee_status']!=='')
    {
        $sql="UPDATE `job_status` SET `employee_status`='$employee_status' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }
    if($_POST['confirmation_status']!=='')
    {
        $sql="UPDATE `job_status` SET `confirmation_status`='$confirmation_status' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }
    if($_POST['confirmation_date']!=='')
    {
        $sql="UPDATE `job_status` SET `confirmation_date`='$confirmation_date' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }
    if($_POST['pf_deduction']!=='')
    {
        $sql="UPDATE `job_status` SET `pf_deduction`='$pf_deduction' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }
    if($_POST['gratuity']!=='')
    {
        $sql="UPDATE `job_status` SET `gratuity`='$gratuity' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }
    if($_POST['scheme']!=='')
    {
        $sql="UPDATE `job_status` SET `hos_schema`='$scheme' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }
    if($_POST['scheme_range']!=='')
    {
        $sql="UPDATE `job_status` SET `hos_range`='$scheme_range' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }    
    if($_POST['salary_account']!=='')
    {
        $sql="UPDATE `job_status` SET `salary_account`='$salary_account' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }    
    if($_POST['bank_name']!=='')
    {
        $sql="UPDATE `job_status` SET `bank`='$bank_name' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }    
    if($_POST['corporate_sim']!=='')
    {
        $sql="UPDATE `job_status` SET `corporate_sim`='$corporate_sim' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }    
    if($_POST['ot_status']!=='')
    {
        $sql="UPDATE `job_status` SET `ot_status`='$ot_status' WHERE `emp_id`='$id'";
        mysqli_query($db,$sql);
    }

}

?>
<?php
if(isset($_POST['emergency']))
{
    $emer_name=$_POST['emer_name'];
    $emer_rel=$_POST['emer_rel'];
    $emer_con=$_POST['emer_con'];
    $sql="UPDATE `emergency_contact` SET `name`='$emer_name',`relation`='$emer_rel',`cell`='$emer_con' WHERE emp_id='$id'";
    mysqli_query($db,$sql);

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