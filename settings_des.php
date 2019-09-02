<?php
session_start();
if(!($_SESSION['name']=='admin')){
	header("location:admin.php");
}
?>
<?php include 'connect.php';?>
<!DOCTYPE html>
<html>
<head>
	<title>Settings</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
	<style>
	table {
		border:none;
		border-collapse: collapse;
	}

	table td {
		border-left: 2px solid #f5f5f5;
		border-right: 2px solid #f5f5f5;
	}

	table th {
		border-left: 2px solid #f5f5f5;
		border-right: 2px solid #f5f5f5;
	}

	table td:first-child {
		border-left: none;
	}

	table td:last-child {
		border-right: none;
	}

	table th:first-child {
		border-left: none;
	}

	table th:last-child {
		border-right: none;
	}
</style>
<script>
	$(document).ready(function(){
		$("#myInput").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#myTable tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	});
</script>
</head>

<?php
if(isset($_POST['add']))
{
	$designation=mysqli_real_escape_string($db,$_POST['des']);
	$sql="INSERT INTO `designation`(`designations`) VALUES ('$designation')";
	mysqli_query($db,$sql);
}
if(isset($_POST['delete']))
{
	$id=$_POST['id'];
	//echo $id;
	$sql="DELETE FROM `designation` WHERE `serial`='$id'";
	mysqli_query($db,$sql);
	echo mysqli_error($db);
}
?>
<body>
	<?php include "html/navbar.php"; ?>
	<div class="container" style="padding-top: 30px">
		<h2><center>Add or Delete Designations</center></h2>
		<div class="row" style="padding-top:20px">
			<div class="col-sm-6">
				<table class="table table-striped" id="emp_table">
					<tr class="tr_header">
						<thaed>
							
							<th><center>Designation</center></th>
							<th width="30px"><center>Action</center></th>
						</thaed>
					</tr>
					<tbody id="myTable">
						<?php
						$sql="SELECT * FROM designation ORDER BY designations";
						$result=mysqli_query($db,$sql);
						$count=1;
						while ($row=mysqli_fetch_array($result)) {
							echo "<tr>";
							
							echo "<td>".$row['designations']."</td>";
							echo "<td><center><form action='' method='post'><input type='hidden' value='".$row['serial']."' name='id'><input type='submit' name='delete' value='Delete' class='btn btn-danger'></form></center></td>";
							echo "</tr>";
							$count++;
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="col-sm-6" style="padding-top:40px;padding-left: 50px;padding-right: 200px">
				<form action="" method="post">
					<input name="des" type="text" class="form-control" placeholder="Add New Designation Here......" id="myInput"><br>
					<input type="submit" name="add" value="Add" class="btn btn-success">
				</form>
			</div>
		</div>
	</div>

</body>
</html>
<?php
mysqli_close($db);
?>