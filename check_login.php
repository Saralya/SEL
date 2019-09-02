<?php
   session_start();
    if(!$_SESSION['name']){
        header("location:admin.php");
    } 
?>
<?php include 'connect.php'; ?>





<?php
    if(isset($_POST["submit"])){
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        $remember = $_POST["remember"];
        $sql = "SELECT * FROM login WHERE Username='$username' and Password='$password';";
        $result = mysqli_query($db, $sql);
        $user_role = mysqli_fetch_array($result);
        $role = $user_role['Role'];
        $head= $user_role['head'];
        $reporter= $user_role['reporter'];
        $count = $result -> num_rows;
        if($count == 1){
            $_SESSION['name']=$role;
            $_SESSION['id']=$username;
            $_SESSION['head']=$head;
            $_SESSION['reporter']=$reporter;
            if($remember){
                setcookie("rem_user",$username,time()+100000);
                setcookie("rem_pass",$password,time()+100000);
            } else {
                setcookie("rem_user","");
                setcookie("rem_pass", "");
            }
            
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
           redirect("index.php");
        } else {
            echo "<h4 style='color:red'>Wrong Password!</h4><br>";
            echo "<a href='index.php'>Try again?</a>";
        }
    }
?>