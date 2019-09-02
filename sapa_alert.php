<?php 
session_start();
if(!$_SESSION['name']){ 
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php include 'remove_empty_field.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home</title>
        <meta http-equiv="refresh" content="120" >
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include "html/bootstrap.html" ?>
    </head>
    <body>
        <?php include "html/navbar.php" ?>
        <?php //include "html/navbar.html" ?>
        <div class="page-header">
            <h1 align="center">System Engineering Limited</h1>
        </div>
        <div class="container" style="padding-left:20px;padding-right:20px">


            <?php 
    if($_SESSION['name']=='admin') 
    {
            ?>
            <table border="1" class="table table-striped">
                <caption>Employment Details</caption>
                <tr>
                    <th width='70'><center>Image</center></th>
                    <th width='60'><center>ID</center></th>
                    <th width='100'><center>Name</center></th>
                    <th width='100'><center>Department</center></th>
                    <th width='150'><center>Employment Type</center></th>
                    <th width='150'><center>Separation Date</center></th>
                </tr>
                <?php
        $sql="SELECT * FROM job_status";
        $res=mysqli_query($db,$sql);

        while($row=mysqli_fetch_array($res))
        {
           if($row['fired']=='Yes') continue;
            date_default_timezone_set('Asia/Dhaka');            
            $date = date('m/d/Y', time()); 
            $to_date = $row['employee_separation_date'];
            $diff = date_diff(date_create($date), date_create($to_date));
            $a = $diff->days;
            $a =(int)$a;
            if($a==1&&date_create($date)<date_create($to_date))
            {
                $emp_id=$row['emp_id'];
                $sql="SELECT * FROM employee WHERE ID='$emp_id'";
                $result=mysqli_query($db,$sql);
                $data=mysqli_fetch_array($result);
                echo '<tr>';
                echo '<td><img src="'.$data['image'].'" height="50" widtd="50" class="img-rounded"></td>';
                echo '<td>'.$row['emp_id'].'</td>';

                echo '<td><a href="jobdetails.php?id='.$emp_id.'">'.$data['First Name']." ".$data['Last Name'].'</a></td>';
                $sql="SELECT * FROM department WHERE dep_id=".$data['department_id'];
                $result=mysqli_query($db,$sql);
                $line=mysqli_fetch_array($result);
                echo '<td>'.$line['dep_name'].'</td>';
                echo '<td>'.$row['employment_type'].'</td>';
                echo '<td>'.date_format(date_create($row['employee_separation_date']),"d M, Y").'</td>';  
                echo '</tr>';
            }
            else if(date_create($date)>=date_create($to_date))
            {
                $emp_id=$row['emp_id'];
                $sql="SELECT * FROM employee WHERE ID='$emp_id'";
                $result=mysqli_query($db,$sql);
                $data=mysqli_fetch_array($result);
                echo '<tr class="danger">';
                echo '<td><img src="'.$data['image'].'" height="50" widtd="50" class="img-rounded"></td>';
                echo '<td>'.$row['emp_id'].'</td>';

                echo '<td><a href="jobdetails.php?id='.$emp_id.'">'.$data['First Name']." ".$data['Last Name'].'</a></td>';
                $sql="SELECT * FROM department WHERE dep_id=".$data['department_id'];
                $result=mysqli_query($db,$sql);
                $line=mysqli_fetch_array($result);
                echo '<td>'.$line['dep_name'].'</td>';
                echo '<td>'.$row['employment_type'].'</td>';
                echo '<td>'.date_format(date_create($row['employee_separation_date']),"d M, Y").'</td>';  
                echo '</tr>';

            }


        }
                ?>


            </table>

            <?php 
    }

            ?>

            <?php
            if(($_SESSION['reporter']=='Yes'||$_SESSION['head']=='Yes') && $_SESSION['name'] != 'admin')
            {
            ?>
            <table border="1" class="table table-striped">
                <caption>Employment Details</caption>
                <tr>
                    <th width='70'><center>Image</center></th>
                    <th width='60'><center>ID</center></th>
                    <th width='100'><center>Name</center></th>
                    <th width='100'><center>Department</center></th>
                    <th width='150'><center>Employment Type</center></th>
                    <th width='150'><center>Separation Date</center></th>
                </tr>
                <?php
                $h_r=$_SESSION['id'];
                $sql="SELECT * FROM department WHERE head_id='$h_r' or reporter_id='$h_r'";
                $dep_res=mysqli_query($db,$sql);
                while($a=mysqli_fetch_array($dep_res))
                {
                    $dep=$a['dep_id'];
                    $sql="SELECT ID FROM employee WHERE department_id='$dep'";
                    $emp_res=mysqli_query($db, $sql);
                    while($b=mysqli_fetch_array($emp_res))
                    {
                        $emp=$b['ID'];

                        $sql="SELECT * FROM job_status WHERE emp_id='$emp'";
                        $res=mysqli_query($db,$sql);

                        while($row=mysqli_fetch_array($res))
                        {
                            if($row['fired']=='Yes') continue;
                           
                            date_default_timezone_set('Asia/Dhaka');            
                            $date = date('m/d/Y', time()); 
                            $to_date = $row['employee_separation_date'];
                            $diff = date_diff(date_create($date), date_create($to_date));
                            $a = $diff->days;
                            $a =(int)$a;
                            if($a==1&&date_create($date)<date_create($to_date))
                            {
                                $emp_id=$row['emp_id'];
                                $sql="SELECT * FROM employee WHERE ID='$emp_id'";
                                $result=mysqli_query($db,$sql);
                                $data=mysqli_fetch_array($result);
                                echo '<tr>';
                                echo '<td><img src="'.$data['image'].'" height="50" widtd="50" class="img-rounded"></td>';
                                echo '<td>'.$row['emp_id'].'</td>';

                                echo '<td><a href="jobdetails.php?id='.$row['emp_id'].'">'.$data['First Name']." ".$data['Last Name'].'</a></td>';
                                $sql="SELECT * FROM department WHERE dep_id=".$data['department_id'];
                                $result=mysqli_query($db,$sql);
                                $line=mysqli_fetch_array($result);
                                echo '<td>'.$line['dep_name'].'</td>';
                                echo '<td>'.$row['employment_type'].'</td>';
                                echo '<td>'.date_format(date_create($row['employee_separation_date']),"d M, Y").'</td>';  
                                echo '</tr>';
                            }
                            else if(date_create($date)>=date_create($to_date))
                            {
                                $emp_id=$row['emp_id'];
                                $sql="SELECT * FROM employee WHERE ID='$emp_id'";
                                $result=mysqli_query($db,$sql);
                                $data=mysqli_fetch_array($result);
                                echo '<tr class="danger">';
                                echo '<td><img src="'.$data['image'].'" height="50" widtd="50" class="img-rounded"></td>';
                                echo '<td>'.$row['emp_id'].'</td>';

                                echo '<td><a href="jobdetails.php?id='.$row['emp_id'].'">'.$data['First Name']." ".$data['Last Name'].'</a></td>';
                                $sql="SELECT * FROM department WHERE dep_id=".$data['department_id'];
                                $result=mysqli_query($db,$sql);
                                $line=mysqli_fetch_array($result);
                                echo '<td>'.$line['dep_name'].'</td>';
                                echo '<td>'.$row['employment_type'].'</td>';
                                echo '<td>'.date_format(date_create($row['employee_separation_date']),"d M, Y").'</td>';  
                                echo '</tr>';

                            }


                        }

                    }
                }

            }
            else
            {

            }
                ?>

                </div>
            </body>
        </html>
