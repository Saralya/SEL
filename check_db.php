<?php include 'connect.php'; ?>
<?php  
$sql = "CREATE TABLE IF NOT EXISTS `department` (
  `dep_id` int(10) NOT NULL AUTO_INCREMENT,
  `dep_name` varchar(30) NOT NULL,
  `head_id` varchar(20) NOT NULL DEFAULT 'N/A',
  `reporting_mail` varchar(255) NOT NULL DEFAULT 'N/A',
  PRIMARY KEY (`dep_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;";
mysqli_query($db, $sql);

 $sql = "SELECT * FROM department WHERE dep_name='Head Office'";
	 $result = $db -> query($sql);
     if(($result -> num_rows)==0){
         $sql = "INSERT INTO department(dep_name)"
                 . "VALUES('Head Office')";
         $db -> query($sql);
     }

$sql = "CREATE TABLE IF NOT EXISTS login (
             ID INT AUTO_INCREMENT PRIMARY KEY, 
             Username varchar(20) NOT NULL,
             Password VARCHAR(50) DEFAULT 'password',
             Role VARCHAR(50) DEFAULT 'user',
             `head` VARCHAR(20) NOT NULL DEFAULT 'No',
             `reporter` VARCHAR(20) NOT NULL DEFAULT 'No'
             )  ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

$db -> query($sql);
     
 $sql = "SELECT * FROM login WHERE Role='admin'";
	 $result = $db -> query($sql);
     if(($result -> num_rows)==0){
         $sql = "INSERT INTO login(Username, Role, Password)"
                 . "VALUES('10001', 'admin','salim6251@')";
         $db -> query($sql);
     }
     

$sql = "CREATE TABLE IF NOT EXISTS `employee` (
  `ID` varchar(20) NOT NULL,
  `image` longblob,
  `First Name` varchar(30) NOT NULL,
  `Last Name` varchar(30) NOT NULL,
  `Date of Birth` date NOT NULL, 
  `Email` varchar(255) NOT NULL,
  `Gender` varchar(10) NOT NULL DEFAULT 'N/A',
  `Blood Group` varchar(20) NOT NULL,
  `height` varchar(20) NOT NULL,
  `Cell Phone` varchar(20) NOT NULL,
  `father` varchar(30) NOT NULL,
  `mother` varchar(30) NOT NULL,
  `spouse` varchar(30) DEFAULT 'N/A',
  `children` int(10) DEFAULT 0,
  `NID` varchar(30) NOT NULL,
  `tax_id` varchar(30) NOT NULL,
  `passport` varchar(30) NOT NULL,
  `driving_license` varchar(30) NOT NULL,
  
  `department_id` int(10) NOT NULL,
  `medical_leave` int(10) NOT NULL,
  `sold_leave` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10001;";
mysqli_query($db, $sql);


$sql = "CREATE TABLE IF NOT EXISTS `emergency_contact` (
  `emp_id` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `relation` varchar(30) NOT NULL,
  `cell` int(30) NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `address` (
  `emp_id` varchar(20) NOT NULL,
  `per_village` varchar(30) NOT NULL,
  `per_post_office` varchar(30) NOT NULL,
  `per_thana` varchar(30) NOT NULL,
  `per_district` varchar(30) NOT NULL,
  `per_division` varchar(30) NOT NULL,
  `pre_village` varchar(30) NOT NULL,
  `pre_post_office` varchar(30) NOT NULL,
  `pre_thana` varchar(30) NOT NULL,
  `pre_district` varchar(30) NOT NULL,
  `pre_division` varchar(30) NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `job_experience` (
  `serial` int(20) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(20) NOT NULL,
  `previous_employer` varchar(30) NOT NULL,
  `designation` varchar(30) NOT NULL,
  `job_field` varchar(30) NOT NULL,
  `job_experience` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `refference` varchar(30) NOT NULL,
  PRIMARY KEY(`serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `disciplinary` (
  `serial` int(20) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `remarks` varchar(50) NOT NULL,
  PRIMARY KEY (`serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `complain` (
  `serial` int(20) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `remarks` varchar(50) NOT NULL,
   PRIMARY KEY (`serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);



$sql = "CREATE TABLE IF NOT EXISTS `leaves` (
  `LeaveID` int(11) NOT NULL AUTO_INCREMENT,
  `entrier_id` varchar(20) NOT NULL,
  `approver_id` varchar(20) NOT NULL,
  `EmployeeID` varchar(20) NOT NULL,
  `From Date` date NOT NULL,
  `To Date` date NOT NULL,
  `days` int(11) NOT NULL DEFAULT '0',
  `Type` varchar(20) NOT NULL,
  `Reason` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `apply_date` date NOT NULL,
  `approval_date` date NOT NULL,
  `joined` varchar(10) DEFAULT 'No'
  PRIMARY KEY (`LeaveID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
mysqli_query($db, $sql);
  
$sql = "CREATE TABLE IF NOT EXISTS `leave_types` (
  `emp_id` varchar(20) NOT NULL,
  `casual` int(11) NOT NULL,
  `sick` int(11) NOT NULL,
  `annual` int(11) NOT NULL,
  `maternity` int(11) NOT NULL,
  `paternity` int(11) NOT NULL,
  `wpl` int(11) NOT NULL,
  `official` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);


$sql = "CREATE TABLE IF NOT EXISTS `training` (
    `serial` int(20) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(20) NOT NULL,
  `title` varchar(30) NOT NULL,
  `institution` varchar(30) NOT NULL,
  `place` varchar(30) NOT NULL,
  `days` int(5) NOT NULL,
  `year` varchar(10) NOT NULL,
  PRIMARY KEY (`serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);


$sql = "CREATE TABLE IF NOT EXISTS `qualification` (
  `serial` int(10) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(20) NOT NULL,
  `field` varchar(30) NOT NULL,
  `institution` varchar(30) NOT NULL,
  `year` varchar(30) NOT NULL,
  `mark` varchar(30) NOT NULL,
  `location` varchar(100) NOT NULL,
  `degree` varchar(20) NOT NULL,
  PRIMARY KEY (`serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `history_salary` (
`serial` int(20) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(20) NOT NULL,
  `entrier_id` varchar(20) NOT NULL,
  `approver_id` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `amount` int(10) NOT NULL,
  PRIMARY KEY (`serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `history_designation` (
  `serial` int(20) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(20) NOT NULL,
  `entrier_id` varchar(20) NOT NULL,
  `approver_id` varchar(20) NOT NULL,
  `from` varchar(30) NOT NULL,
  `to` varchar(30) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);


$sql = "CREATE TABLE IF NOT EXISTS `history_department` (
  `serial` int(20) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(20) NOT NULL,
  `entrier_id` varchar(20) NOT NULL,
  `approver_id` varchar(20) NOT NULL,
  `from` varchar(30) NOT NULL,
  `to` varchar(30) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);


$sql = "CREATE TABLE IF NOT EXISTS `awards` (
  `serial` int(20) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `remarks` varchar(50) NOT NULL,
   PRIMARY KEY (`serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);
     
$sql = "CREATE TABLE IF NOT EXISTS `notification` (
  `serial` int(20) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(20) NOT NULL,
  `approver_id` varchar(20) NOT NULL,
  `type` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`serial`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `job_status` (
  `emp_id` varchar(20) NOT NULL,
  `prev_designation` varchar(30) NOT NULL,
  `curr_designation` varchar(30) NOT NULL,
  `duration_designation` varchar(30) NOT NULL,
  `duration_department` varchar(30) NOT NULL,
  `promo_date` date NOT NULL,
  `curr_department` varchar(30) NOT NULL,
  `prev_department` varchar(30) NOT NULL,
  `transfer_date` date NOT NULL,
  `joining_date` date NOT NULL,
  `joining_gross` int(20) NOT NULL,
  `current_gross` int(20) NOT NULL,
  `last_inc` int(20) NOT NULL DEFAULT 0,
  `last_inc_date` date NOT NULL,
  `present_working_station` varchar(30) NOT NULL,
  `employee_status` varchar(30) NOT NULL,
  `probation_period` varchar(30) NOT NULL,
  `confirmation_status` varchar(30) NOT NULL,
  `confirmation_date` date NOT NULL,
  `employment_type` varchar(30) NOT NULL,
  `employee_separation` varchar(30) NOT NULL,
  `employee_separation_date` date NOT NULL,
  `pf_deduction` varchar(30) NOT NULL,
  `gratuity` varchar(30) NOT NULL,
  `hos_schema` varchar(30) NOT NULL,
  `hos_range` varchar(30) NOT NULL,
  `salary_account` varchar(30) NOT NULL,
  `bank` varchar(30) NOT NULL,
  `corporate_sim` varchar(30) NOT NULL,
  `ot_status` varchar(30) NOT NULL,
  `income_tax_deduction` varchar(30) NOT NULL,
  `reffered_by` int(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `designation` varchar(30) NOT NULL,
  PRIMARY KEY(`emp_id`) 
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
mysqli_query($db, $sql);

$sql = "CREATE TABLE IF NOT EXISTS `sub_department` (
  `sub_dep_id` int(10) NOT NULL AUTO_INCREMENT,
  `sub_dep_name` varchar(30) NOT NULL,
  `sub_head_id` varchar(20) NOT NULL,
  `sub_reporting_mail` varchar(255) NOT NULL DEFAULT 'N/A',
  PRIMARY KEY (`sub_dep_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;";
mysqli_query($db, $sql);

$sql="CREATE TABLE IF NOT EXISTS `history_employment` (
  `serial` int(10) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(40) NOT NULL,
  `employment_type` varchar(20) NOT NULL,
  `entrier` varchar(40) NOT NULL,
  `approver` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `entry_date` date NOT NULL,
  `remarks` text NOT NULL,
  PRIMARY KEY (`serial`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";


     ?>


