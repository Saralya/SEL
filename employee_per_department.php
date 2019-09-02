<?php
session_start();
if($_SESSION['name']!='admin'){
    header("location:admin.php");
}
?>
<?php include "connect.php" ; ?>
<?php include "html/bootstrap.html" ?>

<?php 
    $sql ="SELECT * FROM department WHERE dep_id=".$_GET['id'];
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_array($result);
$department_name = $row['dep_name'];
?>
<!doctype html>
<html>
    <head>
        <title><?php echo $department_name;?></title>
        <?php

        $rowperpage = 15;
        $row = 0;

        // Previous Button
        if(isset($_POST['but_prev'])){
            $row = $_POST['row'];
            $row -= $rowperpage;
            if( $row < 0 ){
                $row = 0;
            }
        }

        // Next Button
        if(isset($_POST['but_next'])){
            $row = $_POST['row'];
            $allcount = $_POST['allcount'];

            $val = $row + $rowperpage;
            if( $val < $allcount ){
                $row = $val;
            }
        }

        ?>
    </head>
    <body><?php include "html/navbar.php" ?>
        <div class="row row-offcanvas row-offcanvas-left">

            <div class="container">

                <br><h3>Employee List of <?php echo "'".$department_name."'";?></h3><br>  
                <div class="row">
                    <div class="col-6 col-sm-6 col-lg-8">
                        <div id="content">
                            <table border='2' width="100%" id="emp_table" border="0">
                                <tr class="tr_header">
                                    <th >Employee ID</th>
                                    <th >Name</th>
                                </tr>
                                <?php
                                // count total number of rows
                                $sql = "SELECT COUNT(*) AS cntrows FROM `employee` WHERE department_id=".$_GET['id'];
                                $result = mysqli_query($db,$sql);
                                $fetchresult = mysqli_fetch_array($result);
                                $allcount = $fetchresult['cntrows'];

                                // fetch rows
                                $sql = "SELECT * FROM `employee` WHERE department_id=".$_GET['id']." limit $row,".$rowperpage;
                                $result = mysqli_query($db,$sql);
                                $sno = $row + 1;
                                while($fetch = mysqli_fetch_array($result)){
                                    $name = $fetch['First Name']." ".$fetch['Last Name'];
                                    $id = $fetch['ID'];
                                ?>
                                <tr>
                                    <td align='center'><?php echo $id; ?></td>
                                    <td><a href="jobdetails.php?id=<?php echo $id; ?>"><?php echo $name ?></a></td>

                                </tr>
                                <?php
                                    $sno ++;
                                }
                                ?>
                            </table>
                            <form method="post" action="">
                                <div id="div_pagination">
                                    <br>
                                    <input type="hidden" name="row" value="<?php echo $row; ?>">
                                    <input type="hidden" name="allcount" value="<?php echo $allcount; ?>">
                                    <input type="submit" class="button" name="but_prev" value="Previous">
                                    <input type="submit" class="button" name="but_next" value="Next">
                                </div>
                            </form>
                        </div>
                        <?php include "html/footer.html"; ?>
                    </div>
                </div>
                <!--/span-->

                <!--/span-->

            </div>
        </div>
    </body>
</html>