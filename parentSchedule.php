<?php
include('connect.php');
session_start();

$parent_id = $_SESSION['user_id'];
$selected_child_id = isset($_POST['student_id']) ? $_POST['student_id'] : null;

$children_sql = "
    SELECT u.id AS student_id, u.fName, u.lName
    FROM parents_students ps
    JOIN users u ON ps.student_id = u.id
    WHERE ps.parent_id = ?";
$children_stmt = $conn->prepare($children_sql);
$children_stmt->bind_param("i", $parent_id);
$children_stmt->execute();
$children_result = $children_stmt->get_result();

$children = [];
while ($row = $children_result->fetch_assoc()) {
    $children[] = $row;
}
$children_stmt->close();

$schedule = [];
$student_name = "";

if ($selected_child_id) {
    $stmt = $conn->prepare("SELECT fName, lName FROM users WHERE id = ?");
    $stmt->bind_param("i", $selected_child_id);
    $stmt->execute();
    $stmt->bind_result($fName, $lName);
    $stmt->fetch();
    $student_name = "$fName $lName";
    $stmt->close();

    $schedule_sql = "
        SELECT s.day, c.course_name, s.start_time, s.end_time, 
               t.fName AS teacher_first_name, t.lName AS teacher_last_name
        FROM schedule s
        JOIN course c ON s.course_id = c.course_id
        JOIN users t ON s.teacher_id = t.id
        WHERE s.user_id = ? AND t.userType = 'teacher'
        ORDER BY s.day, s.start_time";
    $stmt = $conn->prepare($schedule_sql);
    $stmt->bind_param("i", $selected_child_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $schedule[$row['day']][] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Child's Schedule</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-container { text-align: center; margin: 30px; }
        .day-card {
            border: 1px solid #ccc;
            margin: 15px auto;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 700px;
        }
        .day-header { font-size: 1.5em; font-weight: bold; margin-bottom: 10px; }
        .class-info { margin-bottom: 10px; }
        .course-name { font-size: 1.2em; font-weight: bold; }
        .time { font-size: 1em; color: #555; }
    </style>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="parentHome.php" id="navbar-logo">ESMS</a>
            <ul class="navbar__menu">
            <li class="navbar__item">
                <a href="parentGrades.php" class="navbar__links">Grades</a>
            </li>
            <li class="navbar__item">
                <a href="parentSchedule.php" class="navbar__links">Schedule</a>
            </li>
            <li class="navbar__item">
                <a href="parentAttendance.php" class="navbar__links">Attendance</a>
            </li>
            </ul>
            <div class="navbar__btn">
                    <a href="logout.php" class="button">Logout</a>
            </div>
        </div>
    </nav>
</header><br><br><br><br><br>

<div class="bodyContent">
<div class="form-container">
    <form method="POST">
        <label for="student_id">Select a child:</label>
        <select name="student_id" id="student_id" required>
            <option value="">-- Choose a student --</option>
            <?php foreach ($children as $child): ?>
                <option value="<?= $child['student_id'] ?>" <?= ($selected_child_id == $child['student_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($child['fName'] . ' ' . $child['lName']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">View Schedule</button>
    </form>
</div>

<?php if ($selected_child_id): ?>
    <h2 style="text-align:center;">Schedule for <?= htmlspecialchars($student_name) ?></h2>
    <div class="schedule-container">
        <?php if (!empty($schedule)): ?>
            <?php foreach ($schedule as $day => $classes): ?>
                <div class="day-card">
                    <div class="day-header"><?= htmlspecialchars(ucfirst($day)) ?></div>
                    <?php foreach ($classes as $class): ?>
                        <div class="class-info">
                            <div class="course-name"><?= htmlspecialchars($class['course_name']) ?></div>
                            <div class="teacher-name">Teacher: <?= htmlspecialchars($class['teacher_first_name'] . ' ' . $class['teacher_last_name']) ?></div>
                            <div class="time"><?= date('g:i A', strtotime($class['start_time'])) . ' - ' . date('g:i A', strtotime($class['end_time'])) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center;">No schedule available for this student.</p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
</body>
</html>
