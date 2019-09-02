<?php
session_start();
if(!($_SESSION['head']=='Yes'||$_SESSION['reporter']=='Yes')){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php include "html/bootstrap.html"; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>List of Departments</title>
    </head>
    <body>
        <?php include 'html/navbar.php'; ?>

        <div class="container-fluid" style="padding-left:50px; padding-right:50px;">
            <div class="row">
                <div class="col-sm-6">
                    <br><h3>Departments List Where You are Head</h3><br>
                    <?php
                    $id=$_SESSION['id'];
                    $sql="SELECT * FROM department WHERE head_id='$id'";
                    $list=mysqli_query($db,$sql);
                    echo "<table align='center' cellpadding='3' cellspacing='3' class='table table-striped'> 
                <tr class='success'>
                <th width='150px'>Department ID</th>
                <th width='150px'>Department Name</th>
                <th width='150px'>Number Of Employees</th>
                <th width='150px'>On Leave</th>
                </tr>";
                    while($row = mysqli_fetch_assoc($list)) 
                    {
                        echo "<tr>";
                        echo "<td>" . $row['dep_id'] . "</td>";
                        echo "<td><a href='department_details.php?id=".$row['dep_id']."'>" . $row['dep_name'] . "</a></td>";
                        $sql = "SELECT COUNT(department_id) as total_emp FROM employee WHERE department_id=".$row['dep_id'];
                        $res_emp = mysqli_query ($db, $sql);
                        $row_emp = mysqli_fetch_array($res_emp);
                        echo "<td align='center'><a href='department_details.php?id=".$row['dep_id']."'>" . $row_emp['total_emp'] . "</a></td>";
                        date_default_timezone_set('Asia/Dhaka');
                        $date = date('Y-m-d', time());
                        $sql="SELECT leaves.*, employee.department_id, COUNT(leaves.EmployeeID) AS On_leave FROM leaves JOIN employee ON leaves.EmployeeID=employee.ID WHERE employee.department_id=".$row['dep_id']." AND leaves.status='Approved' AND leaves.`From Date`<='$date' AND leaves.joined='No'";
                        $on_leave=mysqli_query($db, $sql);
                        $count=mysqli_fetch_array($on_leave);
                        echo "<td align='center'>".$count['On_leave']."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";


                    ?>
                </div>
                <div class="col-sm-6">
                    <br><h3>Departments List Where You are Reporter</h3><br>
                    <?php
                    $id=$_SESSION['id'];
                    $sql="SELECT * FROM department WHERE reporter_id='$id'";
                    $list=mysqli_query($db,$sql);
                    echo "<table align='center' cellpadding='3' cellspacing='3' class='table table-striped'> 
                <tr class='info'>
                <th width='150px'>Department ID</th>
                <th width='150px'>Department Name</th>
                <th width='150px'>Number Of Employees</th>
                <th width='150px'>On Leave</th>
                </tr>";
                    while($row = mysqli_fetch_assoc($list)) 
                    {
                        echo "<tr>";
                        echo "<td>" . $row['dep_id'] . "</td>";
                        echo "<td><a href='department_details.php?id=".$row['dep_id']."'>" . $row['dep_name'] . "</a></td>";
                        $sql = "SELECT COUNT(department_id) as total_emp FROM employee WHERE department_id=".$row['dep_id'];
                        $res_emp = mysqli_query ($db, $sql);
                        $row_emp = mysqli_fetch_array($res_emp);
                        echo "<td align='center'><a href='department_details.php?id=".$row['dep_id']."'>" . $row_emp['total_emp'] . "</a></td>";
                        date_default_timezone_set('Asia/Dhaka');
                        $date = date('Y-m-d', time());
                        $sql="SELECT leaves.*, employee.department_id, COUNT(leaves.EmployeeID) AS On_leave FROM leaves JOIN employee ON leaves.EmployeeID=employee.ID WHERE employee.department_id=".$row['dep_id']." AND leaves.status='Approved' AND leaves.`From Date`<='$date' AND leaves.joined='No'";
                        $on_leave=mysqli_query($db, $sql);
                        $count=mysqli_fetch_array($on_leave);
                        echo "<td align='center'>".$count['On_leave']."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                    ?>
                    
                </div>
            </div>
        </div>
    </body>
</html>