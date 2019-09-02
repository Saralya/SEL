<?php  
session_start();
if(!$_SESSION['id']){
    header("location:admin.php");
}
?>
<?php //include "html/navbar.html"; ?>
<?php include "connect.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <?php include "html/bootstrap.html" ?>
    <title>Change Password</title>
    <meta charset="utf-8">
</head> 
<body>
    <?php include "html/navbar.php" ?>
    <div class="row row-offcanvas row-offcanvas-left">
        <div class="container">
            <br><h3 style="color:#00BFFF">Change Password</h3><br>  
            <div class="row">
                <div class="col-sm-6">
                    <form action="" method="post" class="">
                        <input placeholder="New Password" type="password" name="district" class="form-control"><br><br>
                        <input placeholder="Confirm Password" type="password" name="repeat" class="form-control"><br>
                        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                    </form>
                </div>
                <div class="col-sm-6">
                    <?php
                    if(isset($_POST['submit']))
                    {
                        $pass=$_POST['district'];
                        $repeat=$_POST['repeat'];
                        if($pass==$repeat&&$pass!='')
                        {
                            $id =$_SESSION['id'];
                            $sql="UPDATE login SET Password='$pass' WHERE Username='$id'";
                            mysqli_query($db,$sql);
                            echo "<div class='alert alert-success'><center>Password Changed Successfully!!</center></div>";
                        }
                        else 
                        {
                            echo "<div class='alert alert-danger'><center>Password Fields Don't Match!!</center></div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
 

</body>

</html>
<?php
mysqli_close($db);
?>