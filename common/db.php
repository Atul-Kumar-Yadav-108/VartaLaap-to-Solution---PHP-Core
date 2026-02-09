<?php
$server = 'localhost';
$username = 'root';
$password = '';
$dbname = 'discuss';


$con = new mysqli($server, $username, $password, $dbname);
if ($con->connect_error) {
    die('Error in db connection' . $con->connect_error);
}

// echo "Connected with db";
