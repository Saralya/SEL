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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Facility</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
        <style>
            .box
            {
                width:800px;
                margin:0 auto;
            }
            .active_tab1
            {
                background-color:#fff;
                color:#333;
                font-weight: 600;
            }
            .inactive_tab1
            {
                background-color: #f5f5f5;
                color: #333;
                cursor: not-allowed;
            }
            .has-error
            {
                color: #cc0000; 
            }
        </style>
    </head>
    <body>
        <?php include "html/navbar.php" ?>
        <br />
        <div class="container box">
            <?php 
    $emp=$_GET['id'];
        $sql="SELECT * FROM `employee` WHERE ID='$emp'";
        $result=mysqli_query($db, $sql);
        $row=mysqli_fetch_array($result);
        $name=$row['First Name']." ".$row['Last Name'];
        $image=$row['image'];
        $sql="SELECT * FROM `job_status` WHERE emp_id='$emp'";
        $result=mysqli_query($db, $sql);
        $row=mysqli_fetch_array($result);
        $employment=$row['employment_type'];
        echo "<img src='".$image."' height='50px' width='50px' class='img-rounded'>"." <a href='history.php?id=$emp'><big>".$name."</big></a><br><br>"; 
            ?>
            
            <br />

            <h2 align="center">Facilities to Employee</h2><br />
            <form method="post" id="facility_form" action="change_facility_process.php?id=<?php echo $emp; ?>">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active_tab1" style="border:1px solid #ccc" id="list_hos_scheme">Hospitalization Scheme</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link inactive_tab1" id="list_gratuity" style="border:1px solid #ccc">Gratuity</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link inactive_tab1" id="list_income_tax" style="border:1px solid #ccc">Income Tax</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link inactive_tab1" id="list_prof_fund" style="border:1px solid #ccc">Provident Fund</a>
                    </li>

                </ul>
                <div class="tab-content" style="margin-top:16px;">
                    <div class="tab-pane active" id="hos_scheme">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Hospitalization Scheme</div>
                            <div class="panel-body">
                               
                                <div class="form-group">
                                    <label>Medical Coverage: </label><input name="mc" id="mc" type="text" class="form-control" style="width: 300px">
                                </div>
                                <div class="form-group">
                                    <label>Joining Date to HS: </label><input type="date" id="hos_date" name="hos_date" class="form-control" style="width: 300px">
                                </div>
                                <div class="form-group">
                                    <label>Monthly Premium Charged:</label> <input type="number" class="form-control" name="pc" id="pc" style="width: 300px">
                                </div>
                                <div class="form-group">
                                    <label>Remarks: </label>
                                    <textarea type="text" name="hos_remark" id="hos_remark" class="form-control"></textarea>
                                </div>
                                <span id="error_hos_scheme" class="text-danger"></span>

                                <br />
                                <div align="center">
                                    <button type="button" name="btn_hos_scheme" id="btn_hos_scheme" class="btn btn-info btn-md">Next</button>
                                </div>
                                <br />
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="gratuity">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Gratuity</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Benefit Package:</label>
                                    <br />
                                    <select name="bp" id="bp" class="form-control" style="width: 400px">
                                        <option value="" selected>---------</option>
                                        <option value="33% of Gross">Above 3 Years but below 5 Years (33% of Gross)</option>
                                        <option value="66% of Gross">Above 5 Years but below 10 Years (66% of Gross)</option>
                                        <option value="100% of Gross">Above 10 Years (100% of Gross)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Gratuity Disbursent:</label>
                                    <input type="number" name="gd_tk" id="gd_tk" placeholder="TK." class="form-control" style="width: 150px">X<input type="number" name="gd_y" id="gd_y" placeholder="No. Years" style="width: 200px" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Remarks: </label>
                                    <textarea type="text" name="gratuity_remark" id="gratuity_remark" class="form-control"></textarea>
                                </div>
                                <br />
                                <span id="error_gratuity" class="text-danger"></span>
                                <div align="center">
                                    <button type="button" name="previous_btn_gratuity" id="previous_btn_gratuity" class="btn btn-default btn-md">Previous</button>
                                    <button type="button" name="btn_gratuity" id="btn_gratuity" class="btn btn-info btn-md">Next</button>
                                </div>
                                <br />
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="income_tax">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Income Tax</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>TIN No.</label>
                                    <input type='text' name="tin" id="tin" class="form-control" style="width: 300px">
                                </div>
                                <div class="form-group">
                                    <label>Monthly Deduction</label>
                                    <input type="number" name="tax_d" id="tax_d" class="form-control" style="width: 300px">
                                </div>
                                <div class="form-group">
                                    <label>Remarks: </label>
                                    <textarea type="text" name="tax_remark" id="tax_remark" class="form-control"></textarea>
                                </div>
                                <br />
                                <span id='error_tax' class="text-danger"></span>
                                <div align="center">
                                    <button type="button" name="previous_btn_income_tax" id="previous_btn_income_tax" class="btn btn-default btn-md">Previous</button>
                                    <button type="button" name="btn_income_tax" id="btn_income_tax" class="btn btn-info btn-md">Next</button>
                                </div>

                                <br />
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="prof_fund">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Provident Fund</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Joining Date to PF: </label>
                                    <input type="date" name="pf_date" id="pf_date" class="form-control" style="width: 300px">
                                </div>
                                <div class="form-group">
                                    <label>Monthly PF Contribution:</label>
                                    <input type="number" name="pf_con" id="pf_con" class="form-control" style="width: 300px">
                                </div>
                                <div class="form-group">
                                    <label>Remarks: </label>
                                    <textarea type="text" name="pf_remark" id="pf_remark" class="form-control"></textarea>
                                </div>
                                <br />
                                <span id='error_pf' class="text-danger"></span>
                                <div align="center">
                                    <button type="button" name="previous_btn_prof_fund" id="previous_btn_prof_fund" class="btn btn-default btn-md">Previous</button>
                                    <button type="button" name="btn_prof_fund" id="btn_prof_fund" class="btn btn-success btn-md">Submit</button>
                                </div>
                                <br />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>

