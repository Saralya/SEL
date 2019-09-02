<?php
session_start();
session_unset();
session_destroy();
header("location:welcome_page.php?msg=Successfully Logged out");
?>