<?php 
include('connect.php');
session_start();

$teacher_id = $_SESSION['user_id'];

$sql_schedule = "
    SELECT s.schedule_id, s.day, c.course_name, s.start_time, s.end_time, 
           u.fName AS teacher_first_name, u.lName AS teacher_last_name, c.course_id
    FROM schedule s
    JOIN course c ON s.course_id = c.course_id
    JOIN users u ON s.teacher_id = u.id
    WHERE u.id = ? AND u.userType = 'teacher'
    ORDER BY s.day, s.start_time";

$stmt_schedule = $conn->prepare($sql_schedule);
$stmt_schedule->bind_param("i", $teacher_id);
$stmt_schedule->execute();
$schedule_result = $stmt_schedule->get_result();

$days_schedule = [];
while ($row = $schedule_result->fetch_assoc()) {
    $days_schedule[$row['day']][] = $row;
}

$stmt_schedule->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_schedule'])) {
    $schedule_id = $_POST['schedule_id'];
    $new_day = $_POST['day'];
    $new_start_time = $_POST['start_time'];
    $new_end_time = $_POST['end_time'];
    $course_id = $_POST['course_id'];

    $update_sql = "UPDATE schedule SET day = ?, start_time = ?, end_time = ?, course_id = ? WHERE schedule_id = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("ssssi", $new_day, $new_start_time, $new_end_time, $course_id, $schedule_id);
    $stmt_update->execute();

    $_SESSION['success_message'] = "Schedule updated successfully!";
    header('Location: schedule.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Schedule</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <nav class="navbar" role="navigation" aria-label="Main Navigation">
        <div class="navbar__container">
            <a href="teacherHome.php" id="navbar-logo">ESMS</a>
            <ul class="navbar__menu">
                <li class="navbar__item"><a href="viewClassList.php" class="navbar__links">View Class List</a></li>
                <li class="navbar__item"><a href="teacherHomework.php" class="navbar__links">Homework</a></li>
                <li class="navbar__item"><a href="schedule.php" class="navbar__links">Schedule</a></li>
                <li class="navbar__item"><a href="teacherGrades.php" class="navbar__links">Update Grades</a></li>
                <li class="navbar__item"><a href="attendence.php" class="navbar__links">Attendance</a></li>
            </ul>

            <div class="navbar__btn">
                <a href="logout.php" class="button">Logout</a>
            </div>
        </div>
    </nav>
</header><br><br><br><br><br><br>

<h1 style="text-align: center;">Class Schedule</h1><br><br>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="success-message">
        <p><?php echo htmlspecialchars($_SESSION['success_message']); ?></p>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<div class="schedule-container">
    <?php foreach ($days_schedule as $date => $classes): ?>
        <div class="day-card">
            <div class="day-header"><?php echo date('l', strtotime($date));?></div>
            <?php foreach ($classes as $class): ?>
                <div class="class-info">
                    <div class="course-name"><?php echo htmlspecialchars($class['course_name']); ?></div>
                    <div class="teacher-name">Teacher: <?php echo htmlspecialchars($class['teacher_first_name']) . ' ' . htmlspecialchars($class['teacher_last_name']); ?></div>
                    <div class="time"><?php echo date('g:i A', strtotime($class['start_time'])) . ' - ' . date('g:i A', strtotime($class['end_time'])); ?></div>

                    <button class="edit-btn" onclick="openEditModal(<?php echo $class['schedule_id']; ?>, '<?php echo $class['course_name']; ?>', '<?php echo $class['start_time']; ?>', '<?php echo $class['end_time']; ?>', '<?php echo $class['day']; ?>', <?php echo $class['course_id']; ?>)">Edit</button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

<div id="editScheduleModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeModalBtn">&times;</span>
        <h2>Edit Schedule</h2>

        <form action="schedule.php" method="POST">
            <input type="hidden" id="schedule_id" name="schedule_id">
            <div class="addUser">
                <label for="day">Day:</label>
                <input type="text" id="day" name="day" required>
            </div>
            <div class="addUser">
                <label for="start_time">Start Time:</label>
                <input type="time" id="start_time" name="start_time" required>
            </div>
            <div class="addUser">
                <label for="end_time">End Time:</label>
                <input type="time" id="end_time" name="end_time" required>
            </div>
            <div class="addUser">
                <label for="course_id">Course:</label>
                <select id="course_id" name="course_id" required>
                    <?php
                    $course_stmt = $conn->prepare("SELECT course_id, course_name FROM course WHERE teacher_id = ?");
                    $course_stmt->bind_param("i", $teacher_id);
                    $course_stmt->execute();
                    $courses = $course_stmt->get_result();

                    while ($course = $courses->fetch_assoc()) {
                        echo "<option value='" . $course['course_id'] . "'>" . htmlspecialchars($course['course_name']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="addTeacher">
                <input type="submit" name="update_schedule" value="Update Schedule">
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(schedule_id, course_name, start_time, end_time, day, course_id) {
        document.getElementById('schedule_id').value = schedule_id;
        document.getElementById('day').value = day;
        document.getElementById('start_time').value = start_time;
        document.getElementById('end_time').value = end_time;
        document.getElementById('course_id').value = course_id;
        document.getElementById('editScheduleModal').style.display = 'block';
    }

    document.getElementById('closeModalBtn').onclick = function() {
        document.getElementById('editScheduleModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('editScheduleModal')) {
            document.getElementById('editScheduleModal').style.display = 'none';
        }
    }
</script>

</body>
</html>
