<?php
session_start();
if(!($_SESSION['name']=='admin')){
    header("location:admin.php");
}
?>
<?php include "connect.php"; ?>
<?php include "html/bootstrap.html"; ?>
<html>
    <head>
        <title>Temporary Head Selection</title>
        <script>
            function ValidateEndDate() {
                var objFromDate = document.getElementById("from_date").value;
                var objToDate = document.getElementById("to_date").value;
                if(objToDate){

                    if(objFromDate > objToDate)
                    {
                        alert("Invalid Date Range!!");
                        document.getElementById("submit").disabled=true;
                        return false;
                    }
                }
                document.getElementById("submit").disabled=false; 
            }
        </script>
    </head>
    <body>
        <?php include "html/navbar.php"; ?>
        <div class="container">
            <h3><center><a>Assign a Temporary Supersuser</a></center></h3>
            <?php
            date_default_timezone_set('Asia/Dhaka');
            $date = date('Y-m-d', time());
           
            if(isset($_POST['submit']))
            {
                $emp=mysqli_real_escape_string($db,$_POST['temp']);
                $to_date=$_POST['to_date'];
                $from_date=$_POST['from_date'];
                mysqli_query($db,"UPDATE login SET Role='admin', to_date='$to_date', from_date='$from_date' WHERE Username='$emp'");
            }
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <form action="" method="post">
                        <label>Temporary Supersuser:</label>
                        <select name="temp" class="form-control" style="width:300px" required>
                            <option value="">---------</option>
                            <?php
                            $result=mysqli_query($db,"SELECT * FROM login WHERE Username!= '10001'");
                            while($row=mysqli_fetch_array($result))
                            {
                                $id=$row['Username'];
                                $res=mysqli_query($db,"SELECT * FROM employee WHERE ID='$id' ");
                                $data=mysqli_fetch_array($res);
                                $name=$data['First Name']." ".$data['Last Name'];
                                echo "<option value='".$id."'>".$name."</option>";
                            }
                            ?>
                        </select>
                        <br />
                        <label>From Date:</label>
                        <input type="date" min="<?php echo $date; ?>" name="from_date" id="from_date" class="form-control" style="width:300px" onchange="ValidateEndDate()" required>
                        <br />
                        <label>To Date:</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" style="width:300px" onchange="ValidateEndDate()" required>
                        <br />
                        <input type="submit" id="submit" name="submit" class="btn btn-primary btn-sm">
                    </form>
                </div>
                <div class="col-sm-6">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th colspan="3"><center>Current Supersuser(s)</center></th>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Time Range</th>
                        </tr>
                        <?php
                        $res=mysqli_query($db,"SELECT * FROM login WHERE Role='admin'");
                        while($row=mysqli_fetch_array($res))
                        {
                            $id=$row['Username'];
                            $result=mysqli_query($db,"SELECT * FROM employee WHERE ID='$id' ");
                            $data=mysqli_fetch_array($result);
                            $name=$data['First Name']." ".$data['Last Name'];
                            echo "<tr>";
                            echo "<td>".$id."</td>";
                            if($id=='10001')
                            {
                                echo "<td>Admin</td>";
                                echo "<td class='success'>Permanent</td>";
                            }
                            else
                            {
                                echo "<td>".$name."</td>";
                                echo "<td>".date_format(date_create($row['from_date']),"M d, Y")." - ".date_format(date_create($row['to_date']),"M d, Y")."</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>