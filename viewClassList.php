<?php
include('connect.php');

session_start();
$user_id = $_SESSION['user_id'];

$sql = "
    SELECT 
        s.id AS student_id, 
        s.fName AS student_first_name, 
        s.lName AS student_last_name, 
        s.email AS student_email, 
        s.phone AS student_phone,
        p.id AS parent_id, 
        p.fName AS parent_first_name, 
        p.lName AS parent_last_name, 
        p.email AS parent_email, 
        p.phone AS parent_phone
    FROM users s
    JOIN parents_students ps ON s.id = ps.student_id
    JOIN users p ON ps.parent_id = p.id
    JOIN teachers_students ts ON s.id = ts.student_id
    WHERE ts.teacher_id = ? AND s.userType = 'student'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Students and Their Parents</title>
    <link rel="stylesheet" href="styles.css" />
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
</header>

<br><br><br><br><br><br>

<div class="bodyContent">
    <h1 style="text-align:center;">Classlist</h1><br>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Student Email</th>
                        <th>Student Phone</th>
                        <th>Parent Name</th>
                        <th>Parent Email</th>
                        <th>Parent Phone</th>
                    </tr>
                </thead>
                <tbody>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["student_id"]) . "</td>
                    <td>" . htmlspecialchars($row["student_first_name"]) . " " . htmlspecialchars($row["student_last_name"]) . "</td>
                    <td>" . htmlspecialchars($row["student_email"]) . "</td>
                    <td>" . htmlspecialchars($row["student_phone"]) . "</td>
                    <td>" . htmlspecialchars($row["parent_first_name"]) . " " . htmlspecialchars($row["parent_last_name"]) . "</td>
                    <td>" . htmlspecialchars($row["parent_email"]) . "</td>
                    <td>" . htmlspecialchars($row["parent_phone"]) . "</td>
                  </tr>";
        }
        
        echo "</tbody></table>";
    } else {
        echo "<p style='text-align:center;'>No students or parents found.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
</div>

</body>
</html>
