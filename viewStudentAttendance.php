<?php
include('connect.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$teacher_id = $_SESSION['user_id'];

$student_id = $_GET['student_id'];

$sql = "SELECT a.attendance_date, a.status
        FROM attendance a
        WHERE a.student_id = ?
        ORDER BY a.attendance_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$sql_name = "SELECT fName, lName FROM users WHERE id = ?";
$stmt_name = $conn->prepare($sql_name);
$stmt_name->bind_param("i", $student_id);
$stmt_name->execute();
$name_result = $stmt_name->get_result();
$student = $name_result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance for <?php echo htmlspecialchars($student['fName']) . " " . htmlspecialchars($student['lName']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <nav class="navbar" role="navigation" aria-label="Main Navigation">
        <div class="navbar__container">
            <a href="teacherHome.php" id="navbar-logo">ESMS</a>
            <ul class="navbar__menu">
            <li class="navbar__item">
                        <a href="viewClassList.php" class="navbar__links">View Class List</a>
                    </li>
                    <li class="navbar__item">
                        <a href="teacherHomework.php" class="navbar__links">Homework</a>
                    </li>
                    <li class="navbar__item">
                        <a href="schedule.php" class="navbar__links">Schedule</a>
                    </li>
                    <li class="navbar__item">
                        <a href="teacherGrades.php" class="navbar__links">Update Grades</a>
                    </li>
                    <li class="navbar__item">
                        <a href="attendence.php" class="navbar__links">Attendence</a>
                    </li>
            </ul>
            <div class="navbar__btn">
                <a href="logout.php" class="button">Logout</a>
            </div>
        </div>
    </nav>
</header><br><br><br><br><br><br>

<div class="bodyContent">
    <h1 style="text-align: center;">Attendance for <?php echo htmlspecialchars($student['fName']) . " " . htmlspecialchars($student['lName']); ?></h1><br>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['attendance_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No attendance records found for this student.</p>
    <?php endif; ?>
    
    <br>
    
    <div class="addTeacher">
        <a href="attendence.php" class="go-back-btn">
            <button>Go Back to Attendance</button>
        </a>
    </div>
</div>
</body>
</html>
