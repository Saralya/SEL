<?php
   session_start();
    if(!($_SESSION['name']=='admin'||$_SESSION['name']=='head'||$_SESSION['name']='reporter')){
        header("location:admin.php");
    }
?>
<?php include 'connect.php'; ?>
<?php include "html/bootstrap.html" ?>
<?php //include "html/navbar.html"; ?>


<!DOCTYPE html>


<html>
    
    <body><?php include "html/navbar.php" ?>
<div class="row row-offcanvas row-offcanvas-left">

<div class="container-fluid">
    
        
		<br><h3 style="color:#00BFFF">On Leave</h3><br>  
<div class="row">
<div class="col-6 col-sm-6 col-lg-8">
    <table border='1' cellpadding='5' cellspacing='2' align='center'>
        <tr><th style="color:#1E90FF" width='150px'>Employee ID</th>
        <th style="color:#1E90FF" width='150px'>Name</th>
        <th style="color:#1E90FF" width='150px'>From</th>
        <th style="color:#1E90FF" width='150px'>To</th>
        </tr>
    
    <?php
    date_default_timezone_set('Asia/Dhaka');
    $date = date('Y-m-d', time());
    $sql="SELECT leaves.*, employee.* FROM leaves JOIN employee ON leaves.EmployeeID=employee.ID WHERE employee.department_id=".$_GET['id']." AND leaves.status='Approved' AND leaves.`From Date`<='$date' AND leaves.`To Date`>='$date'";
    $result=mysqli_query($db, $sql);
    while($row=mysqli_fetch_array($result))
    {
        echo "<tr>";
        echo "<td style='color:#585858'>".$row['EmployeeID']."</td>";
        echo "<td style='color:#585858'>".$row['First Name']." ".$row['Last Name']."</td>";
        echo "<td style='color:#585858'>".$row['From Date']."</td>";
        echo "<td style='color:#585858'>".$row['To Date']."</td>";
        echo "</tr>";
    }    
    ?>
    </table>
    
    </div></div></div></div></body></html>