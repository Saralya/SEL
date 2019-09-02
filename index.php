<?php
session_start();
if(!$_SESSION['name']){
    header("location:welcome_page.php");
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
        <div class="container" style="">
            <div class="row">
                <div class="col-sm-2">
                    <?php


    if($_SESSION['name']=='admin') 
    {
        $sql="SELECT * FROM leaves";
        $res=mysqli_query($db,$sql);
        while($row=mysqli_fetch_array($res))
        {
            $emp_id=$row['EmployeeID'];
            $fired=mysqli_query($db,"SELECT fired FROM job_status WHERE emp_id='$emp_id'");
            $fired=mysqli_fetch_array($fired);
            if($fired['fired']=='Yes') continue;
            date_default_timezone_set('Asia/Dhaka');            
            $date = date('m/d/Y', time()); 
            $to_date = $row['To Date'];
            $diff = date_diff(date_create($date), date_create($to_date));
            $a = $diff->days;
            $a =(int)$a;
            if($a==1&&$row['status']=='Approved'&&date_create($date)<date_create($to_date) && $row['joined']=='No')
            { 
                echo "<div class='panel panel-danger' style='width:150px;background-color:#A7EDAC'>
                                        <div class='panel-heading'><center>Leave Alert!!</center></div>
                                        <div class='panel-body'><center><form action='leave_alert.php' method='post'>
                                        <input type='image' src='animat-bell-color.gif' height='90px'/></form></center></div>
                                    </div>";

                break;
            }
            else if($row['status']=='Approved'&&date_create($date)==date_create($to_date) && $row['joined']=='No')
            {
                echo "<div class='panel panel-danger' style='width:150px; background-color:#A7EDAC'>
                                        <div class='panel-heading'><center>Leave Alert!!</center></div>
                                        <div class='panel-body'><center><form action='leave_alert.php' method='post'>
                                        <input type='image' src='animat-bell-color.gif' height='90px'/></form></center></div>
                                    </div>";

                break;


            }
            else if($row['status']=='Approved'&&date_create($date)>date_create($to_date) && $row['joined']=='No')
            {
                echo "<div class='panel panel-danger' style='width:150px;background-color:#A7EDAC'>
                                        <div class='panel-heading'><center>Leave Alert!!</center></div>
                                        <div class='panel-body'><center><form action='leave_alert.php' method='post'>
                                        <input type='image' src='animat-bell-color.gif' height='90px'/></form></center></div>
                                    </div>";
                break;

            }
        }
    }
                    ?>

                    <?php
                    if(($_SESSION['reporter']=='Yes'||$_SESSION['head']=='Yes') && $_SESSION['name'] != 'admin')
                    {
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
                                $sql="SELECT * FROM leaves WHERE EmployeeID='$emp'";
                                $res=mysqli_query($db,$sql);
                                while($row=mysqli_fetch_array($res))
                                {
                                    $emp_id=$row['EmployeeID'];
                                    $fired=mysqli_query($db,"SELECT fired FROM job_status WHERE emp_id='$emp_id'");
                                    $fired=mysqli_fetch_array($fired);
                                    if($fired['fired']=='Yes') continue;
                                    date_default_timezone_set('Asia/Dhaka');            
                                    $date = date('m/d/Y', time()); 
                                    $to_date = $row['To Date'];
                                    $diff = date_diff(date_create($date), date_create($to_date));
                                    $a = $diff->days;
                                    $a =(int)$a;
                                    if($a==1&&$row['status']=='Approved'&&date_create($date)<date_create($to_date) && $row['joined']=='No')
                                    {
                                        echo "<div class='panel panel-danger' style='width:150px;background-color:#A7EDAC'>
                                        <div class='panel-heading'><center>Leave Alert!!</center></div>
                                        <div class='panel-body'><center><form action='leave_alert.php' method='post'>
                                        <input type='image' src='animat-bell-color.gif' height='90px'/></form></center></div>
                                    </div>";

                                        break 3;
                                    }
                                    else if($row['status']=='Approved'&&date_create($date)==date_create($to_date) && $row['joined']=='No')
                                    {
                                        echo "<div class='panel panel-danger' style='width:150px;background-color:#A7EDAC'>
                                        <div class='panel-heading'><center>Leave Alert!!</center></div>
                                        <div class='panel-body'><center><form action='leave_alert.php' method='post'>
                                        <input type='image' src='animat-bell-color.gif' height='90px'/></form></center></div>
                                    </div>";
                                        break 3;


                                    }
                                    else if($row['status']=='Approved'&&date_create($date)>date_create($to_date) && $row['joined']=='No')
                                    {
                                        echo "<div class='panel panel-danger' style='width:150px;background-color:#A7EDAC'>
                                        <div class='panel-heading'><center>Leave Alert!!</center></div>
                                        <div class='panel-body'><center><form action='leave_alert.php' method='post'>
                                        <input type='image' src='animat-bell-color.gif' height='90px'/></form></center></div>
                                    </div>";
                                        break 3;


                                    }
                                }
                            }
                        }
                    }


                    ?>

                </div>
                <div class="col-sm-2">
                    <?php 
                    if($_SESSION['name']=='admin') 
                    {
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
                                echo "<div class='panel panel-danger' style='width:150px;background-color:#ABB2B9'>
                                        <div class='panel-heading'><center>Separation Alert!!</center></div>
                                        <div class='panel-body'><center><form action='sapa_alert.php' method='post'>
                                        <input type='image' src='animat-bell-color.gif' height='90px'/></form></center></div>
                                    </div>";

                                break;
                            }
                            else if(date_create($date)>=date_create($to_date))
                            {
                                echo "<div class='panel panel-danger' style='width:150px;background-color:#ABB2B9'>
                                        <div class='panel-heading'><center>Separation Alert!!</center></div>
                                        <div class='panel-body'><center><form action='sapa_alert.php' method='post'>
                                        <input type='image' src='animat-bell-color.gif' height='90px'/></form></center></div>
                                    </div>";

                                break;
                            }


                        }

                    }


                    if(($_SESSION['reporter']=='Yes'||$_SESSION['head']=='Yes') && $_SESSION['name'] != 'admin')
                    {

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
                                        echo "<div class='panel panel-danger' style='width:150px;background-color:#ABB2B9'>
                                        <div class='panel-heading'><center>Separation Alert!!</center></div>
                                        <div class='panel-body'><center><form action='sapa_alert.php' method='post'>
                                        <input type='image' src='animat-bell-color.gif' height='90px'/></form></center></div>
                                    </div>";
                                        break 3;
                                    }
                                    else if(date_create($date)>=date_create($to_date))
                                    {
                                        echo "<div class='panel panel-danger' style='width:150px;background-color:#ABB2B9'>
                                        <div class='panel-heading'><center>Separation Alert!!</center></div>
                                        <div class='panel-body'><center><form action='sapa_alert.php' method='post'>
                                        <input type='image' src='animat-bell-color.gif' height='90px'/></form></center></div>
                                    </div>";
                                        break 3;

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
                <div class="col-sm-8"><form method="post" action=""><input class='form-control' placeholder="Search by ID, Name, Blood Group, Phone No....." type='text' style="width:500px" name="content" required><br><input type="submit" name="search" value='Submit' class="btn btn-primary"></form>




                </div>
            </div>

            <div style="padding-top:20px;">
                <?php
                if(isset($_POST['discard']))
                {
                    $leave_id=$_POST['leave_id'];
                    mysqli_query($db,"DELETE FROM leaves WHERE LeaveID='$leave_id'");

                }
                $emp_l=$_SESSION['id'];
                $discard_leave=mysqli_query($db,"SELECT * FROM leaves WHERE EmployeeID='$emp_l' AND status='Pending'");
                if($discard_leave->num_rows!=0)
                {
                    $discard_leave=mysqli_fetch_array($discard_leave);
                    echo "<div class='alert alert-success'><center><big>You applied for Leave from <b>".date_format(date_create($discard_leave['From Date']),"M d, Y")."</b> to <b>".date_format(date_create($discard_leave['To Date']),"M d, Y")."</b></big>";
                    echo " &nbsp;<input type='submit' value='Discard' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal'></center></div>";
                    $leave_id=$discard_leave['LeaveID'];
                }


                if(isset($_POST['search']))
                {
                    echo '<table width="100%" class="table table-striped">';

                    echo '<th>Image</th>';
                    echo '<th>Employee ID</th>';
                    echo '<th>Name</th>';
                    echo '<th>Designation</th>';
                    echo '<th>Department</th>'; 
                    echo '<th>Phone</th>';  
                    echo '<th>Email</th>';  
                    echo '<th>Blood Group</th>';  
                    echo '</tr>';



                    $search=$_POST['content'];
                    $sql="SELECT * FROM `employee` WHERE (`First Name` LIKE '%$search%') UNION SELECT * FROM `employee` WHERE (`Last Name` LIKE '%$search%') UNION SELECT * FROM `employee` WHERE (`ID` LIKE '%$search%') UNION SELECT * FROM `employee` WHERE (`Cell Phone` LIKE '%$search%') UNION SELECT * FROM `employee` WHERE (`Blood Group` LIKE '%$search%')"; 
                    //$sql="SELECT * FROM `employee` WHERE (`First Name`='%$search%' OR `Last Name`='%$search%' OR `Blood Group`='%$search%' OR `ID`='%$search%' `Cell Phone`='%$search%' OR `NID`='%$search%' OR `passport`='%$search%')";
                    $result=mysqli_query($db, $sql);

                    while($row=mysqli_fetch_array($result))
                    {
                        $name = $row['First Name']." ".$row['Last Name'];
                        $id = $row['ID'];
                        $dep_id= $row['department_id'];
                        $query = "SELECT * FROM `job_status` WHERE emp_id ='$id'";
                        $res_des = mysqli_query($db, $query);
                        $row_des=mysqli_fetch_array($res_des);
                        $designation = $row_des[2];
                        $sql_dep ="SELECT dep_name FROM department WHERE dep_id='$dep_id'"; 
                        $res = mysqli_query($db, $sql_dep);
                        $dep_name= mysqli_fetch_array($res);
                ?>
                <tr>
                    <td><img src="<?php echo $row['image']; ?>" height="50" width="50" class="img-rounded"></td>
                    <td><?php echo $id; ?></td>
                    <td><a href="jobdetails.php?id=<?php echo $id; ?>" ><?php echo $name ?></a></td>
                    <td><?php echo $designation; ?></td>
                    <td><?php echo $dep_name['dep_name'];?></td>
                    <td><?php echo $row['Cell Phone']; ?></td>
                    <td><?php echo $row['Email'];?></td>
                    <td><?php echo $row['Blood Group'];?></td>
                </tr>

                <?php

                    }
                ?>
                </table>

            <?php
                }


            ?>
        </div>

        </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Discard Leave</h4>
                </div>
                <div class="modal-body">
                    Are you Sure you want to discard this leave??
                    <p><form method='post' action=''>
                    <input type="hidden" value="<?php echo $leave_id;?>" name="leave_id">
                    <input type='submit' name='discard' value="Confirm" class='btn btn-success'></form><br></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
    </div>

</body>
</html>
<?php
date_default_timezone_set('Asia/Dhaka');
$date = date('Y-m-d', time());
$result=mysqli_query($db,"SELECT * FROM login WHERE Role='admin' AND Username != '10001'");
while($row=mysqli_fetch_array($result))
{
    $id=$row['Username'];
    if(date_create($row['from_date']) <= date_create($date) && date_create($date) <= date_create($row['to_date']))
    {
        continue;
    }
    else
    {
        mysqli_query($db,"UPDATE login SET role='user' WHERE Username='$id'");
    }
}
?>
