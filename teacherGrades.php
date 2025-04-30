<?php   
include('connect.php');
session_start();

$teacher_id = $_SESSION['user_id'];

// Get students assigned to this teacher
$sql_students = "
    SELECT s.id, s.fName, s.lName 
    FROM users s
    JOIN teachers_students ts ON ts.student_id = s.id
    WHERE ts.teacher_id = ?";
$stmt_students = $conn->prepare($sql_students);
$stmt_students->bind_param("i", $teacher_id); 
$stmt_students->execute();
$students_result = $stmt_students->get_result();

// Get courses for this teacher
$sql_courses = "SELECT course_id, course_name FROM course WHERE teacher_id = ?";
$stmt_courses = $conn->prepare($sql_courses);
$stmt_courses->bind_param("i", $teacher_id); 
$stmt_courses->execute();
$courses_result = $stmt_courses->get_result();

$courses = [];
while ($row = $courses_result->fetch_assoc()) {
    $courses[$row['course_id']] = $row['course_name'];
}

// Handle grade updates
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
                }
            }
        }
    }

    $stmt_check->close();
    $_SESSION['success_message'] = "Grades successfully updated!";
    header("Location: teacherGrades.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Grades</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <nav class="navbar">
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
</header><br><br><br><br><br>

<div class="bodyContent">
    <h1 style="text-align: center;">Student Grades</h1><br>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="success-message" style="color: green; text-align: center;">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <form action="teacherGrades.php" method="POST">
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left;">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Current Grade</th>
                    <th>New Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = $students_result->fetch_assoc()): ?>
                    <?php
                    $stmt_grades = $conn->prepare("
                        SELECT g.grade, c.course_name, c.course_id
                        FROM grades g
                        JOIN course c ON c.course_id = g.course_id
                        WHERE g.id = ?");
                    $stmt_grades->bind_param("i", $student['id']);
                    $stmt_grades->execute();
                    $grades_result = $stmt_grades->get_result();
                    $grades = [];
                    while ($grade_row = $grades_result->fetch_assoc()) {
                        $grades[$grade_row['course_id']] = $grade_row['grade'];
                    }

                    $row_counter = 0;
                    foreach ($courses as $course_id => $course_name):
                        $current_grade = isset($grades[$course_id]) ? $grades[$course_id] : 'Not Graded';
                        ?>
                        <tr>
                            <?php if ($row_counter == 0): ?>
                                <td rowspan="<?php echo count($courses) + 1; ?>">
                                    <?php echo htmlspecialchars($student['fName']) . " " . htmlspecialchars($student['lName']); ?>
                                </td>
                            <?php endif; ?>
                            <td><?php echo htmlspecialchars($course_name); ?></td>
                            <td><?php echo $current_grade; ?></td>
                            <td>
                                <select name="grades[<?php echo $student['id']; ?>][<?php echo $course_id; ?>]">
                                    <option value="" <?php echo ($current_grade == 'Not Graded' ? 'selected' : ''); ?>>Not Graded</option>
                                    <option value="1" <?php echo ($current_grade == '1' ? 'selected' : ''); ?>>1</option>
                                    <option value="2" <?php echo ($current_grade == '2' ? 'selected' : ''); ?>>2</option>
                                    <option value="3" <?php echo ($current_grade == '3' ? 'selected' : ''); ?>>3</option>
                                    <option value="4" <?php echo ($current_grade == '4' ? 'selected' : ''); ?>>4</option>
                                </select>
                            </td>
                        </tr>
                        <?php $row_counter++; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" style="text-align:center; font-weight:bold;"> 
                            <a href="reportCard.php?student_id=<?php echo $student['id']; ?>" target="_blank">
                                Generate Report Card
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <br>
        <div class="addTeacher">
            <input type="submit" name="updateGrades" value="Update Grades" />
        </div>
    </form>
</div>
</body>
</html>
