<?php

date_default_timezone_set("Asia/Kathmandu");
$dbhost = "localhost";
$dbname = "kushadeviagronew";
$dbuser = "root";
$dbpass = "";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}
