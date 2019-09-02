<?php
session_start();
if(!($_SESSION['id']=='10001'||$_SESSION['name']=='data_entry'||$_SESSION['id']==$_GET['id']||$_SESSION['head']=='Yes'||$_SESSION['reporter']=='Yes')){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
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
<?php
$h_r=$_SESSION['id'];
$e_id=$_GET['id'];
$sql="SELECT * FROM employee WHERE ID='$e_id'";
$res=mysqli_query($db,$sql);
$row=mysqli_fetch_array($res);
$dep_id=$row['department_id'];
$sql="SELECT * FROM department WHERE dep_id='$dep_id' AND (head_id='$h_r' OR reporter_id='$h_r')";
$res=mysqli_query($db,$sql);
if($res->num_rows==0&&$_SESSION['name']!='admin'&&$_SESSION['id']!=$_GET['id'])
{
    redirect("index.php");
}



?>

<?php include 'remove_empty_field.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Employee Details</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
        <!-- Nav tabs -->
        <?php include 'html/navbar.php'; ?>
        <div class="container" style="padding-right: 20px;padding-left: 20px">
            <?php $empID = $_GET['id']; ?>
            <div class="row">
                <div class="col-sm-2">
                    <?php 
                    $sql = "SELECT * FROM `employee` WHERE ID='$empID'";
                    $result = mysqli_query($db, $sql);
                    $row = mysqli_fetch_array($result);
                    $query ="SELECT * FROM job_status WHERE emp_id='$empID'";
                    $res = mysqli_query($db, $query);
                    $line = mysqli_fetch_array($res);




                    if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')
                    {

                        echo "<a href='update_employee.php?id=".$empID."' > <img src='".$row['image']."' height='150px' width='150px' class='img-rounded'></a><br><br>";

                    }
                    else
                    {
                        echo "<img src='".$row['image']."' height='150px' width='150px' class='img-rounded'><br><br>";


                    }
                    ?>


                </div>
                <div class="col-sm-7">
                    <div class="panel panel-success">
                        <div class="panel-heading">           
                            <?php
                            echo "<b>Employee ID:  </b>".$row['ID']."<br>";
                            echo "<b>Employee Name:  </b>".$row['First Name']." ".$row['Last Name']."<br>";
                            echo "<b>Email:  </b>".$row['Email']."<br>";
                            $sql="SELECT * FROM department WHERE dep_id='".$row['department_id']."'";
                            $res=mysqli_query($db,$sql);
                            $row_dep=mysqli_fetch_array($res);
                            echo '<b>Department: </b>'.$row_dep['dep_name']."</br>";
                            $sql="SELECT * FROM job_status WHERE emp_id='$empID'";
                            $res=mysqli_query($db,$sql);
                            $row_dep=mysqli_fetch_array($res);
                            echo '<b>Designation: </b>'.$row_dep['curr_designation']."</br>";


                            $sql="SELECT * FROM department WHERE head_id='$empID' OR reporter_id='$empID'";
                            $res=mysqli_query($db,$sql);
                            $num_rows=$res->num_rows;
                            if($num_rows!=0)
                            {
                                echo '<br><b>Head/Reporter: </b>';
                                while($row_dep=mysqli_fetch_array($res))
                                {
                                    echo $row_dep['dep_name'];
                                    if($num_rows==1) continue;
                                    echo ", ";
                                    $num_rows--;
                                }
                            }
                            ?>

                        </div>

                    </div>
                </div>
                <div class="col-sm-3">
                    <?php

                    function check_in_range($start_date, $end_date, $date_from_user)
                    {
                        // Convert to timestamp
                        $start_ts = strtotime($start_date);
                        $end_ts = strtotime($end_date);
                        $user_ts = strtotime($date_from_user);

                        // Check that user date is between start & end
                        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
                    }

                    $sql = "SELECT MAX(LeaveID) AS serial FROM leaves WHERE status='Approved' AND EmployeeID='$empID' AND joined='No'";
                    $res = mysqli_query($db,$sql);
                    $latest=mysqli_fetch_array($res);
                    $leave_id=$latest['serial'];
                    $sql = "SELECT * FROM leaves WHERE status='Approved' AND LeaveID='$leave_id' AND joined='No'";
                    $res = mysqli_query($db,$sql);
                    //echo $leave_id;
                    $data = mysqli_fetch_array($res); 

                    if (date_create($data['From Date'])<=date_create(date('Y-m-d',time())))
                    {
                        echo "<div class='alert alert-danger'><center>On Leave</center></div>";
                        if($_SESSION['name']=='admin'||$_SESSION['id']==$empID)
                        {
                            echo '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal">Join Now</button>';
                            echo "<br><br>";
                        }
                    }
                    else {echo "<div class='alert alert-info'><center>On Duty</center></div>";}
                    ?> 
                    <?php

                    echo "<a class='btn btn-success btn-sm' href='history.php?id=".$row[0]."'>History</a><br><br>";


                    echo "";
                    ?>
                    <?php
                    if($_SESSION['name']=='admin')
                    {
                    ?>

                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Actions
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a data-toggle='modal' data-target='#myModal_inc'>Add Increment</a></li>
                            <li><a data-toggle='modal' data-target='#myModal_dep'>Change Department</a></li>
                            <li><a data-toggle='modal' data-target='#myModal_prom'>Change Designation </a></li>
                            <li><a data-toggle='modal' data-target='#myModal_bon'>Give Bonus </a></li>
                            <li><a data-toggle='modal' data-target='#myModal_emp'>Change Employment </a></li>
                            <li><a data-toggle='modal' data-target='#myModal_fac'>Change Facilities </a></li>
                        </ul>
                    </div>

                    <?php
                    }
                    ?>

                </div>
            </div>



            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab1">Personal Information</a></li>
                <li><a data-toggle="tab"  href="#tab2">Job Status</a></li>
                <li><a data-toggle="tab" href="#tab3">Experience</a></li>
                <li><a data-toggle="tab" href="#tab4">Qualification</a></li>

                <li><a data-toggle="tab" data-toggle="tab"  href="#tab6">Training</a></li>
                <li><a data-toggle="tab" href="#tab7">Awards</a></li>
                <li><a data-toggle="tab" href="#tab8">Disciplinary</a></li>
                <li><a data-toggle="tab" href="#tab9">Others</a></li>
            </ul>

            <div class="tab-content" style="padding-top:20px; padding-bottom:20px;">

                <div id="tab1" class="tab-pane fade in active">


                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Join Now</h4>
                                </div>
                                <div class="modal-body">
                                    <p><form method='post' action='history.php?id=<?php echo $empID; ?>'>
                                    <input type='hidden' name='id' value='<?php echo $leave_id; ?>'>
                                    Remarks<textarea name='remarks' style="height:50px" class="form-control"></textarea><br>
                                    <input type='submit' name='join' value="Confirm" class='btn btn-success'></form><br></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="modal fade" id="myModal_bon" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Salary Increment</h4>
                            </div>
                            <div class="modal-body">
                                Are You Sure to Give Bonus??<br><br>
                                <a href='change_bonus.php?id=<?php echo $empID; ?>' class='btn btn-primary btn-sm'>Yes</a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal_inc" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Salary Increment</h4>
                            </div>
                            <div class="modal-body">
                                Are You Sure to Give Increment??<br><br>
                                <a href='change_salary.php?id=<?php echo $empID; ?>' class='btn btn-primary btn-sm'>Yes</a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal_dep" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Change Department</h4>
                            </div>
                            <div class="modal-body">
                                Are You Sure to Change Department??<br><br>
                                <a href='change_department.php?id=<?php echo $empID; ?>' class='btn btn-primary btn-sm'>Yes</a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal_emp" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Change Employment Type</h4>
                            </div>
                            <div class="modal-body">
                                Are You Sure??<br><br>
                                <a href='change_employment.php?id=<?php echo $empID; ?>' class='btn btn-primary btn-sm'>Yes</a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal_fac" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Change Facilities</h4>
                            </div>
                            <div class="modal-body">
                                Are You Sure??<br><br>
                                <a href='change_facility.php?id=<?php echo $empID; ?>' class='btn btn-primary btn-sm'>Yes</a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal_prom" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Change Designation</h4>
                            </div>
                            <div class="modal-body">
                                Are You Sure??<br><br>
                                <a href='change_designation.php?id=<?php echo $empID; ?>' class='btn btn-primary btn-sm'>Yes</a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Personal Information</div>

                            <div class="panel-body">
                                <?php
                                $birth_date=date_create($row[4]);
                                echo "<b>Date of Birth:  </b>".date_format($birth_date,"M d, Y")."<br>";

                                echo "<b>Sex:  </b>".$row[6]."<br>";
                                echo "<b>Blood Group:  </b>".$row[7]."<br>";
                                echo "<b>Height:  </b>  ".$row[8]."<br>";
                                echo "<b>Phone:  </b>".$row[9]."<br>";
                                echo "<b>Father's Name:  </b>".$row[10]."<br>";
                                echo "<b>Mother's Name:  </b>".$row[11]."<br>";
                                echo "<b>Spouse:  </b>".$row[12]."<br>";
                                echo "<b>Number of Children:  </b>".$row[13]."<br>";
                                echo "<b>National ID:  </b>".$row[14]."<br>";
                                echo "<b>Tax ID:  </b>".$row[15]."<br>";
                                echo "<b>Passport No.:  </b>".$row[16]."<br>";
                                echo "<b>Driving License:  </b>".$row[17]."<br>";   
                                if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')
                                {
                                    echo "<form method='post' action='update_employee.php?id=".$row[0]."'>";
                                    echo "<br><input name='personal' value='Update' type='submit' class='btn btn-info btn-sm'>";
                                    echo "</form>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Address</div>

                            <div class="panel-body">
                                <?php 
                                $sql ="SELECT * FROM `address` WHERE emp_id=".$empID;
                                $result = mysqli_query($db, $sql);
                                $row = mysqli_fetch_array($result);
                                echo "<b>Permanent Address: </b>".$row[1].", ".$row[2].", ".$row[3]."
                                , ".$row[4].", ".$row[5]." Division<br>";
                                echo "<b>Present Address: </b>".$row[6].", ".$row[7].", ".$row[8].", ".$row[9].", ".$row[10]." Division<br><br>";
                                if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')
                                {
                                    echo "<form method='post' action='update_employee.php?id=".$row[0]."'>";
                                    echo "<input name='address' value='Update' type='submit' class='btn btn-info btn-sm'>";
                                    echo "</form>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading"></div>

                            <div class="panel-body">
                                <?php
                                echo "<a class='btn btn-success btn-sm' href='employee_profile_print_menu.php?ID=".$row[0]."'>Print Employee Profile</a><br>";

                                ?>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Emergency Contact</div>

                            <div class="panel-body">
                                <?php
                                $sql ="SELECT * FROM `emergency_contact` WHERE emp_id='$empID'";
                                $result = mysqli_query($db, $sql);
                                $row = mysqli_fetch_array($result);
                                echo "<b>Name: </b>".$row[1]."<br>";
                                echo "<b>Relation: </b>".$row[2]."<br>";
                                echo "<b>Phone: </b>".$row[3]."<br><br>";
                                if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')
                                {
                                    echo "<form method='post' action='update_employee.php?id=".$empID."'>";
                                    echo "<input name='emergency' value='Update' type='submit' class='btn btn-info btn-sm'>";
                                    echo "</form>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if($_SESSION['name']=='admin')
                {
                    $id=$_GET['id'];
                    $sql="SELECT * FROM history_fire WHERE emp_id='$id'";
                    $res=mysqli_query($db,$sql);

                    if($res->num_rows==0)
                    {
                        echo " <a class='btn btn-warning btn-sm' href='employee_fire.php?id=".$empID."'>Separate Employee</a> ";
                    }
                    else
                    {
                        echo " <button class='btn btn-warning btn-sm' disabled>Employee Separated</button> ";

                    }
                }
                if($_SESSION['name']=='admin')
                {
                    echo "<a class='btn btn-danger btn-sm' href='employee_delete.php?id=".$empID."'>Delete</a><br><br>";
                }
                ?>
            </div>
            <div id="tab2" class="tab-pane fade">
                <?php
                $sql ="SELECT * FROM `job_status` WHERE emp_id='$empID'";
                $result = mysqli_query($db, $sql);
                $row = mysqli_fetch_array($result);
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Job Status</div>

                            <div class="panel-body">
                                <?php
                                echo "<b>Current Designation: </b>".$row['curr_designation']."<br>";

                                $sql = "SELECT * FROM `department` WHERE dep_id=".(int)$row['curr_department'];
                                $res = mysqli_query($db, $sql);
                                $dep = mysqli_fetch_assoc($res);
                                echo "<b>Current Department: </b>".$dep['dep_name']."<br>";



                                $date=date_create($row['joining_date']);
                                echo "<b>Joining Date: </b>".date_format($date,"M d, Y")."<br>";
                                echo "<b>Joining Gross Salary: </b>".$row['joining_gross']."<br>";
                                echo "<b>Current Gross Salary: </b>".$row['current_gross']."<br>";

                                echo "<b>Present Working Station: </b>".$row['present_working_station']."<br>";
                                echo "<b>Employee Status: </b>".$row['employee_status']."<br>";

                                echo "<b>Confirmation Status: </b>".$row['confirmation_status']."<br>";
                                $date=date_create($row['confirmation_date']);
                                echo "<b>Confirmation Date: </b>".date_format($date,"M d, Y")."<br>";
                                echo "<b>Employment Type: </b>".$row['employment_type']."<br>";
                                echo "<b>Employee Separation: </b>".$row['employee_separation']."<br>";
                                $date=date_create($row['employee_separation_date']);
                                echo "<b>Employee Saparation Date: </b>".date_format($date,"M d, Y")."<br>";
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Others</div>

                            <div class="panel-body">
                                <?php

                                echo "<b>Salary Account Number: </b>".$row['salary_account']."<br>";
                                echo "<b>Bank Name: </b>".$row['bank']."<br>";
                                echo "<b>Corporate Sim Number: </b>".$row['corporate_sim']."<br>";
                                echo "<b>OT Status: </b>".$row['ot_status']."<br>";

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Refered By</div>

                            <div class="panel-body">
                                <?php

                                echo "<b>ID: </b>".$row['reffered_by']."<br>";
                                echo "<b>Name: </b>".$row['name']."<br>";
                                $reffered_by=$row['reffered_by'];
                                $query ="SELECT * FROM `job_status` WHERE emp_id='$reffered_by'";
                                $res = mysqli_query($db, $query);
                                $fetch = mysqli_fetch_array($res);
                                echo "<b>Designation: </b>".$fetch['curr_designation']."<br>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')
                {
                    echo "<form method='post' action='update_employee.php?id=".$row[0]."'>";
                    echo "<br><input name='job_status' value='Update' type='submit' class='btn btn-info btn-sm'>";
                    echo "</form>";
                }
                ?> 
            </div>
            <div id="tab3" class="tab-pane fade">
                <?php
                $sql ="SELECT * FROM `job_experience` WHERE emp_id=".$empID;
                $result = mysqli_query($db, $sql);
                if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')
                {
                    echo "<form method='post' action='jobdetails_add.php?id=".$empID."'>";
                    echo "<input name='experience' value='Add' type='submit' class='btn btn-info btn-sm'>";
                    echo "</form><br>";
                }
                ?>
                <table class="table table-striped" border="1">
                    <tr>
                        <th width='50px'>Serial</th>
                        <th>Previous Employer</th>
                        <th>Designation</th>
                        <th>Job Field</th>
                        <th>Job Experience</th>
                        <th>Address</th>
                        <th>Reference</th>
                    </tr>
                    <?php
                    $count=1;
                    while($row = mysqli_fetch_array($result))
                    {
                        echo "<tr>";
                        echo "<td><center><a class='btn btn-primary btn-sm' href='jobdetails_experience.php?id=".$row[0]."'>".$count."</a></center></td>";         
                        echo "<td>".$row[2]."</td>";
                        echo "<td>".$row[3]."</td>";
                        echo "<td>".$row[4]."</td>";
                        echo "<td>".$row[5]."</td>";
                        echo "<td>".$row[6]."</td>";
                        echo "<td>".$row[7]."</td>";
                        $count++;
                    }

                    ?>
                </table>
            </div>
            <div id="tab4" class="tab-pane fade">
                <?php
                $sql ="SELECT * FROM `qualification` WHERE emp_id='$empID' ORDER BY `year` DESC";
                $result = mysqli_query($db, $sql);

                if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')
                {
                    echo '<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Add</button><br><br>';
                }
                //echo "<form method='post' action='jobdetails_add_update.php>";
                echo "<table border='1' class='table table-striped'><tr>
                <th width='50px'><center>Serial</center></th> 
                <th width='150px'><center>Degree</center></th>
                <th width='150px'><center>Field</center></th>
                <th width='150px'><center>Institution/University</center></th>
                <th width='150px'><center>Passing Year</center></th>
                <th width='150px'><center>Marks/CGPA</center></th>
                <th width='150px'><center>Location/Country</center></th>
                </tr>";
                $count=1;
                while($row = mysqli_fetch_array($result))
                {
                    echo "<tr>";
                    echo "<td><center><a class='btn btn-primary btn-sm' href='jobdetails_qualification.php?id=".$row[0]."'>".$count."</a></center></td>";
                    echo "<td>".$row[7]."</td>";
                    echo "<td>".$row[2]."</td>";
                    echo "<td>".$row[3]."</td>";
                    echo "<td>".$row[4]."</td>";
                    echo "<td>".$row[5]."</td>";
                    echo "<td>".$row[6]."</td>";
                    echo "</tr>";
                    $count++;
                }


                ?>

                </table>

            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Qualification</h4>
                        </div>
                        <div class="modal-body">
                            <form action="jobdetails_add_process.php?id=<?php echo $empID; ?>" method="post">
                                <div class="form-group"><b>Degree: </b></div>
                                <div class="form-group">Degree Name:  <input type="text" name="edu_degree" class="form-control"  style="width:500px" required></div>
                                <div class="form-group">Field Of Study:  <input type="text" name="edu_field" class="form-control" style="width:500px" required></div>
                                <div class="form-group">University/School/Institute Name:  <input type="text" name="edu_ins"  class="form-control" style="width:500px" ></div>
                                <div class="form-group" required>Year of Passing:<input type="text" name="edu_year"  class="form-control"  style="width:500px"></div>
                                <div class="form-group">Marks Obtained/ CGPA :  <input type="text" name="edu_mark"  class="form-control" style="width:500px" ></div>
                                <div class="form-group">Location:  <input type="text" name="edu_loc"  class="form-control" style="width:500px" ></div>
                                <input type="submit" name="qualification" value="Submit" class="btn btn-primary">
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div id="tab6" class="tab-pane fade">

            <?php

            $sql ="SELECT * FROM `training` WHERE emp_id=".$empID;
            $result = mysqli_query($db, $sql);
            if($result-> num_rows == 0) {echo "No records found!!";}
            while($row = mysqli_fetch_array($result))
            {
                echo "<b>Title: </b>".$row[2]."<br>";
                echo "<b>Institution: </b>".$row[3]."<br>";
                echo "<b>Place: </b>".$row[4]."<br>";
                echo "<b>Days: </b>".$row[5]."<br>";
                echo "<b>Year: </b>".$row[6]."<br><hr>";
            }
            if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')
            {
                echo "<br><form method='post' action='jobdetails_add.php?id=".$empID."'>";
                echo "<input name='training' value='Add' type='submit' class='btn btn-info btn-sm'>";
                echo "</form>";
            }
            ?>
        </div>
        <div id="tab7" class="tab-pane fade">
            <?php

            $sql ="SELECT * FROM `awards` WHERE emp_id=".$empID;
            $result = mysqli_query($db, $sql);
            if($result-> num_rows == 0) echo "No records found!!";
            while($row = mysqli_fetch_array($result))
            {
                echo "<b>Date: </b>".date_format(date_create($row[2]),"M d, Y")."<br>";
                echo "<b>Remarks: </b>".$row[3]."<br><hr>";
            }
            if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')
            {
                echo "<br><form method='post' action='jobdetails_add.php?id=".$empID."'>";
                echo "<input name='awards' value='Add' type='submit' class='btn btn-info btn-sm'>";
                echo "</form>";
            }
            ?>
        </div>
        <div id="tab8" class="tab-pane fade">
            <?php
            $sql ="SELECT * FROM `disciplinary` WHERE emp_id=".$empID;
            $result = mysqli_query($db, $sql);
            if($result-> num_rows == 0) echo "No records found!!";
            while($row = mysqli_fetch_array($result))
            {
                echo "<b>Type: </b>".$row[2]."<br>";
                echo "<b>Date: </b>".date_format(date_create($row[3]),"M d, Y")."<br>";
                echo "<b>Remarks: </b>".$row[4]."<br><hr>";
            }
            if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')
            {
                echo "<br><form method='post' action='jobdetails_add.php?id=".$empID."'>";
                echo "<input name='disc' value='Add' type='submit' class='btn btn-info btn-sm'>";
                echo "</form>";
            }
            ?>

        </div>
        <div id="tab9" class="tab-pane fade">

            <?php
            $sql ="SELECT * FROM `complain` WHERE emp_id=".$empID;
            $result = mysqli_query($db, $sql);
            if($result-> num_rows == 0) echo "No records found!!";
            while($row = mysqli_fetch_array($result))
            {
                echo "<b>Date: </b>".date_format(date_create($row[2]),"M d, Y")."<br>";
                echo "<b>Remarks: </b>".$row[3]."<br><hr>";
            }
            if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')
            {
                echo "<br><form method='post' action='jobdetails_add.php?id=".$empID."'>";
                echo "<input name='complain' value='Add' type='submit' class='btn btn-info btn-sm'>";
                echo "</form>";
            }
            ?>

        </div>

        </div>
    </div>

<?php include "html/footer.html"; ?>

</body>
</html>