<script>
    $(document).ready(function(){

        $('#btn_hos_scheme').click(function(){

            var error_hos_scheme = '';
            var error_count = 0;


            if($.trim($('#mc').val()).length == 0)
            {
                error_count++;
            }
            if($.trim($('#hos_date').val()).length == 0)
            {
                error_count++;
            }

            if($.trim($('#pc').val()).length == 0)
            {
                error_count++;
            }

            if($.trim($('#hos_remark').val()).length ==0)
            {
                error_count++;
            }

            if(error_count != 0 && error_count != 4)
            {
                error_hos_scheme = 'Please Fill Up all the field!';
                $('#error_hos_scheme').text(error_hos_scheme);
                return false;
            }
            else
            {
                $('#list_hos_scheme').removeClass('active active_tab1');
                $('#list_hos_scheme').removeAttr('href data-toggle');
                $('#hos_scheme').removeClass('active');
                $('#list_hos_scheme').addClass('inactive_tab1');
                $('#list_gratuity').removeClass('inactive_tab1');
                $('#list_gratuity').addClass('active_tab1 active');
                $('#list_gratuity').attr('href', '#gratuity');
                $('#list_gratuity').attr('data-toggle', 'tab');
                $('#gratuity').addClass('active in');
            }
        });

        $('#previous_btn_gratuity').click(function(){
            $('#list_gratuity').removeClass('active active_tab1');
            $('#list_gratuity').removeAttr('href data-toggle');
            $('#gratuity').removeClass('active in');
            $('#list_gratuity').addClass('inactive_tab1');
            $('#list_hos_scheme').removeClass('inactive_tab1');
            $('#list_hos_scheme').addClass('active_tab1 active');
            $('#list_hos_scheme').attr('href', '#hos_scheme');
            $('#list_hos_scheme').attr('data-toggle', 'tab');
            $('#hos_scheme').addClass('active in');
        });

        $('#btn_gratuity').click(function(){
            var error_gratuity = '';
            var error_count = 0;


            if($.trim($('#bp').val()).length == 0)
            {
                error_count++;
            }
            if($.trim($('#gd_tk').val()).length == 0)
            {
                error_count++;
            }
            if($.trim($('#gd_y').val()).length == 0)
            {
                error_count++;
            }

            if($.trim($('#gratuity_remark').val()).length ==0)
            {
                error_count++;
            }


            if(error_count != 0 && error_count != 4)
            {
                error_gratuity = 'Please Fill Up all the field!';
                $('#error_gratuity').text(error_gratuity);
                return false;
            }
            else
            {
                $('#list_gratuity').removeClass('active active_tab1');
                $('#list_gratuity').removeAttr('href data-toggle');
                $('#gratuity').removeClass('active');
                $('#list_gratuity').addClass('inactive_tab1');
                $('#list_income_tax').removeClass('inactive_tab1');
                $('#list_income_tax').addClass('active_tab1 active');
                $('#list_income_tax').attr('href', '#prof_fund');
                $('#list_income_tax').attr('data-toggle', 'tab');
                $('#income_tax').addClass('active in');
            }
        });

        $('#previous_btn_income_tax').click(function(){
            $('#list_income_tax').removeClass('active active_tab1');
            $('#list_income_tax').removeAttr('href data-toggle');
            $('#income_tax').removeClass('active in');
            $('#list_income_tax').addClass('inactive_tab1');
            $('#list_gratuity').removeClass('inactive_tab1');
            $('#list_gratuity').addClass('active_tab1 active');
            $('#list_gratuity').attr('href', '#gratuity');
            $('#list_gratuity').attr('data-toggle', 'tab');
            $('#gratuity').addClass('active in');
        });

        $('#btn_income_tax').click(function(){
            var error_tax = '';
            var error_count = 0;

            if($.trim($('#tin').val()).length == 0)
            {
                error_count++;
            }
            if($.trim($('#tax_d').val()).length == 0)
            {
                error_count++;
            }

            if($.trim($('#tax_remark').val()).length ==0)
            {
                error_count++;
            }

            if(error_count != 0 && error_count != 3)
            {

                error_tax = 'Please Fill Up all the field!';
                $('#error_tax').text(error_tax);
                return false;


            }
            else
            {
                $('#list_income_tax').removeClass('active active_tab1');
                $('#list_income_tax').removeAttr('href data-toggle');
                $('#income_tax').removeClass('active');
                $('#list_income_tax').addClass('inactive_tab1');
                $('#list_prof_fund').removeClass('inactive_tab1');
                $('#list_prof_fund').addClass('active_tab1 active');
                $('#list_prof_fund').attr('href', '#prof_fund');
                $('#list_prof_fund').attr('data-toggle', 'tab');
                $('#prof_fund').addClass('active in');
            }
        });

        $('#previous_btn_prof_fund').click(function(){
            $('#list_prof_fund').removeClass('active active_tab1');
            $('#list_prof_fund').removeAttr('href data-toggle');
            $('#prof_fund').removeClass('active in');
            $('#list_prof_fund').addClass('inactive_tab1');
            $('#list_income_tax').removeClass('inactive_tab1');
            $('#list_income_tax').addClass('active_tab1 active');
            $('#list_income_tax').attr('href', '#gratuity');
            $('#list_income_tax').attr('data-toggle', 'tab');
            $('#income_tax').addClass('active in');
        });

        $('#btn_prof_fund').click(function(){

            var error_pf = '';
            var error_count=0;

            if($.trim($('#pf_date').val()).length == 0)
            {
                error_count++;
            }


            if($.trim($('#pf_con').val()).length == 0)
            { 
                error_count++;
            }

            if($.trim($('#pf_remark').val()).length ==0)
            {
                error_count++;
            }

            if(error_count != 0 && error_count != 3)
            {
                error_pf = 'Please Fill Up all the field!';
                $('#error_pf').text(error_pf);
                return false;

            }
            else
            {
                $('#btn_prof_fund').attr("disabled", "disabled");
                $(document).css('cursor', 'prgress');
                $("#facility_form").submit();
            }

        });

    });
</script>