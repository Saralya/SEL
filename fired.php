<?php
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>
<?php include "html/bootstrap.html"; ?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
<title>List of Fired Employees</title>
</head>
<body><?php include 'html/navbar.php'; ?>
<div class="row row-offcanvas row-offcanvas-left">

    <div class="container-fluid" style="padding-left:20px; padding-right:20px;">
        <input class='form-control' placeholder="Search..." type='text' style="width:400px" id="myInput"><br>

        <?php
        $sql="SELECT * FROM history_fire";
        $row=mysqli_query($db,$sql);
        echo '<table width="100%" id="emp_table" class="table table-striped table-bordered">';
        echo '<thead>';
        echo '<tr class="tr_header">';
        echo '<th>Image</th>';
        echo '<th>Employee ID</th>';
        echo '<th>Name</th>';
        echo '<th>Reason</th>';
        echo '<th>Entry Date</th>';
        echo '<th>Approval Date</th>';
        echo '<th>Effective Date</th>';
        echo '<th>Reference</th>';
        echo '<th width="25%">Remarks</th>';
        echo '</thead>';
        echo '</tr>';
        echo '<tbody id="myTable">';
        while($res=mysqli_fetch_array($row))
        {
            $emp=$res['emp_id'];
            $sql="SELECT * FROM employee WHERE ID='$emp'";
            $res_dep=mysqli_query($db, $sql);
            $fetch=mysqli_fetch_array($res_dep);
            $name = $fetch['First Name']." ".$fetch['Last Name'];
            $id = $fetch['ID'];



            ?>
            <tr>
                <td><img src="<?php echo $fetch['image']; ?>" height="50" width="50" class="img-rounded"></td>
                <td><?php echo $id; ?></td>
                <td><a href="jobdetails.php?id=<?php echo $id; ?>" ><?php echo $name ?></a></td>
                <td><?php echo $res['reason'] ?></td>
                <td><?php echo date_format(date_create($res['entry_date']),'d M, Y') ?></td>
                <td><?php echo date_format(date_create($res['approval_date']),'d M, Y') ?></td>
                <td><?php echo date_format(date_create($res['eff_date']),'d M, Y') ?></td>
                <td><?php echo $res['ref'] ?></td>
                <td><pre><?php echo $res['remarks'] ?></pre></td>
            </tr>

            <?php

        }


        mysqli_close($db);
        ?></tbody>
    </table>



    <?php //include "html/footer.html"; ?>


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
