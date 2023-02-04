<?php

$start_time = microtime(TRUE);

require_once('config.php');

session_start();

$dblink = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if (mysqli_connect_errno())
{
  die("Failed to connect to MySQL: " . mysqli_connect_error());
}

?>