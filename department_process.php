<?php
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php include 'connect.php';?>
<?php //include "html/navbar.html"; ?>
<?php include "html/bootstrap.html"; ?>
<?php include "html/navbar.php"; ?>
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
<html>
    <head>
    </head>
    <body>
        <div class='container'>
            <?php
            if(isset($_POST['submit'])){
                $name = mysqli_real_escape_string($db, $_POST['name']);
                $under_dep = (int)$_POST['under'];
                $sql = "SELECT * FROM `department` WHERE dep_id=".$under_dep;
                $result = mysqli_query($db, $sql);
                $row = mysqli_fetch_assoc($result);
                $head = $_POST['head'];
                $reporter = $_POST['reporter'];
                $final_dep = $row['dep_name'].".".$name;
                $emp_sql1="SELECT * FROM `employee` WHERE ID='$head'";
                $employee_res1 = mysqli_query($db, $emp_sql1);
                if($employee_res1 -> num_rows===0)
                {
                    echo '<div class="alert alert-danger" align="center">
            <strong>Warning!</strong> Head Does not Exist!!
            </div>';
                }

                else {
                    if($_POST['reporter']!=='')
                    {
                        $emp_sql2="SELECT * FROM `employee` WHERE ID='$reporter'";
                        $employee_res2 = mysqli_query($db, $emp_sql2);
                        if($employee_res2 -> num_rows===0) 
                        {
                            echo '<div class="alert alert-danger" align="center">
            <strong>Warning!</strong> Reporter Does not Exist.
            </div>';
                        }
                        else
                        {

                            $query_id = "SELECT * FROM `employee` WHERE ID='$head'";
                            $result = mysqli_query($db, $query_id);
                            $field=mysqli_fetch_assoc($result);
                            $Email=$field['Email'];
                            $query_id = "SELECT * FROM `employee` WHERE ID='$reporter'";
                            $result = mysqli_query($db, $query_id);
                            $field=mysqli_fetch_assoc($result);
                            $reporter_mail=$field['Email'];


                            $sql ="SELECT * FROM `login` WHERE Username='$head'";
                            $sql1 ="SELECT * FROM `login` WHERE Username='$reporter'";
                            $result= mysqli_query($db, $sql);
                            $result1= mysqli_query($db, $sql1);
                            if($result->num_rows === 0||$result1->num_rows===0)
                            {
                                echo '<div class="alert alert-danger" align="center">
            <strong>Warning!</strong> Head/Reporter Does not have an account!!
            </div>';
                            }

                            else
                            {
                                $query = "INSERT INTO `department`(`dep_name`, `head_id`, `reporting_mail`, `reporter_id`, `reporting_mail_2`) VALUES ('$final_dep','$head', '$Email','$reporter','$reporter_mail')";

                                if(!mysqli_query($db, $query))
                                {
                                    die('Error!! '.mysqli_error($db));

                                }
                                redirect("department_list.php");

                            }




                        }

                    }
                    else
                    {

                        $query_id = "SELECT * FROM `employee` WHERE ID='$head'";
                        $result = mysqli_query($db, $query_id);
                        $field=mysqli_fetch_assoc($result);
                        $Email=$field['Email'];

                        $sql ="SELECT * FROM `login` WHERE Username='$head'";
                        $result= mysqli_query($db, $sql);

                        if($result->num_rows === 0)
                        {
                            echo '<div class="alert alert-danger" align="center">
            <strong>Warning!</strong> Head Does not have an account!!
            </div>';
                        }
                        else
                        {

                            $query = "INSERT INTO `department`(`dep_name`, `head_id`, `reporting_mail`) VALUES ('$final_dep','$head', '$Email')";
                            if(!mysqli_query($db, $query))
                            {
                                die('Error!! '.mysqli_error($db));

                            }
                            redirect("department_list.php");
                        }

                        
                    }

                }


            }
            ?></div>    
    </body>
</html>
