<?php

require_once 'connect.php';

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT * FROM login WHERE Username ='$username'";

        if($res = mysqli_query($db,$sql)){


            $result=mysqli_fetch_array($res);
            $data_pass=$result['Password'];
            $role = $result['Role'];
            $head= $result['head'];
            $reporter= $result['reporter'];
            // Store result
            $row=$res -> num_rows;


            // Check if username exists, if yes then verify password
            if($row==1){                    


                if($password==$data_pass){
                    /* Password is correct, so start a new session and
                            save the username to the session */

                    session_start();
                    $_SESSION['name']=$role;
                    $_SESSION['id']=$username;
                    $_SESSION['head']=$head;
                    $_SESSION['reporter']=$reporter;
                    //echo $_SESSION['name'];
                    header("location: index.php");
                } else{
                    // Display an error message if password is not valid
                    $password_err = 'The password you entered was not valid.';
                }

            } else{
                // Display an error message if username doesn't exist
                $username_err = 'No account found with that username.';
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }


    // Close connection
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{ font: 14px sans-serif; }
            .wrapper{padding-right: 100px;padding-top: 100px}
            form {border: 3px solid #f1f1f1;padding: 30px;padding-top: }
        </style>
    </head>
    <body>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4" style="padding-top:60px;">
                <div class="wrapped">

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="imgcontainer">
                            <center>  <img src="img_519216.png" width="200" height="200" alt="Avatar" class="avatar"></center>
                        </div>
                        <h2>Login</h2>
                        <p>Please fill in your credentials to login.</p>
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>    
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Login">
                        </div>
                        <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
                    </form>
                </div> </div> </div>  </div>
    </body>
</html>