<?php 
session_start();
if(!$_SESSION['name']){
    header("location:admin.php");
}
?>
<?php include 'connect.php';
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
                      <br><h3 style="color:#00BFFF">Call for Interview</h3><br>  
                <div class="row">
                    <div class="panel panel-primary">
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                        
                            
                        </div>
                    </div>
                </div>
                
                </div>
                </div>
            </body>
        </html>