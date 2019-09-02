<?php
session_start();
include "connect.php";
date_default_timezone_set('Asia/Dhaka');
if(isset($_POST["from_date"], $_POST["to_date"], $_POST["id"]))
{
    $emp_id=$_POST['id'];
    $output= '';
    $res= mysqli_query($db,"SELECT * FROM history_designation WHERE emp_id='$emp_id' AND `date` BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' ORDER BY `serial` DESC");
    echo "<table align='center' class='table table-striped table-bordered'> ";
    echo "<tr>";
    echo "<th width='150px'>Entrier</th>";
    echo "<th width='150px'>Entry Date</th>";
    //echo "<th width='150px'>From</th>";
    echo "<th width='150px'>To</th>";
    echo "<th width='150px'>Approval Date</th>";
    echo "<th width='150px'>Effective Date</th>";
    echo "<th width='150px'>Reference</th>";
    echo "<th width='150px'>Remarks</th>";
    echo "<th width='20px'>Edit</th>";
    echo "</tr>";

    if($res -> num_rows > 0)
    {
        while ($row=mysqli_fetch_array($res)) {
            echo "<tr>";
            if($row[2]=='10001')
            {
                echo "<td>Admin</td>";
            }
            else
            {
                $id=$row[2];
                $sql ="SELECT * FROM employee WHERE ID='$id'";
                $result=mysqli_query($db, $sql);
                $line=mysqli_fetch_array($result);
                echo "<td>".$line['First Name']." ".$line['Last Name']."</td>";
            }
            echo "<td>".date_format(date_create($row['entry_date']),"M d, Y")."</td>"; 

            //echo "<td>".$row[4]."</td>";
            echo "<td>".$row['to_des']."</td>";

            echo "<td>".date_format(date_create($row['approval_date']),"M d, Y")."</td>";
            echo "<td>".date_format(date_create($row['date']),"M d, Y")."</td>";
            echo "<td>".$row['ref']."</td>";
            echo "<td><pre>".$row['remarks']."</pre></td>";
            echo "<td><a href='edit_remark_des.php?id=".$row['serial']."' class='glyphicon glyphicon-pencil'></a></td>";
            echo "</tr>";
        }
    }
    else
    {
        $output .= "<tr class='alert-danger'><td colspan='8'>No Results Found</td></tr>";
    }
    $output .= "</table>";
    echo $output;

}

?>