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
    <title>ESMS - Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/80efcbb723.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <nav class="navbar" role="navigation" aria-label="Main Navigation">
            <div class="navbar__container">
                <a href="adminHome.php" id="navbar-logo">ESMS</a>
                <ul class="navbar__menu">
                    <li class="navbar__item">
                        <a href="addTeacher.php" class="navbar__links">Teacher List</a>
                    </li>
                    <li class="navbar__item">
                        <a href="addStudent.php" class="navbar__links">Student List</a>
                    </li>
                    <li class="navbar__item">
                        <a href="addParent.php" class="navbar__links">Parents List</a>
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
            <p>Your admin dashboard for managing teachers, students, and parents.</p>
        </div>

        <div class="dashboard">
            <div class="dashboard-card">
                <h3>Teachers</h3>
                <p>View and manage the teacher list.</p>
                <a href="addTeacher.php" class="dashboard-link">View Teacher List</a>
            </div>

            <div class="dashboard-card">
                <h3>Students</h3>
                <p>View and manage the student list.</p>
                <a href="addStudent.php" class="dashboard-link">View Student List</a>
            </div>

            <div class="dashboard-card">
                <h3>Parents</h3>
                <p>View and manage the parent list.</p>
                <a href="addParent.php" class="dashboard-link">View Parents List</a>
            </div>
        </div>
    </div>

</body>
</html>
