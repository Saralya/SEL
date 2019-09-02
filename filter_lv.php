<?php
session_start();
include "connect.php";
date_default_timezone_set('Asia/Dhaka');
if(isset($_POST["from_date"], $_POST["to_date"], $_POST["id"]))
{
	$output= '';
	$result= mysqli_query($db,"SELECT * FROM leaves WHERE EmployeeID='".$_POST['id']."' AND `apply_date` BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."' ORDER BY LeaveID DESC");

	$output .= "<table cellpadding='5' cellspacing='2' align='center' class='table table-striped table-bordered'> 
	<tr>
	<th width='70px'><center>Apply Date</center></th>
	<th width='70px'><center>From</center></th>
	<th width='70px'><center>To</center></th>
	<th width=''><center>Days</center></th>

	<th width='70px'><center>Action Date</center></th>
	<th width=''><center>Type</center></th>
	<th width='15%'><center>Reasons</center></th>
	<th width=''><center>Status</center></th>
	<th width='70px'><center>Joining Date</center></th>
	<th width=''><center>Late</center></th>
	<th width='25%'><center>Remarks</center></th>
	<th width='150px'><center>Reference</center></th>";
	if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry') $output .= "<th width='20px'>Edit</th>";
			$output .= "</tr>";
	if($result -> num_rows > 0)
	{
		while ($row=mysqli_fetch_array($result)) {

			
				$output .= "<tr>";
				$output .= "<td><center>" . date_format(date_create($row['apply_date']),"M d, Y"). "</center></td>";
				$output .= "<td><center>" . date_format(date_create($row['From Date']),"M d, Y"). "</center></td>";
				if(date_create($row['From Date'])>date_create($row['To Date']))
				{
					$output .= "<td><center>No Leaves</center></td>";
				}
				else
				{
					$output .= "<td><center>" . date_format(date_create($row['To Date']),"M d, Y"). "</center></td>";
				}
				$output .= "<td><center>".$row['days']."</center></td>";
				if($row['approval_date']=='0000-00-00')
				{
					$output .= "<td><center>---------</center></td>";
				}
				else
				{
					$output .= "<td><center>" . date_format(date_create($row['approval_date']),"M d, Y"). "</center></td>";
				}

				$output .= "<td><center>".$row['Type']."</center></td>";
				$output .= "<td><center>".$row['Reason']."</center></td>";
				if($row['status']=='Approved')
				{
					$output .= "<td><center><font color='green'>Approved</font></center></td>";
				}
				else if($row['status']=='Rejected')
				{
					$output .= "<td><center><font color='red'>Rejected</font></center></td>";
				}
				else if($row['status']=='Pending')
				{
					$output .= "<td><center><font color='blue'>Pending</font></center></td>";
				}
				if($row['joined']=='No')
				{
					$output .= "<td><center>Didn't Joined</center></td>";
				}
				else
				{
					$output .= "<td><center>".date_format(date_create($row['joining_date']),"d M, Y")."</center></td>";
				}

				$today=date('Y-m-d',time());
				$today=date( 'Y-m-d', strtotime( $today . ' -1 day' ) );
				if(date_create($today)>date_create($row['To Date'])&&$row['joined']=='No'&&$row['status']=='Approved')
				{
					$diff = date_diff(date_create($today),date_create($row['To Date']));
					$a = $diff->days;
					$output .= "<td><center>".$a."</center></td>";

				}
				else
				{
					$output .= "<td><center>".$row['late']."</center></td>"; 
				}

				$output .= "<td><pre>".$row['remarks']."</pre></td>";
				$output .= "<td><center>".$row['ref']."</center></td>";
				if($_SESSION['name']=='admin'||$_SESSION['head']=='Yes'||$_SESSION['reporter']=='Yes')
				{
					if($row['joined']=='Yes')   $output .= "<td><a href='edit_remark.php?id=".$row['LeaveID']."' class='glyphicon glyphicon-pencil'></a></td>";
					else "<td></td>";
				}
				$output .= "</tr>";
			


		}

	}
	else
	{
		$output .= "<tr><td colspan='12'>No Results Found</td></tr>";
	}
	$output .= "</table>";
	echo $output;

}

?>