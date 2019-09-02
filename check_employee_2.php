<?php
    session_start();
    if(!$_SESSION['name']){
        header("location:admin.php");
    }
?>
<?php include "connect.php" ?>
<?php
    if(isset($_GET['q'])) {
        $id = $_GET['q'];
        $sql = "SELECT * from employee Where ID= ". $id;
        $result = $db -> query($sql);
        if (!$result)
            trigger_error('Invalid query: ' . $db->error);
        if($result -> num_rows>0){
        echo "<h5><font color='red'>Employee ID Exists!!</h5>";
            $db -> close();
        } 
    }
?>