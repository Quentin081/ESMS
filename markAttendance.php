<?php
include('connect.php');
session_start();

if (isset($_POST['markAttendance'])) {
    $date = date('Y-m-d');
    $attendance = $_POST['attendance'];

    foreach ($attendance as $student_id => $status) {
        $stmt = $conn->prepare("INSERT INTO attendance (student_id, attendance_date, status) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $student_id, $date, $status);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    $_SESSION['success_message'] = "Attendance successfully recorded for the day!";

    header("Location: attendence.php");
    exit();
}
?>
