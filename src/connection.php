<?php
session_start();
require_once (dirname(__FILE__)."/config.php");
require_once (dirname(__FILE__)."/user.php");

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbBaseName);

if ($conn->connect_errno)
{
    die("DB connection not initialized properly".$conn->connect_error);
}

User::SetConnection($conn);

?>