<?php
include('connect.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$teacher_id = $_SESSION['user_id'];

$sql_students = "
    SELECT s.id, s.fName, s.lName 
    FROM users s
    JOIN teachers_students ts ON ts.student_id = s.id
    WHERE ts.teacher_id = ?";
$stmt_students = $conn->prepare($sql_students);
$stmt_students->bind_param("i", $teacher_id);
$stmt_students->execute();
$students_result = $stmt_students->get_result();

$sql_courses = "SELECT course_id, course_name FROM course WHERE teacher_id = ?";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bind_param("i", $teacher_id);
$stmt_courses->execute();
$courses_result = $stmt_courses->get_result();

$courses = [];
while ($row = $courses_result->fetch_assoc()) {
    $courses[$row['course_id']] = $row['course_name'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateGrades'])) {
    foreach ($_POST['grades'] as $student_id => $grades) {
        foreach ($grades as $course_id => $grade) {
            if (!empty($grade)) {
                $stmt_check = $conn->prepare("SELECT id FROM grades WHERE id = ? AND course_id = ?");
                $stmt_check->bind_param("ii", $student_id, $course_id);
                $stmt_check->execute();
                $stmt_check->store_result();

                if ($stmt_check->num_rows > 0) {
                    $stmt_update = $conn->prepare("UPDATE grades SET grade = ? WHERE id = ? AND course_id = ?");
                    $stmt_update->bind_param("sii", $grade, $student_id, $course_id);
                    $stmt_update->execute();
                    $stmt_update->close();
                } else {
                    $stmt_insert = $conn->prepare("INSERT INTO grades (id, course_id, grade) VALUES (?, ?, ?)");
                    $stmt_insert->bind_param("iis", $student_id, $course_id, $grade);
                    $stmt_insert->execute();
                    $stmt_insert->close();
                }
            }
        }
    }
    $stmt_check->close();

    $_SESSION['success_message'] = "Grades successfully updated!";

    header("Location: Teachergrades.php");
    exit();
}
?>
