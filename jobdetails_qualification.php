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
            <?php
            $id=$_GET['id'];
            $sql="SELECT * FROM qualification WHERE serial='$id'";
            $result=mysqli_query($db, $sql);
            $row=mysqli_fetch_array($result);
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

                $sql="UPDATE `qualification` SET `field`='$field',`institution`='$ins',`year`='$year',`mark`='$mark',`location`='$loc',`degree`='$degree_name' WHERE serial='$id'";
                mysqli_query($db, $sql);
                redirect("jobdetails.php?id=".$row['emp_id']);

            }
            if(isset($_POST['delete']))
            {
                $sql="DELETE FROM `qualification` WHERE serial='$id'";
                mysqli_query($db, $sql);
                redirect("jobdetails.php?id=".$row['emp_id']);
            }


            ?>
            <form action="" method="post">
                <div class="form-group"><b>Degree: </b></div>
                <div class="form-group">Degree Name:  <input type="text" name="edu_degree" class="form-control"  style="width:500px" value="<?php echo $row[7];?>"></div>
                <div class="form-group">Field Of Study:  <input type="text" name="edu_field" class="form-control" style="width:500px" value="<?php echo $row[2];?>"></div>
                <div class="form-group">University/School/Institute Name:  <input type="text" name="edu_ins"  class="form-control" style="width:500px" value="<?php echo $row[3];?>"></div>
                <div class="form-group" required>Year of Passing:<input type="text" name="edu_year"  class="form-control"  style="width:500px" value="<?php echo $row[4];?>"></div>
                <div class="form-group">Marks Obtained/CGPA :  <input type="text" name="edu_mark"  class="form-control" style="width:500px" value="<?php echo $row[5];?>" value="<?php echo $row[1];?>"></div>
                <div class="form-group">Location:  <input type="text" name="edu_loc"  class="form-control" style="width:500px" value="<?php echo $row[6];?>"></div>
                <input type="submit" name="qualification" value="Update" class="btn btn-primary">
                <input type="submit" name="delete" value="Delete" class="btn btn-danger">
            </form>





        </div>


    </body>