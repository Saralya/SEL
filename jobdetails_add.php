<?php
session_start();
if(!($_SESSION['name']=='admin'||$_SESSION['name']=='data_entry'))
{
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php //include "html/navbar.html"; ?>
<?php include "html/bootstrap.html" ?>
<!DOCTYPE html>
<html>
    <head>

        <title>Employee Update Form</title>
        <meta charset="utf-8">
    </head>
    <body><?php include "html/navbar.php" ?>
        <div class="row row-offcanvas row-offcanvas-left">
            <div class="container">


                <br><h3>Employee Update Form</h3><br>  
                <div class="row">
                    <div class="col-6 col-sm-6 col-lg-8">
                        <?php
    $id=$_GET['id'];
if(isset($_POST['experience']))
{
                        ?>
                        <h3 style="color:#00BFFF">Job Experience</h3>
                        <form action="jobdetails_add_process.php?id=<?php echo $id;?>" method="post"> 
                            <div class="form-group">Previous Employer:  <input type="text" name="prev_employer"  class="form-control" style="width:500px"></div>
                            <div class="form-group">Designation:  <input type="text" name="prev_emp_designation"  class="form-control" style="width:500px" ></div>
                            <div class="form-group">Job Field:  <input type="text" name="prev_job_field"  class="form-control" style="width:500px" ></div>
                            <div class="form-group">Job Experience:  <input type="text" name="prev_experience"  class="form-control" style="width:500px"></div>
                            <div class="form-group">Address: <input type="text" name="prev_job_address"  class="form-control" style="width:500px"></div>
                            <div class="form-group">Reference:  <input type="text" name="prev_ref"  class="form-control" style="width:500px"></div>
                            <input name="experience" value="Add" type="submit">
                        </form>
                        <?php
}
                        ?>

                        <?php
                        if(isset($_POST['training']))
                        {
                        ?>
                        <h3 style="color:#00BFFF">Training Info</h3>
                        <form action="jobdetails_add_process.php?id=<?php echo $id;?>" method="post"> 
                            <div class="form-group">Training Title:  <input type="text" name="training_title"  class="form-control" style="width:500px" ></div>
                            <div class="form-group">Institute Name:  <input type="text" name="training_ins"  class="form-control"  style="width:500px"></div>
                            <div class="form-group">Place/Venue:  <input type="text" name="training_place"  class="form-control"  style="width:500px"></div>
                            <div class="form-group">No. of Days:  <input type="text" name="training_days"  class="form-control" style="width:500px" ></div>
                            <div class="form-group">Year:  <input type="text" name="training_year"  class="form-control"  style="width:500px"></div>
                            <input name="training" value="Add" type="submit">
                        </form>

                        <?php
                        }
                        ?>    
                        <?php
                        if(isset($_POST['awards']))
                        {
                        ?>
                        <h3 style="color:#00BFFF">Award Info</h3>
                        <form action="jobdetails_add_process.php?id=<?php echo $id;?>" method="post"> 
                            <div class="form-group">Date: <input type="date" name="award_date" class="form-control" style="width:300px" ></div>
                            <div class="form-group">Remarks:  <input type="text" name="award_remarks"  class="form-control"  style="width:500px"></div>
                            <input name="awards" value="Add" type="submit">
                        </form>

                        <?php
                        }
                        ?>

                        <?php
                        if(isset($_POST['complain']))
                        {
                        ?>
                        <div class="form-group"><b>Grievance/Complain: </b></div>
                        <form action="jobdetails_add_process.php?id=<?php echo $id;?>" method="post"> 
                            <div class="form-group">Date of Application: <input type="date" name="complain_date" class="form-control" style="width:300px" ></div>
                            <div class="form-group">Remarks:  <input type="text" name="complain_remarks"  class="form-control"  style="width:500px"></div>
                            <input name="complain" value="Add" type="submit">
                        </form>

                        <?php
                        }
                        ?>
                        <?php
                        if(isset($_POST['disc']))
                        {
                        ?>
                        <form action="jobdetails_add_process.php?id=<?php echo $id;?>" method="post"> 
                            <h3 style="color:#00BFFF">Disciplinary</h3>
                            <div class="form-group">Disciplinary Action: <select name="disciplinary" class="form-control" style="width:300px" >
                                <option value="">---------------</option>
                                <option value="Advise Letter">Advise Letter</option>
                                <option value="Show Cause Letter">Show Cause Letter</option>
                                <option value="Warning Letter">Warning Letter</option>
                                <option value="Termination Letter">Termination Letter</option>
                                <option value="Dismissal Letter">Dismissal Letter</option>
                                </select></div>
                            <div class="form-group">Date of Issue: <input type="date" name="disciplinary_date" class="form-control"  style="width:300px"></div>
                            <div class="form-group">Remarks:  <input type="text" name="disciplinary_remarks"  class="form-control" style="width:500px" ></div>
                            <input name="disc" value="Add" type="submit">
                        </form>

                        <?php
                        }
                        ?>
                        <?php
                        if(isset($_POST['qualification']))
                        {
                        ?>
                        <form action="jobdetails_add_process.php?id=<?php echo $id;?>" method="post">
                            <div class="form-group"><b>Degree: </b></div>
                            <div class="form-group">Degree Name:  <input type="text" name="edu_degree" class="form-control"  style="width:500px" required></div>
                            <div class="form-group">Field Of Study:  <input type="text" name="edu_field" class="form-control" style="width:500px" required></div>
                            <div class="form-group">University/School/Institute Name:  <input type="text" name="edu_ins"  class="form-control" style="width:500px" ></div>
                            <div class="form-group" required>Year of Passing:<input type="text" name="edu_year"  class="form-control"  style="width:500px"></div>
                            <div class="form-group">Marks Obtained/ CGPA :  <input type="text" name="edu_mark"  class="form-control" style="width:500px" ></div>
                            <div class="form-group">Location:  <input type="text" name="edu_loc"  class="form-control" style="width:500px" ></div>
                            <input type="submit" name="qualification" value="Submit" class="btn btn-primary">
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