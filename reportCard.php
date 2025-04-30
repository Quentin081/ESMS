<?php
include('connect.php');
session_start();

if (!isset($_GET['student_id'])) {
    echo "Student not specified.";
    exit();
}

$student_id = intval($_GET['student_id']);

$stmt_student = $conn->prepare("SELECT fName, lName FROM users WHERE id = ?");
$stmt_student->bind_param("i", $student_id);
$stmt_student->execute();
$student_result = $stmt_student->get_result()->fetch_assoc();

$stmt_grades = $conn->prepare("
    SELECT c.course_name, g.grade
    FROM grades g
    JOIN course c ON c.course_id = g.course_id
    WHERE g.id = ?");
$stmt_grades->bind_param("i", $student_id);
$stmt_grades->execute();
$grades_result = $stmt_grades->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .report-card {
            width: 50%;
            margin: 50px auto;
            border: 1px solid #aaa;
            padding: 20px;
            border-radius: 10px;
        }
        h2 {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 10px;
        }
    </style>
</head>
<body>
<div class="report-card">
    <h2>Report Card</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($student_result['fName'] . ' ' . $student_result['lName']); ?></p>
    <table>
        <tr><th>Course</th><th>Grade</th></tr>
        <?php while ($row = $grades_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                <td><?php echo htmlspecialchars($row['grade']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
