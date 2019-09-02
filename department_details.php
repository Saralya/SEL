<?php
session_start();
if(!($_SESSION['name']=='admin'||$_SESSION['head']=='Yes'||$_SESSION['reporter']=='Yes')){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php include "html/bootstrap.html"; ?>
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
} ?>
<html>
<head>

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
    <?php include 'html/navbar.php'; ?>
    <div class="container">
        <?php

        date_default_timezone_set('Asia/Dhaka');
        $date = date('m/d/Y', time());
        $dep_id=$_GET['id'];
        $head_id=$_SESSION['id'];
        $sql="SELECT * FROM department WHERE dep_id='$dep_id' AND (head_id='$head_id' OR reporter_id='$head_id')";
        $res=mysqli_query($db,$sql);
        if($res->num_rows===0&&$_SESSION['name']!=='admin')
        {
            redirect("index.php");
        }
        else
        {
            $query = "SELECT * FROM `department` WHERE dep_id=".$_GET['id'];
            $result = mysqli_query($db, $query);
            $update = mysqli_fetch_array($result);?>
            <h3>Department Name: <i><?php echo $update['dep_name'];?></i></h3><hr>
            <div class="row">
                <?php  


                $head = $update['head_id'];
                $query2 = "SELECT * FROM `employee` WHERE ID='$head'";
                $result2 = mysqli_query($db, $query2);
                $update2= mysqli_fetch_array($result2);
                $query3 = "SELECT * FROM `job_status` WHERE emp_id='$head'";
                $result3= mysqli_query($db, $query3);
                $update3 = mysqli_fetch_array($result3);	 
                ?>

                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Head</div>

                        <div class="panel-body">
                            <div class="media">
                                <div class="media-left">
                                    <img src="<?php echo $update2['image'];?>" class="media-object" style="width:60px">
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo " ".$update2['First Name']." ".$update2['Last Name']; ?></h4>
                                    <p><?php echo $update3['curr_designation']; ?> <br>
                                        <?php echo " ".$update['reporting_mail']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <?php  
                    $query = "SELECT * FROM `department` WHERE dep_id=".$_GET['id'];
                    $result = mysqli_query($db, $query);
                    $update = mysqli_fetch_array($result);
                    $reporter = $update['reporter_id'];
                    $query2 = "SELECT * FROM `employee` WHERE ID='$reporter'";
                    $result2 = mysqli_query($db, $query2);
                    $update2= mysqli_fetch_array($result2);
                    $query3 = "SELECT * FROM `job_status` WHERE emp_id='$reporter'";
                    $result3= mysqli_query($db, $query3);
                    $update3 = mysqli_fetch_array($result3);	 
                    ?>
                    <div class="col-sm-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">Reporter</div>

                            <div class="panel-body">
                                <div class="media">
                                    <div class="media-left">
                                        <img src="<?php echo $update2['image'];?>" class="media-object" style="width:60px">
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo " ".$update2['First Name']." ".$update2['Last Name']; ?></h4>
                                        <p><?php echo $update3['curr_designation']; ?> <br>
                                            <?php echo " ".$update['reporting_mail_2']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        if($_SESSION['name']==='admin')
                        { 

                           echo '<a class="btn btn-success" href="department_update.php?id='.$_GET['id'].'">Update</a>';
                           echo ' <a class="btn btn-danger" href="department_delete.php?id='.$_GET['id'].'">Remove</a>';
                           echo ' <a class="btn btn-warning" href="department_history.php?id='.$_GET['id'].'">History</a>';
                           echo ' <a class="btn btn-info" href="department_info_print_menu.php?ID='.$_GET['id'].'">Print</a><br><br>';
                       }    ?>
                       <input class='form-control' placeholder="Search..." type='text' style="width:400px" id="myInput"><br>

                       <?php
                        $dep=$_GET['id'];
                       $query="SELECT * FROM employee WHERE `department_id`='$dep' ORDER BY ID";
                       $res_dep=mysqli_query($db, $query);
                       if($res_dep->num_rows === 0)
                       {
                        echo '<div class="alert alert-danger" align="center">
                        <strong>No Employee in this Department!!!</strong>
                        </div>';
                    }
                    else
                    {
                        echo '<table width="100%" id="emp_table" class="table table-striped">';
                        echo '<thead>';
                        echo '<tr class="tr_header">';
                        echo '<th>Image</th>';
                        echo '<th>Employee ID</th>';
                        echo '<th >Name</th>';
                        echo '<th >Designation</th>';
                        echo '<th>Head of Department</th>'; 
                        echo '<th>Reporter of Department</th>'; 
                        echo '<th>Leave Status</th>'; 
                        echo '<th>Employment Type</th>'; 
                        echo '</thead>';
                        echo '</tr>';
                        echo '<tbody id="myTable">';
                        while($fetch=mysqli_fetch_array($res_dep))
                        {



                            $name = $fetch['First Name']." ".$fetch['Last Name'];
                            $id = $fetch['ID'];
                            $dep_id= $fetch['department_id'];
                            $query = "SELECT * FROM `job_status` WHERE emp_id ='$id'";
                            $res_des = mysqli_query($db, $query);
                            $row_des = mysqli_fetch_array($res_des);
                            if($row_des['fired']=='Yes') continue;
                            $designation = $row_des['curr_designation'];
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
                                <?php $sql = "SELECT MAX(LeaveID) AS serial FROM leaves WHERE EmployeeID='$id'";
                                $res = mysqli_query($db,$sql);
                                $latest=mysqli_fetch_array($res);
                        //echo $latest['serial'];
                                $leave_id=$latest['serial'];
                                $sql = "SELECT * FROM leaves WHERE LeaveID='$leave_id'";
                                $res = mysqli_query($db,$sql);
                        //echo $leave_id;
                                $data = mysqli_fetch_array($res);

                                if ($data['status']=='Approved'&&$data['joined']=='No'&&date_create($data['From Date'])<=date_create($date))
                                {
                                    echo "<td class='alert-danger'>On Leave</td>";

                                }
                                else 
                                {
                                    echo "<td class='alert-info'>On Duty</td>";
                                }
                                ?>
                            
                            <td><?php echo $row_des['employment_type']; ?><br><?php echo date_format(date_create($row_des['employee_separation_date']),'d-M-Y'); ?></td>
                        </tr>

                        <?php

                    }
                    ?></tbody>
                </table><br><br>
                <?php     
            }



            ?>
        </div>
        <script>
            $(document).ready(function(){
                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script>

    <?php } ?>
</div>
</body>


</html>