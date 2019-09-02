<?php 
session_start();
if(!$_SESSION['name']){
    header("location:admin.php");
}
?>
<?php include 'connect.php'; ?>

<?php
if(isset($_POST['submit'])){
    $file = $_FILES['file']['name'];
    $target_dir= "files/";
    $target_file= $target_dir.$file;
    move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
    $file = $target_dir.$file;
    
    $query = "INSERT INTO `circular`(`circular_id`) VALUES ('$file')";
    mysqli_query($db, $query);
    
;
}

if(isset($_POST['submit1'])){
    $file = $_FILES['files']['name'];
    $target_dir= "cv/";
    $target_file= $target_dir.$file;
    move_uploaded_file($_FILES['files']['tmp_name'], $target_file);
    $file = $target_dir.$file;
    
    $query = "INSERT INTO `cv`(`cv_id`) VALUES ('$file')";
    $circular_id = $_GET['circular_id'];
    
    $query = "INSERT INTO `cv`(`cv_id`, `circular_id`) VALUES ('$file', '$circular_id')";
    mysqli_query($db, $query);
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

                <?php 
                        if($_SESSION['name']=='admin')
                        { ?>
                            
                            <br><h3 style="color:#00BFFF">Create New Job Circular</h3><br>  
                <div class="row">
                    <form role="form" action="circular_form.php" method="post" enctype="multipart/form-data">
                    <div class="panel panel-primary">
                        <div class="panel-heading"></div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="btn btn-default btn-file">
                                    <input type="file" name="file" id="fileToUpload">
                                </label>
                            </div>
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-md"><br><br>
                        </div>
                        </div>
                    </form>
                </div>
                <?php
                        }
                        
                        ?>
                
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-heading">View Job Circulars</div>
                        <div class="panel-body">
                            <?php
                                $sql = "SELECT `circular_id` FROM `circular`";
                                $result = mysqli_query($db, $sql);
                                $records = mysqli_query($db, $sql);
                                $projects = array();
                                while ($project =  mysqli_fetch_array($records))
                                    {
                                    $projects[] = $project;
                                    }
        
                                foreach ($projects as $project)
                                {
                                    ?>
                            
                            <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col"></th>
                                   <th scope="col">Download</th>
                                    <?php if($_SESSION['name']=='user') echo "<th scope='col'>Upload CV</th>"; ?>
                                    <?php if($_SESSION['name']=='data entry') echo "<th scope='col'>View CV</th>"; ?>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th scope="row">Circular</th>
                                  <td><img width = "42" height = "42" src="<?php echo $project['circular_id']; ?>"></td>
                                  <td><form method="get" action="<?php echo $project['circular_id']; ?>"><button type="submit">Download!</button></form></td>
                                  <?php if($_SESSION['name']=='user') echo '<td>  <form role="form" action="circular_form.php?circular_id='.$project["circular_id"].'" method="post" enctype="multipart/form-data"> <div class="form-group">
                                <label class="btn btn-default btn-file">
                                    <input type="file" name="files" id="fileToUpload">
                                </label>
                            </div>
                            <input type="submit" name="submit1" value="Submit" class="btn btn-primary btn-md"><br><br></form></td>'; ?>
                                    
                                    <?php if($_SESSION['name']=='data entry') echo '<td> <a href="view_cv.php?circular_id='.$project['circular_id'].'">View CV</a></td>'; ?>
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