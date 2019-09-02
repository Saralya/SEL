<?php 

session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php include "html/bootstrap.html" ?>
<?php //include "html/navbar.html"; ?>


<!DOCTYPE html>


<html>
    <head>
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
    </head>
    <body>
        <?php include "html/navbar.php" ?>


        <div class="container style='padding-left:30px; padding-right:30px'">

            <?php// include "html/sidebar.php" ?>
            <br><h2>Employee List of System Engineering Limited</h2><br>  
            <div class="">
                <div class="">

                    <?php 
    $sql="SELECT * FROM `department` ORDER BY `dep_name`";
$result=mysqli_query($db, $sql);    
while($dep=mysqli_fetch_array($result))
{

    $query="SELECT * FROM employee WHERE `department_id`=".$dep['dep_id'];
    $res_dep=mysqli_query($db, $query);
    if($res_dep->num_rows === 0)
    {

    }
    else
    {
        echo "<font size='5px'><b><font color='#3B3738'>"." ".$dep['dep_name']."</font></b></font><br>";
        echo '<table width="100%" class="table table-striped">';
        echo '<tr class="tr_header">';
        echo '<th>Image</th>';
        echo '<th>Employee ID</th>';
        echo '<th >Name</th>';
        echo '<th >Designation</th>';
        echo '<th>Head of Department</th>'; 
        echo '<th>Reporter of Department</th>'; 
        echo '</tr>';
        while($fetch=mysqli_fetch_array($res_dep))
        {


            $name = $fetch['First Name']." ".$fetch['Last Name'];
            $id = $fetch['ID'];
            $dep_id= $fetch['department_id'];
            $query = "SELECT * FROM `job_status` WHERE emp_id =".$id;
            $res_des = mysqli_query($db, $query);
            $row_des = mysqli_fetch_array($res_des);
            $designation = $row_des[2];
            $sql_dep ="SELECT dep_name FROM department WHERE dep_id='$dep_id'"; 
            $res = mysqli_query($db, $sql_dep);
            $dep_name= mysqli_fetch_array($res);
            $sql_managing = "SELECT * FROM department WHERE head_id=".$fetch['ID']; 
            $result_managing = mysqli_query($db, $sql_managing); 
            $sql_managing_1 = "SELECT * FROM department WHERE reporter_id=".$fetch['ID']; 
            $result_managing_1 = mysqli_query($db, $sql_managing_1);
                    ?>
                    <tr>
                        <td><img src="<?php echo $fetch['image']; ?>" height="50" width="50" class="img-rounded"></td>
                        <td><?php echo $id; ?></td>
                        <td><a href="jobdetails.php?id=<?php echo $id; ?>" ><?php echo $name ?></a></td>
                        <td><?php echo $designation ?></td>
                        <td><?php while($managing = mysqli_fetch_array($result_managing)){echo $managing['dep_name']."<br>";} ?></td>
                        <td><?php while($managing = mysqli_fetch_array($result_managing_1)){echo $managing['dep_name']."<br>";} ?></td>
                    </tr>

                    <?php

        }
                    ?>
                    </table><br><br>
                <?php     
    }
}


                ?>
            </div></div></div></body></html>