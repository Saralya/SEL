
<?php
    session_start();
    if(!$_SESSION['name']){
        header("location:admin.php");
    }
?>   
<?php include "connect.php" ?>
<?php
    if(isset($_GET['q'])) {
        $pass = $_GET['q'];
        $id =(int)$_SESSION['id'];
        $sql = "SELECT * from login WHERE Username= ".$id." AND Password=".$pass;
        $result = $db -> query($sql);
        //if (!$result)
          //  trigger_error('Invalid query: ' . $db->error);
        if(empty($result)){
            
            echo "<h5><font color='red'>Wrong Current Password!!</h5>";

        } else {
             
         

            
        }
    }
?>