<?php
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>

<?php include 'connect.php'; ?>
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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

    </head>
    <body><?php include 'html/navbar.php'; ?>
        <div class="container">

            <?php
            $id=$_GET['id'];
            if(isset($_POST['keep']))
            {
                redirect("jobdetails.php?id=".$_GET['id']); 

            }
            if(isset($_POST['delete']))
            {

                $sql="SELECT * FROM employee WHERE ID='$id'";
                $row=mysqli_query($db,$sql);
                $res=mysqli_fetch_array($row);
                $image=$res['image'];
                unlink($image);
                $sql="DELETE FROM address WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM qualification WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM awards WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM complain WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM disciplinary WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM emergency_contact WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM employee WHERE ID='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM history_department WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM history_designation WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM history_salary WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM job_experience WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM job_status WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM leaves WHERE EmployeeID='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM leave_types WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM login WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM notification WHERE emp_id='$id'";
                mysqli_query($db,$sql);
                $sql="DELETE FROM training WHERE emp_id='$id'";
                mysqli_query($db,$sql); 
                $sql="DELETE FROM history_employment WHERE emp_id='$id'";
                mysqli_query($db,$sql);

                echo '<div class="alert alert-success" align="center">
            Employee Deleted Successfully!!
            </div>';


            }
            else
            {  
                $sql="SELECT * FROM department WHERE head_id='$id' OR reporter_id='$id'";
                $res=mysqli_query($db,$sql);
                if($res->num_rows!=0)
                {
                    echo '<div class="alert alert-danger" align="center">
            <strong>Warning!!!</strong> He is a Head/Reporter!! Can not Delete.
            </div>';
                }

                else
                {
                    echo '<div class="alert alert-danger" align="center">
            <strong>Are you Sure you want to remove this Employee???</strong><br><br>
            <form action="" method="post">
                <input class="btn btn-info btn-sm" type="submit" value="Yes" name="delete">
                <input class="btn btn-info btn-sm" type="submit" value="No" name="keep">
            </form>
            </div>';
                }
            }
            ?>


        </div>
    </body>



</html>