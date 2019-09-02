<?php
session_start();
if(!($_SESSION['name']=='admin'||$_SESSION['name']=='head'||$_SESSION['reporter']||$_GET['id']==$_SESSION['id'])){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php include "html/bootstrap.html" ?>
<?php //include "html/navbar.html"; ?>


<!DOCTYPE html>


<html>
<head><title>Personal Leave Information</title></head>
<body>
    <?php include "html/navbar.php" ?>

    <div class="row row-offcanvas row-offcanvas-left">

        <div class="container">





            <?php 
            $query = "SELECT * FROM `leaves` WHERE employeeID=".$_GET['id'];
            $query2 = "SELECT * FROM `employee` WHERE ID=".$_GET['id'];
            $result = mysqli_query($db, $query);
            $result2 = mysqli_query($db, $query2);
            $data = mysqli_fetch_assoc($result2);
            $emp=$_GET['id'];
            ?>




            <?php
            echo "<h4 style='color:#708090'><center><i>Employee ID</i> :  " .$_GET['id']."</center></h4>";
            echo "<h4 style='color:#708090'><center><i>Employee Name</i> :  ".$data['First Name']." ".$data['Last Name']."</center></h4>";
            date_default_timezone_set('Asia/Dhaka');
            $leave_year = date('Y', time());
            $sql ="SELECT * FROM `leave_types` WHERE emp_id='$emp' AND `year`='$leave_year'";
            $result = mysqli_query($db, $sql);
            $row = mysqli_fetch_array($result);

                //Gets total casual leaves    
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Casual' AND year='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_casual=mysqli_fetch_array($result);
            $day_casual=$row_casual['Total'];

                //Gets total sick leaves
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Sick' AND year='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_sick=mysqli_fetch_array($result);
            $day_sick=$row_sick['Total'];

                //Gets total annual leaves
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Annual' AND year='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_annual=mysqli_fetch_array($result);
            $day_annual=$row_annual['Total'];

                //Gets total maternity leaves
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Maternity' AND year='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_maternity=mysqli_fetch_array($result);
            $day_maternity=$row_maternity['Total'];

                //Gets total paternity leaves
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Paternity' AND year='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_paternity=mysqli_fetch_array($result);
            $day_paternity=$row_paternity['Total']; 

                //Gets total wpl leaves
            $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$emp' AND status='Approved' AND type='Without Pay Leave' AND year='$leave_year'";
            $result=mysqli_query($db, $sql);
            $row_wpl=mysqli_fetch_array($result);
            $day_wpl=$row_wpl['Total'];

            $existing_casual= $row['casual']-$day_casual; 
            $existing_sick= $row['sick']-$day_sick;
            $existing_annual= $row['annual']-$day_annual;
            $existing_maternity= $row['maternity']-$day_maternity;
            $existing_paternity= $row['paternity']-$day_paternity;
            $existing_wpl= $row['wpl']-$day_wpl;


            ?>

            <table border="1" cellpadding='5' cellspacing='2' align='center' class='table-bordered'>
                <tr>
                    <th width='150px'><center>Types</center></th>
                    <th width='150px'><center>Casual</center></th>
                    <th width='150px'><center>Sick</center></th>
                    <th width='150px'><center>Annual</center></th>
                    <th width='150px'><center>Parental</center></th>
                    <th width='150px'><center>Alternative</center></th>
                    <th width='150px'><center>Without Pay Leaves</center></th>
                </tr>
                <tr>
                    <td>Allocated</td>
                    <td><?php echo $row[1];  ?></td>
                    <td><?php echo $row[2]; ?></td>
                    <td><?php echo $row[3]; ?></td>
                    <td><?php echo $row[4]; ?></td>
                    <td><?php echo $row[5]; ?></td>
                    <td><?php echo $row[6]; ?></td>
                </tr>
                <tr>
                    <td>Taken</td>
                    <td><?php echo $day_casual;?></td>
                    <td><?php echo $day_sick; ?></td>
                    <td><?php echo $day_annual; ?></td>
                    <td><?php echo $day_maternity; ?></td>
                    <td><?php echo $day_paternity; ?></td>
                    <td><?php echo $day_wpl; ?></td>
                </tr>
                <tr>
                    <td>Existing</td>
                    <td><?php echo $existing_casual;?></td>
                    <td><?php echo $existing_sick; ?></td>
                    <td><?php echo $existing_annual; ?></td>
                    <td><?php echo $existing_maternity; ?></td>
                    <td><?php echo $existing_paternity; ?></td>
                    <td><?php echo $existing_wpl; ?></td>
                </tr>
            </table><br><br>
            <?php

            $query = "SELECT * FROM `leaves` WHERE employeeID=".$_GET['id'];
            $result = mysqli_query($db, $query);
            if($result->num_rows === 0)
            {
                echo "<center>No Records Found!!</center>";
            }
            else
            {
                echo "<table border='1' cellpadding='5' cellspacing='2' align='center'> 
                <tr>
                <th style='color:#1E90FF' width='150px'>From</th>
                <th style='color:#1E90FF' width='150px'>To</th>
                <th style='color:#1E90FF' width='150px'>Number of Days</th>
                <th style='color:#1E90FF' width='150px'>Type</th>
                <th style='color:#1E90FF' style='color:#1E90FF' width='150px'>Reasons</th>
                <th style='color:#1E90FF' width='150px'>Status</th>
                </tr>";


                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";	
                    echo "<td style='color:#585858'><center>" . $row['From Date']. "</center></td>";
                    if(date_create($row['From Date'])>date_create($row['To Date']))
                    {
                        echo "<td><center>No Leaves</center></td>";
                    }
                    else
                    {
                        echo "<td><center>" . $row['To Date'] . "</center></td>";
                    }
                    echo "<td style='color:#585858'><center>".$row['days']."</center></td>";
                    echo "<td style='color:#585858'><center>".$row['Type']."</center></td>";
                    echo "<td style='color:#585858'><center>".$row['Reason']."</center></td>";
                    if($row['status']=='Approved')
                    {
                        echo "<td><center><font color='green'>Approved</font></center></td>";
                    }
                    else if($row['status']=='Rejected')
                    {
                        echo "<td><center><font color='red'>Rejected</font></center></td>";
                    }
                    else if($row['status']=='Pending')
                    {
                        echo "<td><center><font color='blue'>Pending</font></center></td>";
                    }

                    echo "</tr>";
                }	}
                mysqli_close($db);				
                ?>
                <?php// include "html/footer.html"; ?>

                <!--/span-->

                <!--/span-->

            </div>
        </div>
    </body>
    </html>