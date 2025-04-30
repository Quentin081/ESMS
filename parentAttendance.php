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

$attendance_records = [];
$student_name = "";

if ($selected_child_id) {
    $stmt = $conn->prepare("SELECT fName, lName FROM users WHERE id = ?");
    $stmt->bind_param("i", $selected_child_id);
    $stmt->execute();
    $stmt->bind_result($fName, $lName);
    $stmt->fetch();
    $student_name = "$fName $lName";
    $stmt->close();

    $att_sql = "SELECT attendance_date, status FROM attendance WHERE student_id = ? ORDER BY attendance_date DESC";
    $att_stmt = $conn->prepare($att_sql);
    $att_stmt->bind_param("i", $selected_child_id);
    $att_stmt->execute();
    $att_result = $att_stmt->get_result();
    while ($row = $att_result->fetch_assoc()) {
        $attendance_records[] = $row;
    }
    $att_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Child's Attendance</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-container { text-align: center; margin: 30px; }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-top: 40px; }
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
            </ul>
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
        <button type="submit">View Attendance</button>
    </form>
</div>

<?php if ($selected_child_id): ?>
    <h2>Attendance for <?= htmlspecialchars($student_name) ?></h2>
    <?php if (!empty($attendance_records)): ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendance_records as $record): ?>
                    <tr>
                        <td><?= htmlspecialchars(date("F j, Y", strtotime($record['attendance_date']))) ?></td>
                        <td><?= htmlspecialchars($record['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No attendance records found.</p>
    <?php endif; ?>
<?php endif; ?>
</div>
</body>
</html>
