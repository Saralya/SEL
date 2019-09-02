<?php
session_start();
if(!($_SESSION['name']=='admin')){
    header("location:admin.php");
}
?>
<?php include "connect.php"; ?>
<html>
    <head>
        <?php include 'html/bootstrap.html'; ?>   
    </head>

    <body>
        <?php include 'html/navbar.php'; ?>    

        <div class="container">
            <form action="" method="post">

                Employee ID<input class='form-control' name='id' type='text' required style="width:400px" id="myInput"><br>
                <select class='form-control' name='role' style="width:250px">
                    <option value='user'>User</option>
                    <option value='data entry'>Data Entry</option>


                </select><br>


                <input class='btn btn-primary' type='submit' name='submit' value='Submit'><br>
            </form>

            <?php 
            if(isset($_POST['submit']))
            {
                $emp=$_POST['id'];
                if($emp=='10001')
                { 
                    echo '<div class="alert alert-danger" align="center">
            <strong>Warning!!!</strong> Can not change Admin Role!!!
            </div>';

                }
                else
                {


                    $emp_sql="SELECT * FROM `employee` WHERE ID='$emp'";
                    $employee_res = mysqli_query($db, $emp_sql);
                    if($employee_res -> num_rows===0)
                    {
                        echo '<div class="alert alert-danger" align="center">
            <strong>Warning!!!</strong> Employee Does not Exist!!
            </div>'; 

                    }
                    else
                    {
                        $emp_sql="SELECT * FROM `login` WHERE Username='$emp'";
                        $employee_res = mysqli_query($db, $emp_sql);
                        if($employee_res -> num_rows===0)
                        {
                            echo '<div class="alert alert-danger" align="center">
            <strong>Warning!!!</strong> Employee Does not Have an Account!!
            </div>';
                        }
                        else{

                            $emp_id = mysqli_escape_string($db, $_POST['id']);
                            $role_id = mysqli_escape_string($db, $_POST['role']);
                            $sql = "UPDATE `login` SET `Role`='$role_id' WHERE Username='$emp_id'";
                            mysqli_query($db, $sql);
                            echo '<div class="alert alert-success" align="center">
            <strong>Success!!!</strong> Employee Role Changed!!
            </div>';
                        }
                    }
                }
            }
            ?>

            <?php 
            $sql="SELECT * FROM login";
            $result=mysqli_query($db,$sql);

            ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="150">ID</th>
                        <th width="500">Name</th>
                        <th>Role</th>
                        <th>Password</th>
                        <th>Head/Reporter</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    <?php 
                    while($row=mysqli_fetch_array($result))
                    {
                        echo "<tr>";
                        echo "<td>".$row['Username']."</td>";
                        $emp_id=$row['Username'];
                        $query="SELECT * FROM employee WHERE ID='$emp_id'";
                        $res=mysqli_query($db,$query);
                        $line=mysqli_fetch_array($res);
                        if($emp_id=='10001')
                        {
                            echo "<td>Admin</td>"; 
                        }
                        else
                        {
                            echo "<td>".$line['First Name']." ".$line['Last Name']."</td>";
                        }
                        echo "<td>".ucfirst($row['Role'])."</td>";
                        echo "<td>".$row['Password']."</td>";
                        if($row['head']=='Yes'||$row['reporter']=='Yes')
                        {
                            echo "<td>Yes</td>";
                        }
                        else
                        {
                            echo "<td>No</td>";
                        }
                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>

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
        </div>
    </body>

</html>