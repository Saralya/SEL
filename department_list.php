<?php
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php include "html/bootstrap.html"; ?>

<?php
$query = "SELECT department.*, employee.* FROM department JOIN employee ON department.head_id=employee.ID ORDER BY department.dep_id";
$list = mysqli_query($db, $query);
?>

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
    <body><?php include 'html/navbar.php'; ?>
        <div class="">
            <div class="container">
                
                <br><h3>Department List of System Engineering Limited</h3><br>


                <?php
                if($list->num_rows === 0)
                {

                    $sql = "SELECT * FROM department WHERE dep_name = 'Head Office'";
                    $result=mysqli_query($db, $sql);
                    $row=mysqli_fetch_array($result);
                    echo "<table align='center' cellpadding='3' cellspacing='3' class='table table-striped'> 
                            <tr>
                            <th width='150px'>Department ID</th>
                            <th width='150px'>Department Name</th>
                            <th width='100px' position='fixed'>Head ID</th> 
                            <th width='150px'>Head Name</th>
                            <th width='150px'>Designation</th>
                            <th width='150px'>Reporting Mail</th>
                            <th width='150px'>Number Of Employees</th>
                            <th width='150px'>On Leave</th>
                            </tr>";

                    echo "<tr>";
                    echo "<td>" . $row['dep_id'] . "</td>";
                    echo "<td><a href='department_update.php?id=".$row['dep_id']."'>" . $row['dep_name'] . "</a></td>";
                    echo "<td>N/A</td>";
                    echo "<td>N/A</td>";
                    echo "<td>N/A</td>";
                    echo "<td>" . $row['reporting_mail'] . "</td>";
                    echo "<td>N/A</td>";
                    echo "<td>N/A</td>";
                    echo "</tr>";
                    echo "</table>";
                }
                else 
                {

                    echo "<table align='center' cellpadding='3' cellspacing='3' class='table table-striped'> 
                            <tr class='success'>
                            <th width='150px'>Department ID</th>
                            <th width='150px'>Department Name</th>
                            <th width='100px' position='fixed'>Head ID</th> 
                            <th width='150px'>Head Name</th>
                            <th width='150px'>Designation</th>
                            <th width='150px'>Reporting Mail</th>
                            <th width='150px'>Number Of Employees</th>
                            <th width='150px'>On Leave</th>
                            </tr>";

                    // output data of each row
                    while($row = mysqli_fetch_assoc($list)) 
                    {
                        echo "<tr>";
                        echo "<td>" . $row['dep_id'] . "</td>";
                        echo "<td><a href='department_details.php?id=".$row['dep_id']."'>" . $row['dep_name'] . "</a></td>";
                        echo "<td>" . $row['head_id'] . "</td>";
                        echo "<td>" . $row['First Name'] ." ". $row['Last Name']. "</td>";
                        $sql_1 = "SELECT * from job_status Where emp_id= ". $row['head_id'];
                        $result_1 = $db -> query($sql_1);
                        $row_1 = $result_1 -> fetch_array();
                        echo "<td>".$row_1['curr_designation']."</td>";
                        echo "<td>" .$row['reporting_mail']."<br>". $row['reporting_mail_2'] . "</td>";
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
                }
                mysqli_close($db);
                ?>
                <?php //include "html/footer.html"; ?>


            </div>
        </div>
    </body>

</html>
