<?php
session_start();
if(!($_SESSION['name']=='admin'||$_SESSION['name']=='data_entry'))
{
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php //include "html/navbar.html"; ?>
<?php include "html/bootstrap.html" ?>
<!DOCTYPE html>

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

<html>
    <head>

        <title>Employee Update Form</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php include 'html/navbar.php'; ?>
        <div class="container">
            <h3>Update Experience</h3>
            <?php
            $id=$_GET['id'];
            $sql="SELECT * FROM job_experience WHERE serial='$id'";
            $result=mysqli_query($db, $sql);
            $row=mysqli_fetch_array($result);
            if(isset($_POST['job_experience']))
            {
                $prev_employer=mysqli_real_escape_string($db, $_POST['prev_employer']);
                $prev_emp_designation=mysqli_real_escape_string($db, $_POST['prev_emp_designation']);
                $prev_job_field=mysqli_real_escape_string($db, $_POST['prev_job_field']);
                $prev_experience=mysqli_real_escape_string($db, $_POST['prev_experience']);
                $prev_job_address=mysqli_real_escape_string($db, $_POST['prev_job_address']);
                $prev_ref=mysqli_real_escape_string($db, $_POST['prev_ref']);

                $sql="UPDATE `job_experience` SET `previous_employer`='$prev_employer',`designation`='$prev_emp_designation',`job_field`='$prev_job_field',`job_experience`='$prev_experience',`address`='$prev_job_address',`refference`='$prev_ref' WHERE serial='$id'";
                mysqli_query($db, $sql);
                redirect("jobdetails.php?id=".$row['emp_id']);

            }
            if(isset($_POST['delete']))
            {
                $sql="DELETE FROM `job_experience` WHERE serial='$id'";
                mysqli_query($db, $sql);
                redirect("jobdetails.php?id=".$row['emp_id']);
            }


            ?>
            <form action="" method="post">
                <div class="form-group">Previous Employer:  <input type="text" name="prev_employer" value="<?php echo $row[2]; ?>" class="form-control" style="width:500px"></div>
                <div class="form-group">Designation:  <input type="text" name="prev_emp_designation" value="<?php echo $row[3]; ?>" class="form-control" style="width:500px" ></div>
                <div class="form-group">Job Field:  <input type="text" name="prev_job_field" value="<?php echo $row[4]; ?>" class="form-control" style="width:500px" ></div>
                <div class="form-group">Job Experience:  <input type="text" name="prev_experience" value="<?php echo $row[5]; ?>" class="form-control" style="width:500px"></div>
                <div class="form-group">Address: <input type="text" name="prev_job_address" value="<?php echo $row[6]; ?>" class="form-control" style="width:500px"></div>
                <div class="form-group">Reference<input type="text" name="prev_ref" value="<?php echo $row[7]; ?>" class="form-control" style="width:500px"></div>
                <input type="submit" name="job_experience" value="Update" class="btn btn-primary">
                <input type="submit" name="delete" value="Delete" class="btn btn-danger">
            </form>
        </div>
    </body>