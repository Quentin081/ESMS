<?php
include('connect.php');
session_start();

$teacher_id = $_SESSION['user_id'];

$sql = "SELECT s.id, s.fName, s.lName
        FROM users s
        JOIN teachers_students ts ON ts.student_id = s.id
        WHERE ts.teacher_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$students = $stmt->get_result();

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitAttendance'])) {
    $date = date('Y-m-d');
    $attendance_data = $_POST['attendance'];

    foreach ($attendance_data as $student_id => $status) {
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Tracking</title>
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
            <div class="navbar__btn"><a href="logout.php" class="button">Logout</a></div>
        </div>
    </nav>
</header><br><br><br><br><br><br>

<div class="bodyContent">
    <h1 style="text-align: center;">Attendance Tracking</h1><br>

    <?php if ($success_message): ?>
        <div class="success-message" style="text-align: center;">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <form action="attendence.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Status</th>
                    <th>View Student's Attendance</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $students->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fName']) . " " . htmlspecialchars($row['lName']); ?></td>
                        <td>
                            <select name="attendance[<?php echo $row['id']; ?>]" required>
                                <option value="Present">Present</option>
                                <option value="Absent">Absent</option>
                            </select>
                        </td>
                        <td class = "attendanceLinks" ><a href="viewStudentAttendance.php?student_id=<?php echo $row['id']; ?>">View Attendance</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <br>
        <div class="addTeacher">
            <input type="submit" name="submitAttendance" value="Submit Attendance">
        </div>
    </form>
</div>
</body>
</html>
