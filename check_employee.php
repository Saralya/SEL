<?php include "connect.php" ?>
<?php
    session_start();
if(!$_SESSION['name']){
    header("location:admin.php");
}
?> 
<?php
date_default_timezone_set('Asia/Dhaka');
$leave_year = date('Y', time());
if(isset($_GET['q'])) {
    $id = $_GET['q'];

    if(!is_numeric($id)){
        echo "Enter valid id!";
    } else {
        $query="SELECT * FROM `employee` WHERE ID='$id'";
        $result_1 = mysqli_query($db, $query);
        if($result_1->num_rows>0)
        {

            $fired=mysqli_query($db,"SELECT fired FROM job_status WHERE emp_id='$id'");
            $fired=mysqli_fetch_array($fired);
            if($fired['fired']=='Yes') 
            {
                echo "<div class='alert alert-danger'><center><b>Employee is Separated!!</b></center></div>";

            }
            else
            {

                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Casual' AND year='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_casual=mysqli_fetch_array($result);
                $day_casual=$row_casual['Total'];

                //Gets total sick leaves
                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Sick' AND year='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_sick=mysqli_fetch_array($result);
                $day_sick=$row_sick['Total'];

                //Gets total annual leaves
                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Annual' AND year='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_annual=mysqli_fetch_array($result);
                $day_annual=$row_annual['Total'];

                //Gets total maternity leaves
                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Maternity' AND year='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_maternity=mysqli_fetch_array($result);
                $day_maternity=$row_maternity['Total'];

                //Gets total paternity leaves
                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Paternity' AND year='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_paternity=mysqli_fetch_array($result);
                $day_paternity=$row_paternity['Total']; 

                //Gets total wpl leaves
                $sql="SELECT SUM(days) AS Total FROM leaves WHERE EmployeeID='$id' AND status='Approved' AND type='Without Pay Leave' AND year='$leave_year'";
                $result=mysqli_query($db, $sql);
                $row_wpl=mysqli_fetch_array($result);
                $day_wpl=$row_wpl['Total'];

                date_default_timezone_set('Asia/Dhaka');
                $leave_year = date('Y', time());

                $sql="SELECT * FROM `leave_types` WHERE emp_id = '$id' AND `year`='$leave_year'";
                $result = mysqli_query($db, $sql);
                $row = mysqli_fetch_array($result);
                $existing_casual= $row['casual']-$day_casual; 
                $existing_sick= $row['sick']-$day_sick;
                $existing_annual= $row['annual']-$day_annual;
                $existing_maternity= $row['maternity']-$day_maternity;
                $existing_paternity= $row['paternity']-$day_paternity;
                $existing_wpl= $row['wpl']-$day_wpl;
                $row =mysqli_fetch_array($result_1);
                $sql="SELECT curr_designation FROM job_status WHERE emp_id='$id'";
                $result=mysqli_query($db, $sql);
                $curr_designation=mysqli_fetch_array($result);
?>

<div class="panel panel-primary">
    <div class="panel-heading">Employee</div>

    <div class="panel-body">
        <div class="media">
            <div class="media-left">
                <img src="<?php echo $row['image'];?>" class="media-object" style="width:60px" class="img img-rounded">
            </div>
            <div class="media-body">
                <h4 class="media-heading"><?php echo " ".$row['First Name']." ".$row['Last Name']; ?></h4>
                <p><?php echo $curr_designation['curr_designation']; ?> <br>
                    <?php echo " ".$row['Email']; ?></p>
            </div>
        </div>
    </div>
</div>


<?php

                echo "<br><br><b>Existing Leaves:</b><br>Sick: ".$existing_sick."<br>Casual: ".$existing_casual."<br>Annual: ".$existing_annual."<br>Parental: ".$existing_maternity."<br>Alternative: ".$existing_paternity."<br>Without Pay Leaves: ".$existing_wpl;


                $db -> close();
            } 

        }


        //Gets total casual leaves    



        else {
            echo "<div class='alert alert-danger'><center><b>Doesn't Exist!!</b></center></div>";
        }
    }
}
?>