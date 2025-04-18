<?php

// Database & login credentials
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbDatabase = "yamiraku";

$db = mysqli_connect($dbHost, $dbUsername, $dbPassword) or die("<br><center><font face='arial'>Unable to connect to MYSQL Server.<br>" . mysqli_error($db) . "</font></center>");

mysqli_select_db($db, $dbDatabase) or die("<br><center><font face='arial'>Unable to connect to database.<br>" . mysqli_error($db) . "</font></center>");


?>





