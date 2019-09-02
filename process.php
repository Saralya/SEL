<?php
session_start();
if(!$_SESSION['name']){
    header("location:admin.php");
}
?>

<?php include 'connect.php';?>
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
?>

 

<?php


if(isset($_POST['submit'])){
    $ID= mysqli_real_escape_string($db,$_POST['empID']);
    $entrier=$_SESSION['id'];

    $ref = "REF-";
    $ref .= date("Ymd-his-", time());
    $ref .= rand(10,99);
    $ref .= "-".$_SESSION['id'];
    $ref .= "-".$ID;

    date_default_timezone_set('Asia/Dhaka');
    $date = date('Y-m-d', time());
    //$file = $_FILES['image']['name'];
    //$target_dir= "photo/";
    //$target_file= $target_dir.$file;
    //move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    //...................................................
    $temp = explode(".", $_FILES["image"]["name"]);
    $newfilename = $ID. '.' . end($temp);
    move_uploaded_file($_FILES["image"]["tmp_name"], "photo/".$newfilename);
    $file="photo/".$newfilename;
    //..................................................
    //move_uploaded_file($_FILES["image"]["tmp_name"],"photo/" . $_FILES["image"]["name"]);
    //$file="photo/".$_FILES["image"]["name"];

    $first_name = mysqli_real_escape_string($db, $_POST['first']);
    $last_name = mysqli_real_escape_string($db, $_POST['last']);
    $father_name = mysqli_real_escape_string($db, $_POST['father']);
    $mother_name = mysqli_real_escape_string($db, $_POST['mother']);
    $spouse_name = mysqli_real_escape_string($db, $_POST['spouse']);
    $child_num = (int)$_POST['child'];
    $date_of_birth = $_POST['date_of_birth'];
    $mail = mysqli_real_escape_string($db, $_POST['email']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $blood = mysqli_real_escape_string($db, $_POST['blood']);
    $height = (string)$_POST['height'];
    $height =$height." cm";
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $nid = mysqli_real_escape_string($db, $_POST['national_id']);
    $tax_id = mysqli_real_escape_string($db, $_POST['tax_id']);
    $passport_id = mysqli_real_escape_string($db, $_POST['passport_id']);
    $driving_id = mysqli_real_escape_string($db, $_POST['driving_id']);
    $dep_id=$_POST['curr_department'];

    $query = "INSERT INTO `employee`(`ID`,`image`, `First Name`, `Last Name`, `Date of Birth`, `Email`, `Gender`, `Blood Group`, `height`, `Cell Phone`, `father`, `mother`, `spouse`, `children`, `NID`, `tax_id`, `passport`, `driving_license`, `department_id`) VALUES ('$ID','$file','$first_name','$last_name','$date_of_birth','$mail','$gender','$blood','$height','$phone', '$father_name', '$mother_name', '$spouse_name', '$child_num', '$nid', '$tax_id', '$passport_id', '$driving_id', '$dep_id')";
    mysqli_query($db, $query);


    $emer_name=mysqli_real_escape_string($db, $_POST['emer_name']);
    $emer_rel=mysqli_real_escape_string($db, $_POST['emer_rel']);
    $emer_phone=mysqli_real_escape_string($db, $_POST['emer_phone']);

    $query = "INSERT INTO `emergency_contact`(`emp_id`, `name`, `relation`, `cell`) VALUES ('$ID','$emer_name','$emer_rel', '$emer_phone')";
    mysqli_query($db, $query);

    $per_village=mysqli_real_escape_string($db, $_POST['per_village']);
    $pre_village=mysqli_real_escape_string($db, $_POST['pre_village']);
    $per_thana=mysqli_real_escape_string($db, $_POST['per_thana']);
    $pre_thana=mysqli_real_escape_string($db, $_POST['pre_thana']);
    $per_post_office=mysqli_real_escape_string($db, $_POST['per_post_office']);
    $pre_post_office=mysqli_real_escape_string($db, $_POST['pre_post_office']);
    $per_district=mysqli_real_escape_string($db, $_POST['per_district']);
    $pre_district=mysqli_real_escape_string($db, $_POST['pre_district']);
    $per_division=mysqli_real_escape_string($db, $_POST['per_division']);
    $pre_division=mysqli_real_escape_string($db, $_POST['pre_division']);


    $query = "INSERT INTO `address`(`emp_id`, `per_village`, `per_post_office`, `per_thana`, `per_district`, `per_division`, `pre_village`, `pre_post_office`, `pre_thana`, `pre_district`, `pre_division`) VALUES ('$ID', '$per_village', '$per_post_office', '$per_thana', '$per_district', '$per_division', '$pre_village', '$pre_post_office', '$pre_thana', '$pre_district', '$pre_division' )";
    mysqli_query($db, $query);


    $casual_leave=0;
    $sick_leave=0;
    $annual_leave=0;
    $maternity_leave=0;
    $paternity_leave=0;
    $wpl=0;

    date_default_timezone_set('Asia/Dhaka');
    $leave_year = date('Y', time());

    $query = "INSERT INTO `leave_types`(`emp_id`, `casual`, `sick`, `annual`, `maternity`, `paternity`, `wpl`,`year`) VALUES ('$ID', '$casual_leave','$sick_leave','$annual_leave', '$maternity_leave', '$paternity_leave', '$wpl','$leave_year')";
    mysqli_query($db, $query);


    $prev_employer=mysqli_real_escape_string($db, $_POST['prev_employer']);
    $prev_emp_designation=mysqli_real_escape_string($db, $_POST['prev_emp_designation']);
    $prev_job_field=mysqli_real_escape_string($db, $_POST['prev_job_field']);
    $prev_experience=mysqli_real_escape_string($db, $_POST['prev_experience']);
    $prev_job_address=mysqli_real_escape_string($db, $_POST['prev_job_address']);
    $prev_ref=mysqli_real_escape_string($db, $_POST['prev_ref']);

    $query = "INSERT INTO `job_experience`(`emp_id`, `previous_employer`, `designation`, `job_field`, `job_experience`, `address`, `refference`) VALUES ('$ID','$prev_employer','$prev_emp_designation','$prev_job_field','$prev_experience','$prev_job_address','$prev_ref')";
    mysqli_query($db, $query);

    $training_title=mysqli_real_escape_string($db, $_POST['training_title']);
    $training_ins=mysqli_real_escape_string($db, $_POST['training_ins']);
    $training_place=mysqli_real_escape_string($db, $_POST['training_place']);
    $training_days=(int)$_POST['training_days'];
    $training_year=mysqli_real_escape_string($db, $_POST['training_year']);

    $query="INSERT INTO `training`(`emp_id`, `title`, `institution`, `place`, `days`, `year`) VALUES ('$ID','$training_title', '$training_ins', '$training_place', '$training_days', '$training_year')";
    mysqli_query($db, $query);

    for($i=0; $i<1; $i++)

    {   
        $a1='edu_field'.$i;
        $a2='edu_ins'.$i;
        $a3='edu_year'.$i;
        $a4='edu_mark'.$i;
        $a5='edu_loc'.$i;
        $a6='edu_degree'.$i;   

        $field=mysqli_real_escape_string($db, $_POST[$a1]);
        $ins=mysqli_real_escape_string($db, $_POST[$a2]);
        $year=mysqli_real_escape_string($db, $_POST[$a3]);
        $mark=$_POST[$a4];
        $loc=mysqli_real_escape_string($db, $_POST[$a5]);
        $degree_name=mysqli_real_escape_string($db, $_POST[$a6]);



        $query ="INSERT INTO `qualification`( `emp_id`, `field`, `institution`, `year`, `mark`, `location`, `degree`) VALUES ('$ID', '$field', '$ins', '$year', '$mark', '$loc','$degree_name');";
        mysqli_query($db, $query);

    }



    $curr_designation=mysqli_real_escape_string($db, $_POST['curr_designation']);
    //$prev_designation=mysqli_real_escape_string($db, $_POST['prev_designation']);	
    $curr_department=mysqli_real_escape_string($db, $_POST['curr_department']);
    //$prev_department=mysqli_real_escape_string($db, $_POST['prev_department']);
    $joining_date=$_POST['joining_date'];
    //$duration_designation=mysqli_real_escape_string($db, $_POST['duration_designation']);
    //$duration_department=mysqli_real_escape_string($db, $_POST['duration_department']);
    $joining_gross=(int)$_POST['joining_gross'];
    $current_gross=(int)$_POST['current_gross'];
    //$promo_date=$_POST['promo_date'];
    //$transfer_date=$_POST['transfer_date'];
    //$last_inc=(int)$_POST['last_inc'];
    //$last_inc_date=$_POST['last_inc_date'];
    $present_working_station=mysqli_real_escape_string($db, $_POST['present_working_station']);
    $employee_status=mysqli_real_escape_string($db, $_POST['employee_status']);
    //$probation_period=mysqli_real_escape_string($db, $_POST['probation_period']);
    $confirmation_status=mysqli_real_escape_string($db, $_POST['confirmation_status']);
    $confirmation_date= $_POST['confirmation_date'];
    $employment_type=mysqli_real_escape_string($db, $_POST['employment_type']);
    $employee_separation=mysqli_real_escape_string($db, $_POST['employee_separation']);
    $employee_separation_date= $_POST['employee_separation_date'];
    
    //$pf_deduction=mysqli_real_escape_string($db, $_POST['pf_deduction']);
    
    //$gratuity=mysqli_real_escape_string($db, $_POST['gratuity']);
    //$hos_schema=mysqli_real_escape_string($db, $_POST['hos_schema']);
    //$hos_range=mysqli_real_escape_string($db, $_POST['hos_range']);
    
    $salary_account=mysqli_real_escape_string($db, $_POST['salary_account']);
    $bank=mysqli_real_escape_string($db, $_POST['bank']);
    $corporate_sim=mysqli_real_escape_string($db, $_POST['corporate_sim']);
    $ot_status=mysqli_real_escape_string($db, $_POST['ot_status']);

    //$income_tax_deduction=mysqli_real_escape_string($db, $_POST['income_tax_deduction']);
    
    $reffered_name=mysqli_real_escape_string($db, $_POST['reffered_name']);
    $reffered_designation=mysqli_real_escape_string($db, $_POST['reffered_designation']);
    $reffered_by=$_POST['reffered_by'];

    $query = "INSERT INTO `job_status`(`emp_id`,`curr_designation`, `curr_department`, `joining_date`, `joining_gross`, `current_gross`, `present_working_station`, `employee_status`, `confirmation_status`, `confirmation_date`, `employment_type`, `employee_separation`, `employee_separation_date`, `pf_deduction`, `gratuity`, `hos_schema`, `hos_range`, `salary_account`, `bank`, `corporate_sim`, `ot_status`, `income_tax_deduction`, `reffered_by`, `name`, `designation`) VALUES ('$ID', '$curr_designation', '$curr_department', '$joining_date', '$joining_gross', '$current_gross', '$present_working_station', '$employee_status', '$confirmation_status', '$confirmation_date', '$employment_type', '$employee_separation', '$employee_separation_date', '$pf_deduction', '$gratuity', '$hos_schema', '$hos_range', '$salary_account', '$bank', '$corporate_sim', '$ot_status', '$income_tax_deduction', '$reffered_by', '$reffered_name', '$reffered_designation')";
    mysqli_query($db, $query);

    $query ="INSERT INTO `history_department`(`emp_id`,`entrier_id`,`tos`, `date`,`entry_date`,`approval_date`,`ref`) VALUES ('$ID','$entrier','$curr_department','$date','$date','$date','$ref')";
    mysqli_query($db, $query);

    //$query ="INSERT INTO `history_salary`(`emp_id`,`entrier_id`,`date`, `amount`) VALUES ('$ID','$entrier', '$last_inc_date', '$last_inc')";
    //mysqli_query($db, $query);

    $query ="INSERT INTO `history_designation`(`emp_id`,`entrier_id`,`to_des`, `date`,`entry_date`,`approval_date`,`ref`) VALUES ('$ID','$entrier','$curr_designation', '$date','$date','$date','$ref')";
    mysqli_query($db, $query);


    $query ="INSERT INTO `history_employment`(`emp_id`, `employment_type`, `entrier`,`date`, `entry_date`,`approval_date`,`eff_date`,`ref`) VALUES ('$ID','$employment_type','$entrier','$employee_separation_date','$date','$date','$date','$ref')";
    mysqli_query($db, $query);


    $query="INSERT INTO `notification`(`emp_id`, `type`, `date`, `comment`, `ref`) VALUES ('$ID','Joined','$date','New Employee Added','$ref')";
    mysqli_query($db, $query);

    redirect('employee_form_post.php?ID='.$ID);    
}




?>


