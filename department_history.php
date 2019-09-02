<?php
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>

<?php include 'connect.php'; ?>
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
        <title>Department Record</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
        <style>
            table {
                border:none;
                border-collapse: collapse;
            }

            table td {
                border-left: 2px solid #f5f5f5;
                border-right: 2px solid #f5f5f5;
            }

            table th {
                border-left: 2px solid #f5f5f5;
                border-right: 2px solid #f5f5f5;
            }

            table td:first-child {
                border-left: none;
            }

            table td:last-child {
                border-right: none;
            }

            table th:first-child {
                border-left: none;
            }

            table th:last-child {
                border-right: none;
            }
        </style>

    </head>
    <body><?php include 'html/navbar.php'; ?>
        <div class="container">

            <?php
            $id=$_GET['id'];
            $sql="SELECT * FROM department_record WHERE dep_id='$id'";
            $result=mysqli_query($db, $sql);

            if($result->num_rows === 0)
            {
                echo '<div class="alert alert-danger" align="center">
                <strong>No history to display!!!</strong>
            </div>';
            }
            else
            {

                echo '<table width="100%" id="emp_table" class="table table-striped">';
                echo '<thead>';
                echo '<tr class="tr_header">';
                echo '<th>Type</th>';
                echo '<th>History</th>';
                echo '<th>Entrier</th>';
                echo '<th>Entry Date</th>';
                echo '<th>Approval Date</th>'; 
                echo '<th>Effective Date</th>'; 
                echo '</thead>';
                echo '</tr>';
                echo '<tbody id="myTable">';

                while($row=mysqli_fetch_array($result))
                {
                    $dir=$row['history'];
                    $sql="SELECT * FROM employee WHERE ID='$dir'";
                    $res=mysqli_query($db, $sql);
                    $data=mysqli_fetch_array($res);
                    echo "<tr>";
                    if($row['type']=='head')
                    {
                        echo "<td class='success'>Head Assignment</td>";


                    }
                    else if($row['type']=='reporter')
                    {
                        echo "<td class='warning'>Reporter Assignment</td>";


                    }
                    echo "<td><a href='jobdetails.php?id=".$dir."'>".$data['First Name']." ".$data['Last Name']." </a> (ID: <b>".$dir."</b>)</td>";
                    if($_SESSION['name']=='admin')
                    {
                        echo "<td>Admin</td>"; 
                    }
                    else
                    {
                        $entry_id=$row['entrier'];
                        $query="SELECT * employee WHERE ID='$entry_id'";
                        $res_2=mysqli_query($db,$query);
                        $row_2=mysqli_fetch_array($res_2);
                        echo "<td>".$row_2['First Name']." ".$row_2['Last Name']."</td>";
                    }
                   
                    echo "<td>".date_format(date_create($row['entry_date']),"d M, Y")."</td>"; 
                    echo "<td>".date_format(date_create($row['approval_date']),"d M, Y")."</td>"; 
                    echo "<td>".date_format(date_create($row['eff_date']),"d M, Y")."</td>"; 
                    echo "</tr>";
                }

                echo '</table>';

            }

            ?>


        </div>
    </body>
</html>