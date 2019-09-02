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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

</head>
<body><?php include 'html/navbar.php'; ?>
<div class="container">

    <?php
    $id=$_GET['id'];
    if($id=='101')
    {
     echo '<div class="alert alert-danger" align="center">
     <strong>Warning!!!</strong> Can not Delete Head Office!!
     </div>';

 }
 else
 {


    if(isset($_POST['keep']))
    {
        redirect("department_details.php?id=".$_GET['id']); 

    }
    if(isset($_POST['delete']))
    {
        $sql="DELETE FROM department WHERE dep_id=".$id;
        mysqli_query($db, $sql);
        echo '<div class="alert alert-success" align="center">
        Department Deleted Successfully!!
        </div>';

    }
    else
    {
        $sql="SELECT * FROM employee WHERE department_id=".$_GET['id'];
        $res=mysqli_query($db,$sql);
        if($res->num_rows!=0)
        {
            echo '<div class="alert alert-danger" align="center">
            <strong>Warning!!!</strong> This Department in not Empty!!
            </div>';
        }
        else
        {
            echo '<div class="alert alert-danger" align="center">
            <strong>Are you Sure you want to remove this Department???</strong><br><br>
            <form action="" method="post">
            <input class="btn btn-info btn-sm" type="submit" value="Yes" name="delete">
            <input class="btn btn-info btn-sm" type="submit" value="No" name="keep">
            </form>
            </div>';
        }
    }
}
?>


</div>
</body>



</html>