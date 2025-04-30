<?php
include('connect.php');

session_start();

$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            u.id, u.fName, u.lName, c.course_name, g.grade, c.grade_level
        FROM grades g
        JOIN users u ON g.id = u.id
        JOIN course c ON g.course_id = c.course_id
        WHERE g.id = ?";

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
    <title>ESMS</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/80efcbb723.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <nav class="navbar" role="navigation" aria-label="Main Navigation">
            <div class="navbar__container">
                <a href="studentHome.php" id="navbar-logo">ESMS</a>
                <ul class="navbar__menu">
                    <li class="navbar__item">
                        <a href="studentGrades.php" class="navbar__links">Grades</a>
                    </li>
                    <li class="navbar__item">
                        <a href="studentHomework.php" class="navbar__links">Homework</a>
                    </li>
                    <li class="navbar__item">
                        <a href="studentSchedule.php" class="navbar__links">Schedule</a>
                    </li>
                </ul>

                    <div class="navbar__btn">
                        <a href="logout.php" class="button">Logout</a>
                    </div>
            </div>
        </nav>
        </header><br><br><br><br><br><br>
        <div class = "bodyContent">
            <h1 style="text-align:center;">My School Grades:</h1><br>

            <?php
            if ($result->num_rows > 0) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Grade</th>
                                <th>Grade Level</th>
                            </tr>
                        </thead>
                        <tbody>";
            
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row["course_name"]) . "</td>
                            <td>" . htmlspecialchars($row["grade"]) . "</td>
                            <td>" . htmlspecialchars($row["grade_level"]) . "</td>
                          </tr>";
                }
            
                echo "</tbody></table>";
            }
            
            $conn->close();
            ?>
            
            <br>
            <div>
                <p> Grade Explaination: </p>
                <p> 4 = Exceeds Expectations </p>
                <p> 3 = Meets Expectations </p>
                <p> 2 = Approaching Expectations </p>
                <p> 1 = Needs Improvement </p>
            </div>

</body>
</html>