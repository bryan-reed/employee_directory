<?php

//Set definitions for db settings (using mysql)
define('DB_HOST', ''); //DB host
define('DB_NAME', ''); //DB name
define('DB_USER', ''); //DB username
define('DB_PASS', ''); //DB password

//Connect to database
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}
//Include all of our functions and our employee class
require_once 'functions.php';
require_once 'classes/Employee.php';