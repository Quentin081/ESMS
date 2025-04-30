<?php
session_start();

$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System - Home</title>
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
    </header><br><br><br><br><br>
    
    <div class="homepage-content">
        <div class="welcome-message">
            <h1>Welcome, <?php echo $first_name . ' ' . $last_name; ?>!</h1>
            <p>Your go-to portal for managing classes, homework, grades, attendance, and more.</p>
        </div>
        
        <div class="dashboard">
            <div class="dashboard-card">
                <h3>View Class List</h3>
                <p>Check the list of students in your classes.</p>
                <a href="viewClassList.php" class="dashboard-link">Go to Class List</a>
            </div>

            <div class="dashboard-card">
                <h3>Homework</h3>
                <p>Assign and track homework for your students.</p>
                <a href="teacherHomework.php" class="dashboard-link">Manage Homework</a>
            </div>

            <div class="dashboard-card">
                <h3>Grades</h3>
                <p>Update and view student grades.</p>
                <a href="teacherGrades.php" class="dashboard-link">Go to Grades</a>
            </div>

            <div class="dashboard-card">
                <h3>Attendance</h3>
                <p>Track student attendance for each class.</p>
                <a href="attendence.php" class="dashboard-link">Record Attendance</a>
            </div>
        </div>
    </div>

</body>
</html>
