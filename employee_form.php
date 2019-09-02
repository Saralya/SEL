<?php
session_start();
if(!($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')){
    header("location:admin.php");
}
?>
<?php include "connect.php"; ?>
<!DOCTYPE html>

<?php include "html/bootstrap.html"; ?> 
<html lang="en">
    <head>
        <title>Employee Form</title>
        <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
        <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="js/employee_form.js"></script>
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
                    xmlhttp.open("GET","check_employee_2.php?q="+str,true);
                    xmlhttp.send();
                }
            }
        </script>
        <link rel="stylesheet" href="Style/employee_form.css">
    </head>
    <body>
        <?php include "html/navbar.php" ?>
        <div class="container">
            <div class="row">

                <form role="form" action="process.php" method="post" enctype="multipart/form-data">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Personal Info</div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="btn btn-default btn-file">
                                    <input type="file" style="display: none;" name="image" onchange="readURL(this);" required>
                                    <img id="blah" src="#" alt="Select Image"/>
                                </label>
                            </div>
                            <div class="form-group">Employee ID:  <input type="text" name="empID"   class="form-control" style="width:500px" onkeyup="showUser(this.value)" required><div id="search"></div></div>
                            <div class="form-group">First Name:  <input type="text" name="first"  class="form-control" style="width:500px" required></div>
                            <div class="form-group">Last Name:  <input type="text" name="last"  class="form-control" style="width:500px" required></div>
                            <div class="form-group">Date of Birth: <input type="date" name="date_of_birth" class="form-control" style="width:500px" required></div>
                            <div class="form-group">Sex: <select name="gender"  class="form-control" style="width:300px" required="required">
                                <option value="">-------</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">Blood Group: <select name="blood" class="form-control" style="width:300px" required="required">
                                <option value="">-------</option>
                                <option value="B +ve">B +ve</option>
                                <option value="B +ve">B -ve</option>
                                <option value="A +ve">A +ve</option>
                                <option value="A -ve">A -ve</option>
                                <option value="AB +ve">AB +ve</option>
                                <option value="AB -ve">AB -ve</option>
                                <option value="O +ve" >O +ve</option>
                                <option value="O -ve">O -ve</option>
                                <option value="N/A">N/A</option>
                                </select></div>
                            <div class="form-group">Height: <input type="number" name="height" class="form-control" style="width:500px"> cm</div>
                            <div class="form-group"><b>Present Address: </b></div>
                            <div class="form-group">Address: <input type="text" name="pre_village" >
                                Post Office: <input type="text" name="pre_post_office" >
                                Thana: <input type="text" name="pre_thana" >
                                District: <input type="text" name="pre_district" >
                                Division: <select name="pre_division">
                                <option value="Dhaka">Dhaka</option>
                                <option value="Chittagong">Chittagong</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Rangpur">Rangpur</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Barishal">Barishal</option>
                                <option value="Mymensingh">Mymensingh</option>
                                </select></div>
                            <input type="checkbox" name="billingtoo" onclick="FillBilling(this.form)">
                            <em>Check this box if Present Address and Permanent Address are the same.</em>
                            <div class="form-group"><b>Permanent Address: </b></div>
                            <div class="form-group">Address: <input type="text" name="per_village" >
                                Post Office: <input type="text" name="per_post_office" >
                                Thana: <input type="text" name="per_thana" >
                                District: <input type="text" name="per_district" >
                                Division: <select name="per_division">
                                <option value="Dhaka">Dhaka</option>
                                <option value="Chittagong">Chittagong</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Rangpur">Rangpur</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Barishal">Barishal</option>
                                <option value="Mymensingh">Mymensingh</option>
                                </select></div>

                            <script>
                                function FillBilling(f) {
                                    if(f.billingtoo.checked == true) {
                                        f.per_village.value = f.pre_village.value;
                                        f.per_post_office.value = f.pre_post_office.value;
                                        f.per_thana.value = f.pre_thana.value;
                                        f.per_district.value = f.pre_district.value;
                                        f.per_division.value = f.pre_division.value;           
                                    }
                                }
                            </script>

                            <div class="form-group">Cell Number: <input type="text" name="phone"  class="form-control" style="width:500px"></div>
                            <div class="form-group">Present E-mail Address: <input type="email" name="email"  class="form-control" style="width:500px" required></div>                
                            <div class="form-group">Father's Name:  <input type="text" name="father"  class="form-control" style="width:500px" ></div>
                            <div class="form-group">Mother's Name:  <input type="text" name="mother"  class="form-control" style="width:500px"></div>
                            <div class="form-group">Name of Spouse:  <input type="text" name="spouse"  class="form-control" placeholder="Leave Blank if Unmarried" style="width:500px" ></div>

                            <div class="form-group">Number of Children:  <input type="text" name="child"  class="form-control" style="width:500px"></div>
                            <div class="form-group">National ID Card No: <input type="text" name="national_id" class="form-control" style="width:500px"></div>
                            <div class="form-group">Tax ID No: <input type="text" name="tax_id" class="form-control" style="width:500px"></div>
                            <div class="form-group">Passport No: <input type="text" name="passport_id"  class="form-control" style="width:500px"></div>
                            <div class="form-group">Driving License No: <input type="text" name="driving_id" class="form-control" style="width:500px"></div>

                            <div class="form-group"><b>	Emergency Contact Person: </b></div>
                            <div class="form-group">Name: <input type="text" name="emer_name"  class="form-control" style="width:500px" ></div>
                            <div class="form-group">Relation:  <input type="text" name="emer_rel"  class="form-control" style="width:500px"></div>
                            <div class="form-group">Contact No:  <input type="text" name="emer_phone"  class="form-control" style="width:500px">
                            </div>
                        </div>							
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">Immediate Job Experience</div>
                        <div class="panel-body">
                            <div class="form-group">Previous Employer:  <input type="text" name="prev_employer"  class="form-control" style="width:500px"></div>
                            <div class="form-group">Designation:  <input type="text" name="prev_emp_designation"  class="form-control" style="width:500px" ></div>
                            <div class="form-group">Job Field:  <input type="text" name="prev_job_field"  class="form-control" style="width:500px" ></div>
                            <div class="form-group">Job Experience(Years):  <input type="number" name="prev_experience"  class="form-control" style="width:500px"></div>
                            <div class="form-group">Address: <input type="text" name="prev_job_address"  class="form-control" style="width:500px"></div>
                            <div class="form-group">Reference: <input type="text" name="prev_ref"  class="form-control" style="width:500px"></div>
                        </div>
                    </div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">Current Employment Status</div>
                        <div class="panel-body">
                            <div class="form-group">Designation:  
                                <div class="form-group">
                                    <select name="curr_designation"  class="form-control" style="width:500px" required>
                                        <option value="">------------</option>
                                        <?php
    $sql="SELECT DISTINCT designations FROM designation ORDER BY designations";
        $res=mysqli_query($db, $sql);
        while($row=mysqli_fetch_array($res))
        {
            echo "<option value='".$row['designations']."'>".$row['designations']."</option>";
        }
                                        ?>
                                    </select></div>
                                <!-- <div class="form-group">Previous Designation:  <input type="text" name="prev_designation"  class="form-control" style="width:500px" ></div> -->
                                <div class="form-group">Department: <select name="curr_department" class="form-control" style="width:500px">
                                    <?php 	

                                    $query = "SELECT department.*, employee.* FROM `department` JOIN employee ON department.head_id=employee.ID ORDER BY department.dep_id";
                                    $result = mysqli_query($db, $query);
                                    if($result->num_rows === 0)
                                    {
                                        $sql = "SELECT * FROM department WHERE dep_name = 'Head Office'";
                                        $result=mysqli_query($db, $sql);
                                        $row=mysqli_fetch_array($result);
                                        echo "<option selected='selected' value='" . $row['dep_id'] ."'>" . $row['dep_name'] . " (Head: N/A)</option>";
                                    }
                                    else
                                    {

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['dep_id'] ."'>" . $row['dep_name'] ." (Head: ".$row['First Name']." ".$row['Last Name'].")</option>";

                                        }}
                                    echo "</select>";

                                    ?> </div>


                                    <div class="form-group">Date of Joining: <input type="date" name="joining_date" class="form-control" style="width:300px" required></div>

                                    <div class="form-group">Joining Gross Salary:  <input type="text" name="joining_gross"  class="form-control" style="width:500px" required></div>
                                    <div class="form-group">Current Gross Salary:  <input type="text" name="current_gross"  class="form-control" style="width:500px" required></div>

                                    <div class="form-group">Present Working Station:  <input type="text" name="present_working_station"  class="form-control" style="width:500px" ></div>
                                    <div class="form-group">Employee Status:  <input type="text" name="employee_status"  class="form-control" style="width:500px"></div>
                                    <div class="form-group">Confirmation Status:  <input type="text" name="confirmation_status"  class="form-control" style="width:500px"></div>
                                    <div class="form-group">Confirmation / Extension Date: <input type="date" name="confirmation_date" class="form-control" style="width:300px" required></div>
                                    <div class="form-group">Employment Type:  
                                        <select name="employment_type"  class="form-control" style="width:500px" required>
                                            <option value="">----------</option>
                                            <option value="Regular">Regular</option>
                                            <option value="Contractual">Contractual</option>
                                            <option value="On Probation">On Probation</option>
                                            <option value="Part Time">Part Time</option>
                                            <option value="Part Time">Intern</option>
                                        </select></div>
                                    <div class="form-group">Employee Separation Remarks:  <input type="text" name="employee_separation"  class="form-control" style="width:500px" ></div>
                                    <div class="form-group">Employee Separation Date: <input type="date" name="employee_separation_date" class="form-control" style="width:300px" required></div>

                                    <div class="form-group">Salary Account No:  <input type="text" name="salary_account"  class="form-control"  style="width:500px"></div>
                                    <div class="form-group">Bank Name:  <input type="text" name="bank"  class="form-control"  style="width:500px"></div>
                                    <div class="form-group">Corporate Cell No:  <input type="text" name="corporate_sim"  class="form-control"  style="width:500px"></div>
                                    <div class="form-group">Over Time (OT) Status: 
                                        <input type="radio" name="ot_status" value="Yes"> Yes  
                                        <input type="radio" name="ot_status" value="No"> No<br>
                                    </div>

                                    <div class="form-group"><b>Referred By: </b></div>
                                    <div class="form-group">Name of Employee:  <input type="text" name="reffered_name"  class="form-control" style="width:500px" ></div>
                                    <div class="form-group">Designation:  <input type="text" name="reffered_designation"  class="form-control" style="width:500px" ></div>
                                    <div class="form-group">Employee ID:  <input type="text" name="reffered_by"   class="form-control" style="width:500px"></div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-primary">
                            <div class="panel-heading">Academic Qualification</div>
                            <div class="panel-body">


                                <?php
                                for ($i=0; $i<1; $i++)
                                {

                                    echo '<div class="form-group"></div>
<div class="form-group">Degree Name:  <input type="text" name="edu_degree'.$i.'"  class="form-control"  style="width:500px" ></div>
<div class="form-group">Field Of Study:  <input type="text" name="edu_field'.$i.'"  class="form-control" style="width:500px" ></div>
<div class="form-group">University/School/Institute Name:  <input type="text" name="edu_ins'.$i.'"  class="form-control" style="width:500px" ></div>
<div class="form-group">Year of Passing:<input type="text" name="edu_year'.$i.'"  class="form-control"  style="width:500px"></div>
<div class="form-group">Marks Obtained/ CGPA :  <input type="text" name="edu_mark'.$i.'"  class="form-control" style="width:500px" ></div>
<div class="form-group">Location:  <input type="text" name="edu_loc'.$i.'"  class="form-control" style="width:500px" ></div>';

                                }
                                ?>


                            </div>

                        </div>

                        <div class="panel panel-primary">
                            <div class="panel-heading">Training Info</div>
                            <div class="panel-body">

                                <div class="form-group">Training Title:  <input type="text" name="training_title"  class="form-control" style="width:500px" ></div>
                                <div class="form-group">Institute Name:  <input type="text" name="training_ins"  class="form-control"  style="width:500px"></div>
                                <div class="form-group">Place/Venue:  <input type="text" name="training_place"  class="form-control"  style="width:500px"></div>
                                <div class="form-group">No. of Days:  <input type="text" name="training_days"  class="form-control" style="width:500px" ></div>
                                <div class="form-group">Year:  <input type="text" name="training_year"  class="form-control"  style="width:500px"></div>
                            </div>

                        </div>



                        <div>
                            <h2 style="color:green">Completed!</h2><br>

                            <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-md"><br><br>
                        </div>

                        </form>

                    </div>
            </div>
            </body>
        </html>