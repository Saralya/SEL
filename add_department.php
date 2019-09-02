<?php  
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php //include "html/navbar.html"; ?>
<?php include "html/bootstrap.html"; ?>
<?php include "connect.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Department</title>
    <script>
        function showUser(str) 
        {
            if (str == "") 
            {
                document.getElementById("search").innerHTML = "";
                return;
            } 
            else 
            { 
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() 
                {
                    if (this.readyState == 4 && this.status == 200) 
                    {
                        document.getElementById("search").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET","check_head.php?q="+str,true);
                xmlhttp.send();
            }
        }
        function showUser_2(str) {
            if (str == "") {
                document.getElementById("search_2").innerHTML = "";
                return;
            } else { 
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("search_2").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET","check_head.php?q="+str,true);
                xmlhttp.send();
            }
        }
    </script>
</head>
<body>
    <?php include "html/navbar.php" ?>
    <div style="padding-left:50px;padding-right:10px">
        <div class="row row-offcanvas row-offcanvas-left">
            <div class="container">
              <div class="row">
                <div class="col-sm-4">
                    <br><h3 style="">New Department</h3><br> 
                    <form action="" method="post">
                        Department Name: <input type="text" name="name" pattern="[^.]+" class="form-control" style='width:300' required><br><br>
                        Head ID: <input type="text" name="head" value="0001" disabled="disabled" class="form-control" style='width:300'> <br>
                        Reporter ID: <input type="text" name="reporter" value="0001" disabled="disabled" class="form-control" style='width:300'><br><br>
                        Under Department: 
                        <?php 
                        echo "<select name='under' class='form-control' style='width:300'>";
                                //echo '<option value="" selected disabled hidden>Choose here</option>';
                        $sql = "SELECT * FROM `department` ORDER BY `dep_name`";
                        $result=mysqli_query($db, $sql);
                                //echo "<option>Head</option>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            if($row['dep_name']=='Head Office')
                            {
                                echo "<option value='" . $row['dep_id'] ."' selected='selected'>" . $row['dep_name']."</option>";
                            }
                            else
                            {
                                echo "<option value='" . $row['dep_id'] ."'>" . $row['dep_name']."</option>";
                            }
                        }
                        echo "</select><br>";
                        ?>
                        <br>
                        <input type="submit" name="submit" value="Submit" class="btn btn-info">
                    </form>
                </div>
                <div class="col-sm-5" >
                 <?php  


                 $head = $update['head_id'];
                 $query2 = "SELECT * FROM `employee` WHERE ID='0001'";
                 $result2 = mysqli_query($db, $query2);
                 $update2= mysqli_fetch_array($result2);
                 $query3 = "SELECT * FROM `job_status` WHERE emp_id='0001'";
                 $result3= mysqli_query($db, $query3);
                 $update3 = mysqli_fetch_array($result3);     
                 ?>

                 <div  style="padding-top: 100px">
                     <div class="panel panel-primary">
                        <div class="panel-heading">Head and Reporter</div>

                        <div class="panel-body">
                            <div class="media">
                                <div class="media-left">
                                    <img src="<?php echo $update2['image'];?>" class="media-object" style="width:60px">
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo " ".$update2['First Name']." ".$update2['Last Name']; ?></h4>
                                    <p><?php echo $update3['curr_designation']; ?> <br>
                                        <?php echo " ".$update2['Email']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $under_dep = (int)$_POST['under'];
    $sql = "SELECT * FROM `department` WHERE dep_id=".$under_dep;
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    $final_dep = $row['dep_name'].".".$name;
    $query_id = "SELECT * FROM `employee` WHERE ID='0001'";
    $result = mysqli_query($db, $query_id);
    $field=mysqli_fetch_assoc($result);
    $Email=$field['Email'];



    $query = "INSERT INTO `department`(`dep_name`, `head_id`, `reporting_mail`, `reporter_id`, `reporting_mail_2`) VALUES ('$final_dep','0001', '$Email','0001','$Email')";

    if(!mysqli_query($db, $query))
    {
        die('Error!! '.mysqli_error($db));

    }


    
    redirect("department_list.php");
}

?>

<?php
function redirect($url){
    if (!headers_sent())
    {    
        header('Location: '.$url);
        exit;
    } 
    else
    {  
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
} 

?>


</body>
</html>