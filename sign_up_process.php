<!DOCTYPE html>
<html>
<head>
<?php include "html/bootstrap.html" ?>

</head>
<body>
<div class="container">
<div class="row vertical-offset-100">
<div class="col-md-4 col-md-offset-4">
<div class="panel panel-default">
<div class="panel-heading">
</div>
<div class="panel-body">
<?php
include "connect.php";
if(isset($_GET['submit'])) {
$id = $_GET['id'];
$pass = $_GET['password'];
$sql ="SELECT * FROM `employee` WHERE ID=".$id;
$res = $db -> query($sql);
if(($res -> num_rows)>0)
{
$sql = "SELECT * FROM login WHERE Username = '$id'";
$res = $db -> query($sql);
if(($res -> num_rows)>0) {
echo "You have already signed up!\n";
echo "Please log in ";
echo "<a href=admin.php>here</a>";
}
else {
if($pass == ""){
$pass='password';
}
$sql = "INSERT INTO login(`username`,`Password`)
VALUES('$id', '$pass')";
$db -> query($sql);
echo "You have successfully signed up!\n";
echo "Please log in ";
echo "<a href=admin.php>here</a>";
}
}
else
{
    echo "No employee with this ID!!!";
    echo "<a href=signup.php>Try Again!</a>";
}
}
?>
</div>
</div>
</div>
</div>
</div>
</body>
</html>

