<?php
// Include config file
require_once 'connect.php';

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $username = trim($_POST["username"]);

        $sql ="SELECT * FROM `employee` WHERE ID='$username'";
        //$sql = "SELECT Username FROM login WHERE Username ='$username'";

        $res=mysqli_query($db, $sql);
        // Attempt to execute the prepared statement

        if($res->num_rows == 1){

            $query="SELECT * FROM login WHERE Username='$username'";

            $res_2=mysqli_query($db,$query);
            if($res_2->num_rows == 1)
            {
                $username_err = "You already have an account.";
            }

        } else{
                $username_err = "Your ID doesn't exist in database.";
        }

    }


    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 3){
        $password_err = "Password must have atleast 3 characters.";
    } else{
        $password = trim($_POST['password']);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO login (Username, Password) VALUES ('$username','$password')";

        // Attempt to execute the prepared statement
        if(mysqli_query($db,$sql)){
            // Redirect to login page
            header("location: admin.php");
        } else{
            echo "Something went wrong. Please try again later.";
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
        <title>Sign Up</title>
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
                        <h2>Sign Up</h2>
                        <p>Please fill this form to create an account.</p>
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>    
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                            <span class="help-block"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">

                        </div>
                        <p>Already have an account? <a href="admin.php">Login here</a>.</p>
                    </form>
                </div>
            </div>
        </div>    
    </body>
</html>