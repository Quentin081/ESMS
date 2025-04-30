<?php
include('connect.php');
session_start();

$user_id = $_SESSION['user_id'];

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';

$sql = "SELECT h.hw_name, h.assigned_date, h.due_date, c.course_name
        FROM homework h
        JOIN course c ON h.course_id = c.course_id
        WHERE c.teacher_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

unset($_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Homework</title>
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
</header>

<br><br><br><br><br>

<div class="bodyContent">
    <h1 style="text-align: center;">Current Homework Assignments</h1><br>

    <?php if ($success_message): ?>
        <div class="success-message">
            <p><?php echo htmlspecialchars($success_message); ?></p>
        </div>
    <?php endif; ?>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Homework Title</th>
                        <th>Assigned Date</th>
                        <th>Due Date</th>
                    </tr>
                </thead>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tbody>
                    <tr>
                        <td>" . htmlspecialchars($row["course_name"]) . "</td>
                        <td>" . htmlspecialchars($row["hw_name"]) . "</td>
                        <td>" . htmlspecialchars($row["assigned_date"]) . "</td>
                        <td>" . htmlspecialchars($row["due_date"]) . "</td>
                    </tr>
                </tbody>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align: center;'>No homework assigned yet.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
    
    <br>
    
    <div class="addTeacher"> 
        <button id="openhwModalBtn" class = "addTeacherBtn">Add Homework Assignments</button>
    </div>

    <div id="homeworkModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closehwModalBtn">&times;</span>
            <h2 style="text-align: center;">Add New Homework</h2><br>

            <form action="addHomework.php" method="POST">
                <div class="col-md-12" align="center">
                    
                    <div class="addUser">
                        <label for="hw_name">Homework Name:</label>
                        <input type="text" id="hw_name" name="hw_name" required><br><br>
                    </div>

                    <div class="addUser">
                        <label for="assigned_date">Assigned Date:</label>
                        <input type="date" id="assigned_date" name="assigned_date" required><br><br>
                    </div>

                    <div class="addUser">
                        <label for="due_date">Due Date:</label>
                        <input type="date" id="due_date" name="due_date" required><br><br>
                    </div>

                    <div class="addUser">
                        <label for="course_id">Select Course:</label>
                        <select id="course_id" name="course_id" required>
                            <?php
                                include('connect.php');
                                $course_stmt = $conn->prepare("SELECT course_id, course_name FROM course WHERE teacher_id = ?");
                                $course_stmt->bind_param("i", $user_id);
                                $course_stmt->execute();
                                $courses = $course_stmt->get_result();
                            
                                while($course = $courses->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($course['course_id']) . "'>" . htmlspecialchars($course['course_name']) . "</option>";
                            }

                            $course_stmt->close();
                            ?>
                        </select><br><br>
                    </div>

                    <div class="addTeacher">
                        <input type="submit" name="addHomework" value="Add Homework">
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>

<script src="homeworkModal.js"></script>
</body>
</html>