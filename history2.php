<?php
session_start();
if(!($_SESSION['name']=='admin'||$_SESSION['name']=='head'||$_SESSION['name']=='reporter'||$_GET['id']==$_SESSION['id'])){
    header("location:admin.php");
}
?>
<?php include 'connect.php';?>
<?php //include "html/navbar.html"; ?>
<?php include "html/bootstrap.html"; ?>
<html>
    <head></head>
    <body>
        <?php include "html/navbar.php"; ?>

        <form method="post" action="">
            <br>
            History:<select name='type'>
            <option value='salary'>Salary</option>
            <option value='designation'>Designation</option>
            <option value='department'>Department</option>
            <option value='leaves'>Leaves</option>
            </select>
            <input type="submit" name="submit" value="Submit">

        </form>
        <?php if(isset($_POST['submit']))
{
    $emp_id=$_GET['id'];

    if($_POST['type']=='salary')
    {
        echo "Salary History: <br>";
        $sql="SELECT * FROM history_salary WHERE emp_id='$emp_id'";
        $res=mysqli_query($db, $sql);
        echo "<table align='center' border='1'>";
        echo "<tr>";
        echo "<th width='150px'>Entrier</th>";

        echo "<th width='150px'>Date</th>";
        echo "<th width='150px'>Amount</th>";
        echo "</tr>";
        while($row=mysqli_fetch_array($res))
        {
            echo "<tr>";
            if($row[2]=='10001')
            {
                echo "<td>Admin</td>";
            }
            else
            {
                $id=$row[2];
                $sql ="SELECT * FROM employee WHERE ID='$id'";
                $result=mysqli_query($db, $sql);
                $line=mysqli_fetch_array($result);
                echo "<td>".$line['First Name']." ".$line['Last Name']."</td>";
            }

            echo "<td>".$row[4]."</td>";
            echo "<td>".$row[5]."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }  
    else if($_POST['type']=='department')
    {
        echo "Department History: <br>";
        $sql="SELECT * FROM history_department  WHERE emp_id='$emp_id'";
        $res=mysqli_query($db, $sql);
        echo "<table align='center' border='1'>";
        echo "<tr>";
        echo "<th width='150px'>Entrier</th>";

        echo "<th width='150px'>From</th>";
        echo "<th width='150px'>To</th>";
        echo "<th width='150px'>Date</th>";
        echo "</tr>";
        while($row=mysqli_fetch_array($res))
        {
            echo "<tr>";
            if($row[2]=='10001')
            {
                echo "<td>Admin</td>";
            }
            else
            {
                $id=$row[2];
                $sql ="SELECT * FROM employee WHERE ID='$id'";
                $result=mysqli_query($db, $sql);
                $line=mysqli_fetch_array($result);
                echo "<td>".$line['First Name']." ".$line['Last Name']."</td>";
            }

            $sql = "SELECT * FROM department WHERE dep_id=".$row[4];
            $result=mysqli_query($db, $sql);
            $line=mysqli_fetch_array($result);
            echo "<td>".$line['dep_name']."</td>";
            $sql = "SELECT * FROM department WHERE dep_id=".$row[5];
            $result=mysqli_query($db, $sql);
            $line=mysqli_fetch_array($result);
            echo "<td>".$line['dep_name']."</td>";
            echo "<td>".$row[6]."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }  
    else if($_POST['type']=='designation')
    {
        echo "Designation History: <br>";
        $sql="SELECT * FROM history_designation  WHERE emp_id='$emp_id'";
        $res=mysqli_query($db, $sql);
        echo "<table align='center' border='1'> ";
        echo "<tr>";
        echo "<th width='150px'>Entrier</th>";

        echo "<th width='150px'>From</th>";
        echo "<th width='150px'>To</th>";
        echo "<th width='150px'>Date</th>";
        echo "</tr>";
        while($row=mysqli_fetch_array($res))
        {
            echo "<tr>";
            if($row[2]=='10001')
            {
                echo "<td>Admin</td>";
            }
            else
            {
                $id=$row[2];
                $sql ="SELECT * FROM employee WHERE ID='$id'";
                $result=mysqli_query($db, $sql);
                $line=mysqli_fetch_array($result);
                echo "<td>".$line['First Name']." ".$line['Last Name']."</td>";
            }

            echo "<td>".$row[4]."</td>";
            echo "<td>".$row[5]."</td>";
            echo "<td>".$row[6]."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else if($_POST['type']=='leaves')
    {
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
        redirect("personal_leave_info.php?id=$emp_id");
    }

}
        ?>

    </body>

</html>