<?php
session_start();
if(!($_SESSION['name']=='admin')){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php include "html/bootstrap.html"; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Activity Log</title>
    </head>

    <body>
        <?php include "html/navbar.php" ?>
        <div class="row row-offcanvas row-offcanvas-left">
            <div class="container-fluid" style="padding-right: 50px;padding-left: 50px">

                <br><h3>Activity Log</h3>
                <div class="row">
                    <div class="">
                        <input class='form-control' placeholder="Search..." type='text' style="width:400px" id="myInput"><br>
                        <?php
    
        $query="SELECT * FROM `notification` ORDER BY `serial` DESC";
        $list=mysqli_query($db,$query);

        echo "<table align='center' border='1' cellpadding='3' cellspacing='3' class='table table-striped'> 
			<tr>
			<th width='100px'>Date</th> 
            <th width='100px'>ID</th> 
            <th width='100px'>Name</th> 
			<th width=''>Activity</th>
            <th width=''>Reference</th>
			</tr>
            <tbody id='myTable'>";

        // output data of each row
        while($row = mysqli_fetch_array($list)) 
        {
            echo "<tr>";
            echo "<td>".date_format(date_create($row['date']),'d-M-Y')."</td>";
            echo "<td>".$row['emp_id']."</td>";
            $whos=$row['emp_id'];
            $sql="SELECT * FROM employee WHERE ID='$whos'";
            $name=mysqli_query($db,$sql);
            $full_name=mysqli_fetch_array($name);
            echo "<td>".$full_name['First Name']." ".$full_name['Last Name']."</td>";
            
            echo "<td>".$row['comment']."</td>";
            echo "<td>".$row['ref']."</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";

        mysqli_close($db);
                        ?>
                        <?php //include "html/footer.html"; ?>
                    </div>
                </div>
            </div>
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
    </body>
</html>
