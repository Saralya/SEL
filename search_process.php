<?php
include 'connect.php';
if(isset($_GET['submit'])) {
    $search = $_GET['search'];
    $type = $_GET['type'];
    echo "<table border='1' cellpadding='5' cellspacing='2' align='center'> 
		<tr>
		<th width='100px'>First Name</th> 
		<th width='150px'>Last Name</th>
		<th width='150px'>Email</th>
		<th width='150px'>Salary</th>
		<th width='150px'>Joining Date</th>
		<th width='150px'>District</th>
		<th width='150px'>Blood Group</th>
		<th width='150px'>Mobile Number</th>
		<th width='150px'>Department</th>
		<th width='150px'>Designation</th>
		<th width='150px'>Degree</th>
		</tr>";
    
    if($type = 'First Name' || $type='Last Name' || $type='Email' || $type ='Blood Group' || $type='Cell Phone'){
        $query = "SELECT * FROM employee WHERE '$type'='$search'";
    }
    
    $result = mysqli_query($db, $query);
    while($row = $result->fetch_array()) {
        echo "<tr>";
        echo "<td><center>" . $row['First Name'] . "</center></td>";	
        echo "<td><center>" . $row['Last Name']. "</center></td>";
        echo "<td><center>" . $row['Email']. "</center></td>";
        echo "<td><center>" . $row['Blood Group']. "</center></td>";
        echo "<td><center>" . $row['Cell Phone']. "</center></td>";
        echo "</tr>";
        
    }
}   
?>