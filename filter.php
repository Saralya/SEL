<?php
include "connect.php";
if(isset($_POST["from_date"], $_POST["to_date"]))
{
	$output= '';
	$result= mysqli_query($db,"SELECT * FROM history_department WHERE `date` BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'");
	$output .= '
	<table class="table table-bordered">
	<tr>
	<th>Employee</th>
	<th>Effective Date</th>
	</tr>
	';
	if($result -> num_rows > 0)
	{
		while ($row=mysqli_fetch_array($result)) {
		$output .= "<tr>
						<td>".$row['emp_id']."</td>
						<td>".$row['date']."</td>
						</tr>";


		}

	}
	else
	{
		$output .= "<tr><td colspan='2'>No Results Found</td></tr>";
	}
	$output .= "</table>";
	echo $output;

}

?>