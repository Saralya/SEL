<?php
session_start();
if(!$_SESSION['name']){ 
	header("location:welcome_page.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'connect.php'; ?>
	<?php include "html/bootstrap.html"; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	.accordion {
		background-color: #eee;
		color: #444;
		cursor: pointer;
		padding: 18px;
		width: 100%;
		border: none;
		text-align: left;
		outline: none;
		font-size: 15px;
		transition: 0.4s;
	}

	.active_1, .accordion:hover {
		background-color: #ccc;
	}

	.accordion:after {
		content: '\002B';
		color: #777;
		font-weight: bold;
		float: right;
		margin-left: 5px;
	}

	.active_1:after {
		content: "\2212";
	}

	.panel {
		padding: 0 18px;
		background-color: white;
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.2s ease-out;
	}
</style>
</head>
<body>
	<?php include "html/navbar.php"?>
	<div class="container">

		<h2>Allocate Leaves</h2>
				<?php 
		if(isset($_POST['submit']))
		{

			$casual_leave=(int)$_POST['casual_leave'];
			$sick_leave=(int)$_POST['sick_leave'];
			$annual_leave=(int)$_POST['annual_leave'];
			$maternity_leave=(int)$_POST['maternity_leave'];
			$paternity_leave=(int)$_POST['paternity_leave'];
			$wpl=(int)$_POST['wpl'];
			$year=mysqli_real_escape_string($db,$_POST['year']);

			$sql="SELECT * FROM leave_types WHERE year='$year'";
			$res=mysqli_query($db,$sql);
			if($res->num_rows>0)
			{

				$query="UPDATE `leave_types` SET `casual`='$casual_leave',`sick`='$sick_leave',`annual`='$annual_leave',`maternity`='$maternity_leave',`paternity`='$paternity_leave',`wpl`='$wpl' WHERE `year`='$year'";
				mysqli_query($db, $query);
			}
			else
			{
				$sql="SELECT ID FROM employee";
				$res=mysqli_query($db,$sql);
				while ($row=mysqli_fetch_array($res)) 
				{
					$emp_id=$row['ID'];
					$query = "INSERT INTO `leave_types`(`emp_id`, `casual`, `sick`, `annual`, `maternity`, `paternity`, `wpl`,`year`) VALUES ('$emp_id', '$casual_leave','$sick_leave','$annual_leave', '$maternity_leave', '$paternity_leave', '$wpl','$year')";
					mysqli_query($db, $query);

				}
			}
			echo "<div class='alert alert-success'><center>Leaves Allocated</center></div>";
		}


		?>
		<button class="accordion">Allocate to all</button>
		<div class="panel">
			<br><br>
			<form action="" method="post" class="form-inline">
				<div class="form-group"> Casual: <input type="number" class="form-control" value="0" style="width:80px" name="casual_leave" value="" min="0" step="1"></div>
				<div class="form-group"> Annual: <input type="number" class="form-control" value="0" style="width:80px" name="annual_leave" value="" min="0" step="1"></div>
				<div class="form-group"> Sick: <input type="number" class="form-control" value="0" style="width:80px" name="sick_leave" value="" min="0" step="1"></div>
				<div class="form-group"> Parental: <input type="number" class="form-control" value="0" style="width:80px" name="maternity_leave" value="" min="0" step="1"></div>
				<div class="form-group"> Alternative: <input type="number" class="form-control" value="0" style="width:80px" name="paternity_leave" value="" min="0" step="1"></div>
				<div class="form-group"> Without Pay Leaves: <input type="number" value="0"  class="form-control" style="width:80px" name="wpl" value="" min="0" step="1"></div>
				<br><br>
				<label>Year:&nbsp; </label> <select name="year" class="form-control" style="width:100px" required="">
					<option value="">----</option>
					<?php
					
					for($i=1995;$i<=2100;$i++)
					{
						echo "<option value='".$i."'>".$i."</option>";
					}

					?>
				</select>
				<br><br>
				<button type="submit" name="submit" value="Confirm" class="btn btn-info">Confirm</button>
			</form>
			<br><br>
		</div>



	</div>
	<script>
		var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
			acc[i].addEventListener("click", function() {
				this.classList.toggle("active_1");
				var panel = this.nextElementSibling;
				if (panel.style.maxHeight){
					panel.style.maxHeight = null;
				} else {
					panel.style.maxHeight = panel.scrollHeight + "px";
				} 
			});
		}
		function showUser(str) {
			if (str == "") {
				document.getElementById("search").innerHTML = "";
				return;
			} else { 
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("search").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("GET","check_employee.php?q="+str,true);
				xmlhttp.send();
			}
		}
	</script>

</body>
</html>

<!--

	<h3 style="color:#00BFFF">Allocated Leaves:</h3><br><br>
	<form method="post" action="">  
		<div class="form-group"> Casual: <input type="number" class="form-control" style="width:300px" name="casual" value="" min="0" step="1"></div>
		<div class="form-group"> Annual: <input type="number" class="form-control" style="width:300px" name="annual" value="" min="0" step="1"></div>
		<div class="form-group"> Sick: <input type="number" class="form-control" style="width:300px" name="sick" value="" min="0" step="1"></div>
		<div class="form-group"> Maternity: <input type="number" class="form-control" style="width:300px" name="maternity" value="" min="0" step="1"></div>
		<div class="form-group"> Paternity: <input type="number" class="form-control" style="width:300px" name="paternity" value="" min="0" step="1"></div>
		<div class="form-group"> Without Pay Leaves: <input type="number"  class="form-control" style="width:300px"name="wpl" value="" min="0" step="1"></div>
		<button type="submit" name="submit" value="Confirm" class="btn btn-info">Confirm</button>
	</form>

	-->