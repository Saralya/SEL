<?php
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Leave Information</title>
    </head>

    <body>
        <?php include 'html/navbar.php'; ?>
        <div class='container'>
            <form method="post" action="">
                From<input type="date" name="from" class="form-control" style="width:150px" required>
                To<input type="date" name="to" class="form-control" style="width:150px" required><br>
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
            </form>
            <?php

            if(isset($_POST['submit']))
            {
                echo "<div style='padding-left:300px;padding-right:300px'><div class='panel panel-primary'><div class='panel-heading'><center><big>From ".date_format(date_create($_POST['from']),"d-M-Y")." To ".date_format(date_create($_POST['to']),"d-M-Y")."<br></big></center></div></div></div><br>";
                $query="SELECT * FROM employee";
                $result=mysqli_query($db,$query);
                echo "<table border='1' align='center' cell-padding='5' class='table table-stripe'>";
                echo "<tr>";
                echo "<th width=''>ID</th>";
                echo "<th width=''>Name</th>";
                echo "<th width=''>Casual</th>";
                echo "<th width=''>Sick</th>";
                echo "<th width=''>Annual</th>";
                echo "<th width=''>Maternity</th>";
                echo "<th width=''>Paternity</th>";
                echo "<th width=''>Without Pay Leaves</th>";
                echo "<th width=''>Official Tour</th>";
                echo "<th width=''><font color='red'>Late</font></th>";
                echo "<th width=''>Total Leaves</th>";
                echo "</tr>";
                while($line=mysqli_fetch_array($result))
                {
                    $emp_id=$line['ID'];
                    $sql="SELECT * FROM leaves WHERE EmployeeID='$emp_id' AND status='Approved'";
                    $res=mysqli_query($db,$sql);
                    $a=0;
                    $b=0;
                    $c=0;
                    $d=0;
                    $e=0;
                    $f=0;
                    $g=0;
                    $late=0;
                    while($row=mysqli_fetch_array($res))
                    {

                        if(date_create($_POST['from']) <= date_create($row['From Date']) && date_create($_POST['to']) >= date_create($row['From Date']))
                        { 
                            if($row['Type']=='Casual')
                            {
                                $a=$a+$row['days'];
                            }
                            if($row['Type']=='Sick')
                            {
                                $b=$b+$row['days'];
                            }
                            if($row['Type']=='Annual')
                            {
                                $c=$c+$row['days'];
                            }
                            if($row['Type']=='Maternity')
                            {
                                $d=$d+$row['days'];
                            }
                            if($row['Type']=='Paternity')
                            {
                                $e=$e+$row['days'];
                            }
                            if($row['Type']=='Without Pay Leave')
                            {
                                $f=$f+$row['days'];
                            }
                            if($row['Type']=='Official Tour')
                            {
                                $g=$g+$row['days'];
                            }
                            $late=$late+$row['late'];

                        }


                    }
                    if($a=='0'&&$b=='0'&&$c=='0'&&$d=='0'&&$e=='0'&&$f=='0'&&$g=='0'&&$late=='0') continue;
                    echo "<tr>";
                    echo "<td>".$line['ID']."</td>";
                    echo '<td><a href="jobdetails.php?id='.$line['ID'].'">'.$line['First Name']." ".$line['Last Name'].'</a></td>';
                    echo "<td>".$a."</td>";
                    echo "<td>".$b."</td>";
                    echo "<td>".$c."</td>";
                    echo "<td>".$d."</td>";
                    echo "<td>".$e."</td>";
                    echo "<td>".$f."</td>";
                    echo "<td>".$g."</td>";
                    echo "<td>".$late."</td>";
                    echo "<td>".(int)((int)$a+(int)$b+(int)$c+(int)$d+(int)$e+(int)$f+(int)$g+(int)$late)."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }

            ?>
            <?php

            ?> 





        </div>
    </body>
</html>