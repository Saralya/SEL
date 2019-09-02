<?php
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php include "connect.php"; ?>
<?php include "html/bootstrap.html" ?>


<!DOCTYPE html>
<html>
<head>

    <title>Department Update Form</title>
    <meta charset="utf-8">
    <script>
        function showUser(str) {
            if (str == "") {
                document.getElementById("search").innerHTML = "";
                return;
            } else { 
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
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
    <?php include "html/navbar.php"; ?>
    <?php
    date_default_timezone_set('Asia/Dhaka');
    $date = date('Y-m-d', time());
    ?>

    <div class="container">


        <h3>Department Update Form</h3> 
        <div class="row">


            <form action="department_update_process.php?id=<?php echo $_GET['id'];?>" method="post" class="form-inline">
                <big>
                    <?php  
                    $query = "SELECT * FROM `department` WHERE dep_id=".$_GET['id'];
                    $result = mysqli_query($db, $query);
                    $update = mysqli_fetch_array($result);
                    $head = $update['head_id'];
                    $query2 = "SELECT * FROM `employee` WHERE ID='$head'";
                    $result2 = mysqli_query($db, $query2);
                    $update2= mysqli_fetch_array($result2);
                    $query3 = "SELECT * FROM `job_status` WHERE emp_id='$head'";
                    $result3= mysqli_query($db, $query3);
                    $update3 = mysqli_fetch_array($result3);	 
                    ?>
                    <div class="col-12 col-sm-12 col-lg-12">
                        <h4>Department Name: </h4><input type="text" name="dep_name" class="form-control" value="<?php echo $update['dep_name'];?>"><hr><hr></div><br><br>
                        <div class="col-6 col-sm-6 col-lg-6">

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
                                            <?php echo " ".$update['reporting_mail']; ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            



                            New Head ID: <input type="text" name="head" onkeyup="showUser(this.value)" class="form-control"> <div id="search"></div><br>
                            Approval Date: <input type='date' name='appr_date' value=<?php echo $date; ?> class="form-control"><br><br>
                            Effective Date: <input type='date' name='eff_date' value=<?php echo $date; ?> class="form-control"><br>

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

                        <div class="col-6 col-sm-6 col-lg-6">

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
                                New Reporter ID: <input type="text" name="reporter" onkeyup="showUser_2(this.value)" class="form-control"><div id="search_2"></div><br>
                                Approval Date: <input type='date' name='appr_date_2' value=<?php echo $date; ?> class="form-control"><br><br>
                                Effective Date: <input type='date' name='eff_date_2' value=<?php echo $date; ?> class="form-control"><br>
                            </div>
                        </div>
                        <br><br><input type="submit" name="submit" value="Submit" class="btn btn-primary" >
                    </big></form>
                </body>
                <?php// include "html/footer.html"; ?>


                <!--/span-->

                <!--/span-->

            </div>


            </html>
