<?php session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Search</title>    <?php include 'html/bootstrap.html'; ?>
    </head>
    <body>
        <?php include 'html/navbar.php'; 
        date_default_timezone_set('Asia/Dhaka');?>
        <div class='container'>
            <form method="post" action="">
                <label>Designation: </label>
                <select name="desig" style="width:200px" class="form-control">
                    <option value="">----------</option>
                    <?php
                    $res=mysqli_query($db,"SELECT * FROM designation ORDER BY designations");
                    while($row=mysqli_fetch_array($res))
                    {
                        echo "<option value='".$row['designations']."'>".$row['designations']."</option>";
                    }
                    ?>
                </select>
                <label>Degree: </label>
                <select name="degree" style="width:200px" class="form-control">
                    <option value="">----------</option>
                    <?php
                    $res=mysqli_query($db,"SELECT DISTINCT degree FROM qualification ORDER BY degree");
                    while($row=mysqli_fetch_array($res))
                    {
                        echo "<option value='".$row['degree']."'>".$row['degree']."</option>";
                    }
                    ?>
                </select>

                <br>
                <input name="submit" type="submit" class="btn btn-primary" value="Search">
            </form>
            <br>
            <?php
            if(isset($_POST['submit']))
            {
                $desig=mysqli_real_escape_string($db,$_POST['desig']);  
                $degree=mysqli_real_escape_string($db,$_POST['degree']);
                echo "<table class='table table-striped table-bordered'>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Name</th>";
                echo "<th>Designation</th>";
                echo "<th>Degree</th>";
                echo "<th>Experience (SEL)</th>";
                echo "</tr>";
                if($desig != '' && $degree == '')
                {
                    $res=mysqli_query($db,"SELECT * FROM `job_status` WHERE `curr_designation`='$desig'");
                    //echo $res -> num_rows;
                    while($row=mysqli_fetch_array($res))
                    {
                        echo "<tr>";
                        echo "<td>".$row['emp_id']."</td>";
                        $id=$row['emp_id'];
                        $result=mysqli_query($db,"SELECT * FROM employee WHERE ID='$id'");
                        $name=mysqli_fetch_array($result);
                        $full_name=$name['First Name']." ".$name['Last Name'];
                        echo "<td><a href='jobdetails.php?id=".$id."'>".$full_name."</td>";
                        $result=mysqli_query($db,"SELECT * FROM job_status WHERE emp_id='$id'");
                        $name=mysqli_fetch_array($result);
                        $d=$name['curr_designation'];
                        echo "<td>".$d."</td>";
                        $result=mysqli_query($db,"SELECT * FROM qualification WHERE emp_id='$id'");
                        $name=mysqli_fetch_array($result);
                        $d=$name['degree'];
                        echo "<td>".$d."</td>";
                        $result=mysqli_query($db,"SELECT * FROM job_status WHERE emp_id='$id'");
                        $exp=mysqli_fetch_array($result);
                        $joining=$exp['joining_date'];
                        $date = date('Y-m-d', time());
                        $diff = date_diff(date_create($joining), date_create($date));
                        $a = $diff->y;
                        echo "<td>".$a." (Years)</td>";
                        echo "</tr>";        
                    }
                }
                if($desig == '' && $degree != '')
                {
                    $res=mysqli_query($db,"SELECT * FROM `qualification` WHERE `degree`='$degree'");
                    //echo $res -> num_rows;
                    while($row=mysqli_fetch_array($res))
                    {
                        echo "<tr>";
                        echo "<td>".$row['emp_id']."</td>";
                        $id=$row['emp_id'];
                        $result=mysqli_query($db,"SELECT * FROM employee WHERE ID='$id'");
                        $name=mysqli_fetch_array($result);
                        $full_name=$name['First Name']." ".$name['Last Name'];
                        echo "<td><a href='jobdetails.php?id=".$id."'>".$full_name."</td>";
                        $result=mysqli_query($db,"SELECT * FROM job_status WHERE emp_id='$id'");
                        $name=mysqli_fetch_array($result);
                        $d=$name['curr_designation'];
                        echo "<td>".$d."</td>";
                        $result=mysqli_query($db,"SELECT * FROM qualification WHERE emp_id='$id'");
                        $name=mysqli_fetch_array($result);
                        $d=$name['degree'];
                        echo "<td>".$d."</td>";
                        $result=mysqli_query($db,"SELECT * FROM job_status WHERE emp_id='$id'");
                        $exp=mysqli_fetch_array($result);
                        $joining=$exp['joining_date'];
                        $date = date('Y-m-d', time());
                        $diff = date_diff(date_create($joining), date_create($date));
                        $a = $diff->y;
                        echo "<td>".$a." (Years)</td>";
                        echo "</tr>";        
                    }
                }
                if($desig != '' && $degree != '')
                {
                    $res=mysqli_query($db,"SELECT job_status.*, qualification.* FROM `job_status` JOIN `qualification` ON job_status.emp_id=qualification.emp_id WHERE job_status.`curr_designation`='$desig' AND qualification.degree='$degree'");
                    //echo $res -> num_rows;
                    while($row=mysqli_fetch_array($res))
                    {
                        echo "<tr>";
                        echo "<td>".$row['emp_id']."</td>";
                        $id=$row['emp_id'];
                        $result=mysqli_query($db,"SELECT * FROM employee WHERE ID='$id'");
                        $name=mysqli_fetch_array($result);
                        $full_name=$name['First Name']." ".$name['Last Name'];
                        echo "<td><a href='jobdetails.php?id=".$id."'>".$full_name."</td>";
                        echo "<td>".$row['curr_designation']."</td>";
                        echo "<td>".$row['degree']."</td>";
                        $result=mysqli_query($db,"SELECT * FROM job_status WHERE emp_id='$id'");
                        $exp=mysqli_fetch_array($result);
                        $joining=$exp['joining_date'];
                        $date = date('Y-m-d', time());
                        $diff = date_diff(date_create($joining), date_create($date));
                        $a = $diff->y;
                        echo "<td>".$a." (Years)</td>";
                        echo "</tr>";        
                    }
                }
                echo "</table>";
            }
            ?>



        </div>
    </body>
</html>

