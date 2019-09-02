<?php
session_start();
include "connect.php";
date_default_timezone_set('Asia/Dhaka');
if(isset($_POST["from_date"], $_POST["to_date"], $_POST["id"]))
{
	$emp_id=$_POST['id'];
	$output= '';
	$res= mysqli_query($db,"SELECT * FROM history_department WHERE emp_id='$emp_id' AND `date` BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' ORDER BY `serial` DESC");
	$output .= "<table align='center' class='table table-striped table-bordered'>";
	$output .= "<tr>";
	$output .= "<th width='150px'>Entrier</th>";
	$output .= "<th width='70px'>Entry Date</th>";
	$output .= "<th width='150px'>From</th>";
	$output .= "<th width='150px'>To</th>";
	$output .= "<th width='70px'>Approval Date</th>";
	$output .= "<th width='70px'>Effective Date</th>";
	$output .= "<th width='150px'>Reference</th>";
	$output .= "<th width='25%'>Remarks</th>";
	$output .= "<th width='5px'>Edit</th>";
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
                    $a=$row['from'];
                    $sql = "SELECT * FROM department WHERE dep_id='$a'";
                    $result=mysqli_query($db, $sql);
                    $line=mysqli_fetch_array($result);
                    $output .= "<td>".$line['dep_name']."</td>";
                    $sql = "SELECT * FROM department WHERE dep_id=".$row['tos'];
                    $result=mysqli_query($db, $sql);
                    $line=mysqli_fetch_array($result);
                    $output .= "<td>".$line['dep_name']."</td>";

                    $output .= "<td>".date_format(date_create($row['approval_date']),"M d, Y")."</td>";
                    $output .= "<td>".date_format(date_create($row['date']),"M d, Y")."</td>";
                    $output .= "<td>".$row['ref']."</td>";
                    $output .= "<td><pre>".$row['remarks']."</pre></td>";
                    $output .= "<td><a href='edit_remark_dep.php?id=".$row['serial']."' class='glyphicon glyphicon-pencil'></a></td>";
                    $output .= "</tr>";


		}

	}
	else
	{
		$output .= "<tr class='alert-danger'><td colspan='9'>No Results Found</td></tr>";
	}
	$output .= "</table>";
	echo $output;

}

?>