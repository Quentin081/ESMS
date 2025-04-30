<?php

session_start();

include ('connect.php');

if($_SERVER["REQUEST_METHOD"]=='POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    $result = mysqli_query($conn,$sql);

    $row = mysqli_fetch_array($result);

    if($row["userType"]== "admin") {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['first_name'] = $row['fName'];
        $_SESSION['last_name'] = $row['lName'];
        header("Location: adminHome.php");
        exit();
    }
    elseif($row["userType"]== "student") {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['first_name'] = $row['fName'];
        $_SESSION['last_name'] = $row['lName'];
        header("Location: studentHome.php");
        exit();
    }
    elseif($row["userType"]== "parent") {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['first_name'] = $row['fName'];
        $_SESSION['last_name'] = $row['lName'];
        header("Location: parentHome.php");
        exit();
    }
    elseif($row["userType"]== "teacher") {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['first_name'] = $row['fName'];
        $_SESSION['last_name'] = $row['lName'];
        header("Location: teacherHome.php");
        exit();
    }
    else{
        $message = "Invalid Username or Password. Please Try again.";
        $_SESSION['loginMessage'] = $message;
        header("Location: loginPage.php");
        exit();
    }
}

?>