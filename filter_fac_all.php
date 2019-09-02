<?php
session_start();
include "connect.php";
date_default_timezone_set('Asia/Dhaka');
if(isset($_POST["id"]))
{
    $emp_id=$_POST['id'];
    $output= '';
    $res= mysqli_query($db,"SELECT * FROM history_facility WHERE emp_id='$emp_id' ORDER BY `serial` DESC");
    $output .= "<table align='center' class='table table-striped table-bordered'>";
    $output .= "<tr>";
    $output .= "<th width=''>Entrier</th>";
    $output .= "<th width='10%'>Entry Date</th>"; 
    $output .= "<th width='12%'>Type</th>"; 
    $output .= "<th width='24%'>Facility</th>";
    $output .= "<th width='24%'>Remarks</th>";
    $output .= "<th width='20%'>Reference</th>"; 
    $output .= "<th width='20px'>Edit</th>";
    $output .= "</tr>"; 

    if($res -> num_rows > 0)
    {
        while ($row=mysqli_fetch_array($res)) {
            $output .= "<tr>";
            if($row[2]=='10001')
            {
                $output .= "<td>Admin</td>";
            }
            else
            {
                $id=$row[2];
                $sql ="SELECT * FROM employee WHERE ID='$id'";
                $result=mysqli_query($db, $sql);
                $line=mysqli_fetch_array($result);
                $output .= "<td>".$line['First Name']." ".$line['Last Name']."</td>";
            }

            $output .= "<td>".date_format(date_create($row['entry_date']),"M d, Y")."</td>";


            $output .= "<td>".$row['type']."</td>";
            $output .= "<td><pre>".$row['facility']."</pre></td>";
            $output .= "<td><pre>".$row['remarks']."</pre></td>";
            $output .= "<td>".$row['ref']."</td>";

            $output .= "<td><a href='edit_remark_fac.php?id=".$row['serial']."' class='glyphicon glyphicon-pencil'></a></td>";
            $output .= "</tr>";
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