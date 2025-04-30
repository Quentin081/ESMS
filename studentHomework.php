<?php
include('connect.php');
session_start();
$user_id = $_SESSION['user_id']; 

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';

$sql = "SELECT h.homework_id, h.hw_name, h.assigned_date, h.due_date, 
               c.course_name, sh.status
        FROM student_homework sh
        JOIN homework h ON sh.homework_id = h.homework_id
        JOIN course c ON h.course_id = c.course_id
        WHERE sh.student_id = ?
        ORDER BY h.due_date ASC";

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
    <title>ESMS - Student Homework</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <nav class="navbar" role="navigation">
        <div class="navbar__container">
            <a href="studentHome.php" id="navbar-logo">ESMS</a>
            <ul class="navbar__menu">
                <li class="navbar__item"><a href="studentGrades.php" class="navbar__links">Grades</a></li>
                <li class="navbar__item"><a href="studentHomework.php" class="navbar__links">Homework</a></li>
                <li class="navbar__item"><a href="studentSchedule.php" class="navbar__links">Schedule</a></li>
            </ul>
            <div class="navbar__btn">
                <a href="logout.php" class="button">Logout</a>
            </div>
        </div>
    </nav>
</header><br><br><br><br><br>

<div class="bodyContent">
    <h1 style="text-align:center;">My Homework Assignments:</h1><br>

    <?php if ($success_message): ?>
        <div class="success-message">
            <p><?php echo htmlspecialchars($success_message); ?></p>
        </div>
    <?php endif; ?>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Course</th>
                    <th>Homework Name</th>
                    <th>Assigned Date</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['course_name']) . "</td>
                    <td>" . htmlspecialchars($row['hw_name']) . "</td>
                    <td>" . htmlspecialchars($row['assigned_date']) . "</td>
                    <td>" . htmlspecialchars($row['due_date']) . "</td>
                    <td>" . htmlspecialchars($row['status']) . "</td>
                    <td>";

            if ($row['status'] !== 'Submitted') {
                echo "
                    <div class='homework-actions'>
                        <input type='file' name='homework_file' />
                        <button class='submit-btn' onclick='submitHomework(" . $row['homework_id'] . ")'>Submit Homework</button>
                    </div>
                ";
            } else {
                echo "✅ Submitted";
            }

            echo "</td></tr>";
        }

        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No homework assigned.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
</div>

<script>
    function submitHomework(hw_id) {
        $.ajax({
            url: 'submitHomework.php',
            type: 'POST',
            data: { homework_id: hw_id },
            success: function(response) {
                if (response === 'success') {
                    alert('Homework Submitted');
                    location.reload();
                } else {
                    alert('Error submitting homework. Please try again.');
                }
            },
            error: function() {
                alert('AJAX request failed.');
            }
        });
    }
</script>

</body>
</html>