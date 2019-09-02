<?php 
session_start();
if(!$_SESSION['name']){
    header("location:admin.php");
}
?>
<?php include 'connect.php';
if(isset($_GET['circular_id'])){
    $circular_id = $_GET['circular_id'];
}
?>

<html>
    <head>
        <title>Circular Form</title>
        <?php include "html/bootstrap.html" ?>
        <meta charset="utf-8">
       
    </head>
    <body><?php include "html/navbar.php" ?>
        <div class="row row-offcanvas row-offcanvas-left">

            <div class="container">
                            
                            <br><h3 style="color:#00BFFF">View CV</h3><br>  
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                            <?php
                                $sql = "SELECT `cv_id` FROM `cv` WHERE `circular_id` = '$circular_id'";
                                $records = mysqli_query($db, $sql);
                                $projects = array();
                                while ($project =  mysqli_fetch_array($records))
                                    {
                                    $projects[] = $project;
                                    }
        
                                foreach ($projects as $project)
                                {
                                    ?>
                            
                            <table class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">CV name</th>
                                      <th scope="col">Download</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <th scope="row"></th>
                                      <td><?php echo $project['cv_id'] ?></td>
                                      <td><form method="get" action="<?php echo $project['cv_id']; ?>"><button type="submit">Download!</button></form></td>
                                    </tr>
                                  </tbody>
                                </table>
                             <?php
                                }
                            ?>


                        </div>
                        </div>
                </div>
                
                </div>
                </div>


            </body>
        </html>