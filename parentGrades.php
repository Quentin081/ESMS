<?php 
include('connect.php');
session_start();

$parent_id = $_SESSION['user_id'];
$selected_student_id = isset($_POST['student_id']) ? $_POST['student_id'] : null;

// Fetch all children linked to this parent
$children_stmt = $conn->prepare("
    SELECT u.id, u.fName, u.lName
    FROM parents_students ps
    JOIN users u ON ps.student_id = u.id
    WHERE ps.parent_id = ?");
$children_stmt->bind_param("i", $parent_id);
$children_stmt->execute();
$children_result = $children_stmt->get_result();
$children = $children_result->fetch_all(MYSQLI_ASSOC);
$children_stmt->close();

// Initialize
$grades = [];
$child_name = '';

if ($selected_student_id) {
    // Get selected child's name
    $name_stmt = $conn->prepare("SELECT fName, lName FROM users WHERE id = ?");
    $name_stmt->bind_param("i", $selected_student_id);
    $name_stmt->execute();
    $name_stmt->bind_result($fName, $lName);
    $name_stmt->fetch();
    $child_name = "$fName $lName";
    $name_stmt->close();

    // Get grades
    $grades_stmt = $conn->prepare("
        SELECT c.course_name, g.grade, c.grade_level
        FROM grades g
        JOIN course c ON g.course_id = c.course_id
        WHERE g.id = ?");
    $grades_stmt->bind_param("i", $selected_student_id);
    $grades_stmt->execute();
    $grades_result = $grades_stmt->get_result();
    while ($row = $grades_result->fetch_assoc()) {
        $grades[] = $row;
    }
    $grades_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent's View of Child's Grades</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
<header>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="parentHome.php" id="navbar-logo">ESMS</a>
            <ul class="navbar__menu">
                <li class="navbar__item"><a href="parentGrades.php" class="navbar__links">Grades</a></li>
                <li class="navbar__item"><a href="parentSchedule.php" class="navbar__links">Schedule</a></li>
                <li class="navbar__item"><a href="parentAttendance.php" class="navbar__links">Attendance</a></li>
            </ul>
            <div class="navbar__btn">
                <a href="logout.php" class="button">Logout</a>
            </div>
        </div>
    </nav>
</header><br><br><br><br><br>

<div class="bodyContent">
    <form method="POST" style="text-align:center;">
        <label for="student_id">Select a child:</label>
        <select name="student_id" id="student_id" required>
            <option value="">-- Choose --</option>
            <?php foreach ($children as $child): ?>
                <option value="<?= $child['id'] ?>" <?= $selected_student_id == $child['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($child['fName'] . ' ' . $child['lName']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">View Grades</button>
    </form>

    <?php if ($selected_student_id): ?>
        <br><h2><?= htmlspecialchars('Grades for ' . $child_name) ?></h2>

        <?php if (count($grades) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Grade</th>
                        <th>Grade Level</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($grades as $grade): ?>
                        <tr>
                            <td><?= htmlspecialchars($grade['course_name']) ?></td>
                            <td><?= htmlspecialchars($grade['grade']) ?></td>
                            <td><?= htmlspecialchars($grade['grade_level']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align:center;">No grades found for this child.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>
