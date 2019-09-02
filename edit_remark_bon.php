<?php
session_start();
if(!($_SESSION['id']=='10001')){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<html lang="en">
    <head>
        <title>Edit Remarks</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php include 'html/navbar.php'; ?>
        <div class="container" style="">
            <?php
            date_default_timezone_set('Asia/Dhaka');
            $today = date('Y-m-d', time());
            $id=$_GET['id'];
            $updater=$_SESSION['id'];
            $sql="SELECT * FROM employee WHERE ID='$updater'";
            $res=mysqli_query($db,$sql);
            $row=mysqli_fetch_array($res);
            if($_SESSION['name']=='admin')
            {
                $updater_name='Admin';
            }
            else
            {
                $updater_name=$row['First Name']." ".$row['Last Name'];
            }

            $query="SELECT * FROM history_bonus WHERE `serial`='$id'";
            $result=mysqli_query($db,$query);
            $data=mysqli_fetch_array($result);
            $emp_id=$data['emp_id'];
            $old_rem=$data['remarks'];
            $query="SELECT * FROM employee WHERE ID='$emp_id'";
            $result=mysqli_query($db,$query);
            $data_2=mysqli_fetch_array($result);
            $name=$data_2['First Name']." ".$data_2['Last Name'];
            $image=$data_2['image'];
            $email=$data_2['Email'];
            $msg=" ";
            ?>
            <h3>Edit Remarks</h3>
                <?php echo "<img src='".$image."' height='50px' width='50px' class='img-rounded'>"." <a href='history.php?id=$emp_id'><big>".$name."</big></a><br>"; ?>
            <br>
            
            <?php

            if(isset($_POST['sub_rem']))
            {
            $remark = mysqli_real_escape_string($db,$_POST['edit_remark']);
            $remark .= "
            (Updated By: ".$updater_name.", ";
            $remark .= "Time: ".date("M d, Y h:i:s a", time()).")";
            $remark = $remark."
            -----------
            ".$old_rem;
            $old_rem=$remark;
            $sql="UPDATE history_bonus SET remarks='$remark' WHERE `serial`='$id'";
            mysqli_query($db,$sql);
            echo '<div class="alert alert-success" align="center">
            Successfylly Changed Remarks!
            </div>';

            }

            else {
            ?>


            <form method="post" action="">
                <b>Remarks:</b><textarea class="form-control" name="old_rem" disabled="disabled" style="height:150px" ><?php echo $old_rem; ?></textarea><br> 
                <b>Update Remarks:</b><textarea class="form-control" name="edit_remark" style="height:150px" ></textarea><br>                
                <input type="submit" value="Confirm" class="btn btn-success" name="sub_rem">  
                <a href="history.php?id=<?php echo $emp_id; ?>" class="btn btn-default">Cancel </a>


            </form>
            <?php
            }
            ?>
        </div>
    </body>
</html>

<?php
mysqli_close($db);
?>
