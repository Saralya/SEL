
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">SEL</a>
                </div>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Home</a></li>
                        <?php include 'make_head.php' ?>
                        <?php if($_SESSION['name']=='admin')
{
    echo '<li><a href="search.php">Search</a>';
} ?>
                        <?php if(!($_SESSION['name']=='admin'))
{
    echo '<li><a href="notification.php?id='.$_SESSION['id'].'"  >Notification</a>';
}
                        ?>
                        <?php 
                        if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry')
                        {
                            echo '<li><a href="employee_form.php">New Entry</a></li>';
                            
                        }
                        
                        ?>
                        <?php 
                        if($_SESSION['name']=='admin')
                        {
                            echo '<li><a href="circular_form.php"  >Create Job Circular</a></li>';
                            
                        }
                        ?>
                        <?php 
                        if($_SESSION['name']=='user' || $_SESSION['name']=='data entry')
                        {
                            echo '<li><a href="circular_form.php"  >View Job Circular</a></li>';
                            
                        }
                        
                        ?>
                        
                        <?php 
                        if($_SESSION['name']=='admin')
                        {

                            //echo   '<li><a href="department_list.php"  >Department List</a></li>';
                            //echo   '<li><a href="designations.php"  >Designations</a></li>';
                        }
                        ?>
                        <?php                   
                        if(($_SESSION['reporter']=='Yes'||$_SESSION['head']=='Yes') && $_SESSION['name'] != 'admin')
                        {

                            //echo '<li><a href="department_list_2.php"  >Department List</a></li>'; 
                        }
                        ?>

                        <?php if($_SESSION['name']=='admin'||$_SESSION['head']=='Yes'||$_SESSION['reporter']=='Yes')
{
    //echo '<li><a href="request_page.php">Leave Requests</a></li>'; 
}
                        ?>

                        <?php if($_SESSION['name']=='admin'){



}
                        ?>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li> -->
                        <?php if($_SESSION['id']=='10001')
{  
    echo '<li><a href="jobdetails_admin.php?id='.$_SESSION['id'].'"><span class="glyphicon glyphicon-user" title="Profile"></span> Profile</a></li>';
}

                        else
                        {
                        ?>

                        <li><a href="jobdetails.php?id=<?php echo $_SESSION['id'];?>"><span class="glyphicon glyphicon-user" title="Profile"></span> Profile</a></li>
                        <?php } ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Settings
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">

                                <?php
                                if($_SESSION['name']=='admin')
                                {
                                    echo '<li><a href="role_selection.php">Role Selection</a></li>';
                                    echo '<li><a href="fired.php">Separated Employee</a></li>';
                                    echo '<li><a href="settings_des.php">Set Designation</a></li>';
                                    echo '<li><a href="activity_log.php">Activity Log</a></li>';
                                    echo '<li><a href="leave_alloc.php">Leave Allocation</a></li>';
                                    echo '<li><a href="leave_info.php"  >Leave Information</a></li>';
                                    echo '<li><a href="add_department.php">Add Departments</a></li>';
                                    echo '<li><a href="temp_head.php">Temporary HR Admin</a></li>';
                                }
                                ?>
                                <li><a href="password_change.php">Change Password</a></li>
                            </ul>

                        </li>
                        <!-- <li><a href="password_change.php"><span class="glyphicon glyphicon-cog" title="Change Password"></span> Settings</a></li> -->
                        <li><a href="logout.php"><span class="glyphicon glyphicon-off" title="Logout"></span> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav> 
    </body>
</html>