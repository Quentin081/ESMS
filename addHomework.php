<?php
include('connect.php');
session_start();

$user_id = $_SESSION['user_id'];

if (isset($_POST['addHomework'])) {
    $hw_name = $_POST['hw_name'];
    $assigned_date = $_POST['assigned_date'];
    $due_date = $_POST['due_date'];
    $course_id = $_POST['course_id'];

    $stmt = $conn->prepare("INSERT INTO homework (hw_name, assigned_date, due_date, course_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $hw_name, $assigned_date, $due_date, $course_id);

    if ($stmt->execute()) {
        $homework_id = $conn->insert_id;

        $students_stmt = $conn->prepare("SELECT student_id FROM teachers_students WHERE teacher_id = ?");
        $students_stmt->bind_param("i", $user_id);
        $students_stmt->execute();
        $students_result = $students_stmt->get_result();

        $assign_stmt = $conn->prepare("INSERT INTO student_homework (student_id, homework_id) VALUES (?, ?)");

        while ($student = $students_result->fetch_assoc()) {
            $assign_stmt->bind_param("ii", $student['student_id'], $homework_id);
            $assign_stmt->execute();
        }

        $_SESSION['success_message'] = "Homework added and assigned to students.";
    } else {
        $_SESSION['success_message'] = "Failed to add homework.";
    }

    $stmt->close();
    $students_stmt->close();
    $assign_stmt->close();
    $conn->close();

    header("Location: teacherHomework.php");
    exit();
}
?>
