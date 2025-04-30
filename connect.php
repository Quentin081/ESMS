<?php 

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "esms";

$conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>