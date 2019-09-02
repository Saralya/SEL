<?php include "connect.php" ?>
<?php
if(isset($_GET['q'])) {
    $id = $_GET['q'];
    if(!is_numeric($id)){
        echo "Enter valid id!";
    }
    else
    {

        $sql = "SELECT * from employee Where ID= ". $id;
        $result = $db -> query($sql);
        if (!$result)
            trigger_error('Invalid query: ' . $db->error);
        if($result -> num_rows>0){
            $row = $result -> fetch_assoc();
            
            echo "<br><b><font color='blue'>".$row['First Name']." ".$row['Last Name']."</font></b><br><i>Email: ".$row['Email']."</i>";
            $sql = "SELECT * from job_status Where emp_id= ". $id;
            $result = $db -> query($sql);
            $row = $result -> fetch_assoc();
            echo "<br><b>Designation: </b>".$row['curr_designation'];
            $db -> close();
        } else {
            echo "<h5><font color='red'>Doesn't Exist!!</h5>";
        }
    }
}
?>
