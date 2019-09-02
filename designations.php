<?php
session_start();
if(!($_SESSION['name']=='admin')){
    header("location:admin.php");
}
include "connect.php";
include "html/bootstrap.html";
?>
<html>
    <head>
        <title>Designtions</title>
    </head>
    <body>
        <?php include "html/navbar.php"; ?>
        <div class="container">
            <h2><center><a>Designtions in Departments</a></center></h2>
            <br />
            <table class="table table-bordered">
                <tr>
                    <th>Department</th>
                    <th>Designtions</th>
                </tr>
                <?php
                $result=mysqli_query($db,"SELECT * FROM department");
                while($row=mysqli_fetch_array($result))
                {
                    echo "<tr>";
                    $dep_name=$row['dep_name'];
                    $dep_id=$row['dep_id'];
                    echo "<td>".$dep_name."</td>";
                    echo "<td>";
                    $des_res=mysqli_query($db,"SELECT * FROM designation");
                    while($des=mysqli_fetch_array($des_res))
                    {   
                        $des_name=$des['designations'];
                        $num=mysqli_query($db,"SELECT COUNT(curr_designation) AS num_des FROM job_status WHERE curr_designation='$des_name' AND curr_department='$dep_id'");
                        if($num -> num_rows > 0)
                        {
                            $num_des=mysqli_fetch_array($num);
                            $num_des=$num_des['num_des'];
                            if($num_des!=0)
                            {
                                echo $des_name." (<a>".$num_des."</a>)<br>";  
                            }

                        }
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </body>
</html>