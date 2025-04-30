<?php
include('connect.php');
session_start();

$student_id = $_SESSION['user_id'];

$sql_schedule = "
    SELECT s.day, c.course_name, s.start_time, s.end_time, 
           t.fName AS teacher_first_name, t.lName AS teacher_last_name
    FROM schedule s
    JOIN course c ON s.course_id = c.course_id
    JOIN users t ON s.teacher_id = t.id
    JOIN users u ON s.user_id = u.id
    WHERE u.id = ? AND t.userType = 'teacher'
    ORDER BY s.day, s.start_time";
$stmt_schedule = $conn->prepare($sql_schedule);
$stmt_schedule->bind_param("i", $student_id);
$stmt_schedule->execute();
$schedule_result = $stmt_schedule->get_result();

if ($schedule_result->num_rows > 0) {
    $days_schedule = [];
    while ($row = $schedule_result->fetch_assoc()) {
        $days_schedule[$row['day']][] = $row;
    }
} else {
    echo "No schedule data found for this student.";
}

$stmt_schedule->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Schedule</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .day-card {
            border: 1px solid #ccc;
            margin: 15px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .day-header {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .class-info {
            margin-bottom: 10px;
        }
        .course-name {
            font-size: 1.2em;
            font-weight: bold;
        }
        .time {
            font-size: 1em;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar" role="navigation" aria-label="Main Navigation">
            <div class="navbar__container">
                <a href="studentHome.php" id="navbar-logo">ESMS</a>
                <ul class="navbar__menu">
                    <li class="navbar__item"><a href="studentGrades.php" class="navbar__links">Grades</a></li>
                    <li class="navbar__item"><a href="studentHomework.php" class="navbar__links">Homework</a></li>
                    <li class="navbar__item"><a href="schedule.php" class="navbar__links">Schedule</a></li>
                </ul>

                <div class="navbar__btn">
                    <a href="logout.php" class="button">Logout</a>
                </div>
            </div>
        </nav>
    </header><br><br><br><br><br>

    <h1 style="text-align: center;">Your Schedule</h1><br>
    <div class="schedule-container">
        <?php foreach ($days_schedule as $date => $classes): ?>
        <div class="day-card">
            <div class="day-header"><?php echo date('l', strtotime($date));?></div>
            <?php foreach ($classes as $class): ?>
                <div class="class-info">
                    <div class="course-name"><?php echo htmlspecialchars($class['course_name']); ?></div>
                    <div class="teacher-name">Teacher: <?php echo htmlspecialchars($class['teacher_first_name']) . ' ' . htmlspecialchars($class['teacher_last_name']); ?></div>
                    <div class="time"><?php echo date('g:i A', strtotime($class['start_time'])) . ' - ' . date('g:i A', strtotime($class['end_time'])); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    </div>
</body>
</html>
