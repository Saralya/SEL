<?php //session_start(); ?>
<?php //if($_SESSION['name']=='chairman'); ?>
<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-divider"></li>
                    <li><a href="index.php" style="color: black">Home</a></li>
                                        <?php if($_SESSION['name']=='admin')
{
    echo '<li><a href="search.php" style="color: black">Search</a>';
} ?>
                    <?php if(!($_SESSION['name']=='admin'))
                    {
                    echo '<li><a href="notification.php?id='.$_SESSION['id'].'" style="color: black">Notification</a>';
                    }
                    ?>
                    <li class="nav-divider"></li>
                    <?php if($_SESSION['name']=='admin'||$_SESSION['name']=='data entry'||$_SESSION['name']=='head'||$_SESSION['reporter'])
{
                    echo '<li><a href="employee_form.php" style="color: black">New Entry</a></li>';
}
                    ?>
                    <?php if($_SESSION['name']=='admin')
                    echo '<li><a href="employee_list.php" style="color: black">Employee List</a></li>
                    <li class="nav-divider"></li>';
                    ?>
                    <li><a href="leave_form.php" style="color: black">Apply Leave</a></li>
                    
                    <?php if($_SESSION['name']=='admin')
{
                    echo '<li><a href="leave_info.php" style="color: black">Leave Information</a></li>
                    <li class="nav-divider"></li>
			        <li><a href="add_department.php" style="color: black">Add Departments</a></li>
			        <li><a href="department_list.php" style="color: black">Department List</a></li>
					<li class="nav-divider"></li>'; }
					?>

				    <?php if($_SESSION['name']=='admin'||$_SESSION['name']=='head'||$_SESSION['name']=='reporter')
				    {
					echo '<li><a href="request_page.php" style="color: black">Leave Requests</a></li>'; }
					?>
					
					<?php if($_SESSION['name']=='admin'){
					echo '<li><a href="role_selection.php" style="color: black">Role Selection</li>
					<li><a href="#" style="color: black"></li>';
					
}
                    ?>
                    <li class="nav-divider"></li>
                    <?php 
                    
					echo '<li><a href="jobdetails.php?id='.$_SESSION['id'].'" style="color: black">Profile</a>';
                    echo '</li><li class="nav-divider"></li>';
                    
                    ?>
                    
                    
                    <li><a href="password_change.php" style="color: black">Change Password</a></li>
                    </li><li class="nav-divider"></li>
					<li><a href="logout.php" style="color: black">Logout</a></li>
                </ul>
            </div>
            <!--/.well -->
</div>
<!--/span-->