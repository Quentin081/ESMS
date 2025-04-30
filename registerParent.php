<?php
session_start();
include('connect.php');

$fName = $conn->real_escape_string($_POST['fName']);
$lName = $conn->real_escape_string($_POST['lName']);
$email = $conn->real_escape_string($_POST['email']);
$password = $conn->real_escape_string($_POST['password']); 
$userType = $conn->real_escape_string($_POST['userType']);
$phone = $conn->real_escape_string($_POST['phone']);

$sql = "INSERT INTO users (fName, lName, email, password, userType, phone) 
        VALUES ('$fName', '$lName', '$email', '$password', '$userType', '$phone')";

if ($conn->query($sql) === TRUE) {
    header("Location: successfulAddParent.php");
} else {
    echo "Error: " . $conn->error;
}

?>
