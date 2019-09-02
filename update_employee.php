<?php
session_start();
if(!($_SESSION['name']=='admin'||$_SESSION['name']=='data_entry')){
    header("location:admin.php");
}
?>
<?php include "connect.php"; ?>


<?php //include "html/navbar.html"; ?>
<?php include "html/bootstrap.html" ?>
<!DOCTYPE html>
<html>
<head>
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <title>Employee Update Form</title>
    <meta charset="utf-8">
    <style>
    article, aside, figure, footer, header, hgroup, 
menu, nav, section { display: block; } </style>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                .attr('src', e.target.result)
                .width(200)
                .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</head>
<body><?php include "html/navbar.php" ?>
<div>
    <div class="container">


        <br><h3>Employee Update Form</h3><br>  
        <div>
            <div>

                <form role="form" action="update_employee_process.php?id=<?php echo $_GET['id'];?>" method="post" enctype="multipart/form-data">

                    <label class="btn btn-default btn-file">
                        <input type="file" style="display: none;" name="image" onchange="readURL(this);" >
                        <img id="blah" src="#" alt="Select Image"/>
                    </label>
                    <br><br><input  class="btn btn-primary" type="submit" name="pic" value="Submit" >
                </form>



                <?php 
                if(isset($_POST['personal']))
                {


                    $query = "SELECT * FROM `employee` WHERE ID=".$_GET['id'];
                    $result = mysqli_query($db, $query);
                    $jobdetails = mysqli_fetch_assoc($result);


                    ?>
                    <form action="update_employee_process.php?id=<?php echo $jobdetails['ID'];?>" method="post" class="">

                        First Name: <input type="text" name="first" class="form-control" value="<?php echo $jobdetails['First Name'];?>" style="width:500px"><br><br>
                        Last Name: <input type="text" name="last" class="form-control" value="<?php echo $jobdetails['Last Name'];?>" style="width:500px"><br><br>
                        Date of Birth:<input type="date" name="date" class="form-control" value="<?php echo $jobdetails['Date of Birth'];?>" style="width:200px"><br><br>

                        E-mail: <input size="50" type="text" name="email" class="form-control" value="<?php echo $jobdetails['Email'];?>" style="width:800px"><br><br>
                        Sex: <select name="gender"  class="form-control" style="width:150px" default>
                            <option value="<?php echo $jobdetails['Gender'];?>" selected><?php echo $jobdetails['Gender'];?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select><br><br>

                        Cell Phone: <input size="" type="text" name="phone" class="form-control" value="<?php echo $jobdetails['Cell Phone'];?>" style="width:500px"><br><br>
                        Number of Children: <input size="" type="text" name="child" class="form-control" value="<?php echo $jobdetails['children'];?>" style="width:500px"><br><br>

                        Blood Group: <select name="blood" class="form-control" style="width:300px">
                            <option value="<?php echo $jobdetails['Blood Group'];?>"><?php echo $jobdetails['Blood Group'];?></option>
                            <option value="B +ve">B -ve</option>
                            <option value="A +ve">A +ve</option>
                            <option value="A -ve">A -ve</option>
                            <option value="AB +ve">AB +ve</option>
                            <option value="AB -ve">AB -ve</option>
                            <option value="O +ve" >O +ve</option>
                            <option value="O -ve">O -ve</option>
                        </select><br><br>
                        Height: <input type="text" name="height" class="form-control" style="width:500px" value="<?php echo $jobdetails['height'];?>"><br><br>
                        Father's Name:  <input type="text" name="father"  class="form-control" style="width:500px" value="<?php echo $jobdetails['father'];?>"><br><br>
                        Mother's Name:  <input type="text" name="mother"  class="form-control" style="width:500px" value="<?php echo $jobdetails['mother'];?>"><br><br>
                        Name of Spouse:  <input type="text" name="spouse"  class="form-control" style="width:500px" value="<?php echo $jobdetails['spouse'];?>"><br><br>
                        National ID Card No: <input type="text" name="national_id" class="form-control" style="width:500px" value="<?php echo $jobdetails['NID'];?>"><br><br>
                        Tax ID No: <input type="text" name="tax_id" class="form-control" style="width:500px" value="<?php echo $jobdetails['tax_id'];?>"><br><br>
                        Passport No: <input type="text" name="passport_id"  class="form-control" style="width:500px" value="<?php echo $jobdetails['passport'];?>"><br><br>
                        Driving License No: <input type="text" name="driving_id" class="form-control" style="width:500px" value="<?php echo $jobdetails['driving_license'];?>"><br><br>
                        <input class="btn btn-primary" type="submit" name="personal" value="Submit" >   
                    </form>
                    <?php
                }
                ?>



                <?php 
                if(isset($_POST['address']))
                {
                    $query = "SELECT * FROM `address` WHERE emp_id=".$_GET['id'];
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_array($result);

                    ?>
                    <form action="update_employee_process.php?id=<?php echo $_GET['id']?>" method="post" class="" style="width:500px">
                        <b>Present Address:</b><br>
                        Address: <br><input type="text" name="pre_vil" class="form-control" value="<?php echo $row[6];?>"><br>
                        Post Office: <br><input type="text" name="pre_pos" class="form-control" value="<?php echo $row[7];?>"><br>
                        Thana: <br><input type="text" name="pre_tha" class="form-control" value="<?php echo $row[8];?>"><br>
                        District: <br><input type="text" name="pre_dis" class="form-control" value="<?php echo $row[9];?>"><br>
                        Division: <br><input type="text" name="pre_div" class="form-control" value="<?php echo $row[10];?>"><br><br>

                        <b>Permanent Address:</b><br>
                        Address:<br><input type="text" name="per_vil" class="form-control" value="<?php echo $row[1];?>"><br>
                        Post Office: <br><input type="text" name="per_pos" class="form-control" value="<?php echo $row[2];?>"><br>
                        Thana: <br><input type="text" name="per_tha" class="form-control" value="<?php echo $row[3];?>"><br>
                        District: <br><input type="text" name="per_dis" class="form-control" value="<?php echo $row[4];?>"><br>
                        Division: <br><input type="text" name="per_div" class="form-control" value="<?php echo $row[5];?>"><br><br>
                        <input class="btn btn-primary" type="submit" name="address" value="Submit" >
                    </form>


                    <?php      

                }
                ?>




                <?php 
                if(isset($_POST['job_status']))
                {

                    $id=$_GET['id'];
                    $sql ="SELECT * FROM `job_status` WHERE emp_id='$id'";
                    $result = mysqli_query($db, $sql);
                    $row = mysqli_fetch_array($result);

                        /*


                        $query ="SELECT * FROM `job_status` WHERE emp_id=".$row[31];
                        $res = mysqli_query($db, $query);
                        $fetch = mysqli_fetch_array($res);
                        echo "</form>";*/
                        ?>

                        <form method="post" action="update_employee_process.php?id=<?php echo $_GET['id'];?>">
                            Joining Date
                            <input class="form-control" name="joining_date" type="date" style="width:200px" value="<?php echo $row[9];?>"><br>
                            Joining Gross Salary
                            <input class="form-control" name="joining_gross" type="text" style="width:500px" value="<?php echo $row[10];?>"><br>
                            Present Working Station
                            <input class="form-control" name="working_station" type="text" style="width:500px" value="<?php echo $row[14];?>"><br>
                            Employee Status
                            <input class="form-control" name="employee_status" type="text" style="width:500px" value="<?php echo $row[15];?>"><br>
                            Confirmation Status
                            <input class="form-control" name="confirmation_status" type="text" style="width:500px" value="<?php echo $row[17];?>"><br>
                            Confirmation Date
                            <input class="form-control" name="confirmation_date" type="date" style="width:200px" value="<?php echo $row[18];?>"><br>
                            PF Deduction:
                            <input class="form-control" name="pf_deduction" type="text" style="width:500px" value="<?php echo $row[22];?>"><br>
                            Gratuity:
                            <input class="form-control" name="gratuity" type="text" style="width:500px" value="<?php echo $row[23];?>"><br>
                            Hospital Scheme:
                            <input class="form-control" name="scheme" type="text" style="width:500px" value="<?php echo $row[24];?>"><br>
                            Hospital Scheme Range:
                            <input class="form-control" name="scheme_range" type="text" style="width:500px" value="<?php echo $row[25];?>"><br>
                            Salary Account Number: 
                            <input class="form-control" name="salary_account" type="text" style="width:500px" value="<?php echo $row[26];?>"><br>
                            Bank Name: 
                            <input class="form-control" name="bank_name" type="text" style="width:500px" value="<?php echo $row[27];?>"><br>
                            Corporate Sim Number:
                            <input class="form-control" name="corporate_sim" type="text" style="width:500px" value="<?php echo $row[28];?>"><br>
                            OT Status: 
                            <input class="form-control" name="ot_status" type="text" style="width:500px" value="<?php echo $row[29];?>"><br>
                            Income Tax Deduction:
                            <input class="form-control" name="income_tax" type="text" style="width:500px" value="<?php echo $row[30];?>"><br>
                            <h4><u>Refered By</u></h4>
                            ID: 
                            <input class="form-control" name="ref_id" type="text" style="width:500px" value="<?php echo $row[31];?>"><br> 
                            Name: 
                            <input class="form-control" name="ref_name" type="text" style="width:500px" value="<?php echo $row[32];?>"><br>
                            Designation
                            <input class="form-control" name="ref_name" type="text" style="width:500px" value="<?php echo $row[33];?>"><br>
                            <input type="submit" name="job_status" class="btn btn-primary" value="Submit">
                        </form>

                        <?php

                    }

                    ?>

                    <?php
                    if(isset($_POST['emergency']))
                    {
                        $sql ="SELECT * FROM `emergency_contact` WHERE emp_id=".$_GET['id'];
                        $result = mysqli_query($db, $sql);
                        $row = mysqli_fetch_array($result);
                        ?>

                        <form action="update_employee_process.php?id=<?php echo $_GET['id']?>" method="post" class="" style="width:500px">
                            Name
                            <input name="emer_name" value="<?php echo $row[1];?>" type="text" class="form-control" style="width:400px"><br>
                            Relation
                            <input name="emer_rel" value="<?php echo $row[2];?>" type="text" class="form-control" style="width:400px"><br>
                            Contact Number
                            <input name="emer_con" value="<?php echo $row[3];?>" type="text" class="form-control" style="width:400px"><br>
                            <input class="btn btn-primary" type="submit" name="emergency" value="Submit" >
                        </form>

                        <?php
                    }

                    ?>






                    <br><br>



                    <br><br>


                </body>
                <?php// include "html/footer.html"; ?>
            </div>
        </div>
        <!--/span-->

        <!--/span-->

    </div>
</div>

</html>