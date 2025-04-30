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
    <title>ESMS - Parent Dashboard</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/80efcbb723.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <nav class="navbar" role="navigation" aria-label="Main Navigation">
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

    <div class="homepage-content">
        <div class="welcome-message">
            <h1>Welcome, <?php echo $first_name . ' ' . $last_name; ?>!</h1>
            <p>Your personalized dashboard to monitor your child's progress.</p>
        </div>

        <br><br><br>
        
        <div class="dashboard">
            <div class="dashboard-card">
                <h3>Grades</h3>
                <p>Check your child's grades for each subject.</p>
                <a href="parentGrades.php" class="dashboard-link">View Grades</a>
            </div>

            <div class="dashboard-card">
                <h3>Schedule</h3>
                <p>View your child's daily schedule.</p>
                <a href="parentSchedule.php" class="dashboard-link">View Schedule</a>
            </div>

            <div class="dashboard-card">
                <h3>Attendance</h3>
                <p>Track your child's attendance.</p>
                <a href="parentAttendance.php" class="dashboard-link">View Attendance</a>
            </div>
        </div>
    </div>

</body>
</html>
