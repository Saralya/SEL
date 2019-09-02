<?php
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>

<?php
if(isset($_POST['submit']))
{
    $id=$_POST['del'];
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
    $sql="DELETE FROM history_employment WHERE emp_id='$id'";
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

}



?>
<html>

    <body>


        <form method="post" action="">

            <input name='del' type='text'>
            <input name='submit' type='submit' value="Submit">
        </form>
    </body>
</html>