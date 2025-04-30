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
                <a href="adminHome.php" id="navbar-logo">ESMS</a>
                <ul class="navbar__menu">
                <li class="navbar__item">
                    <a href="addTeacher.php" class="navbar__links">View Teacher List</a>
                </li>
                <li class="navbar__item">
                    <a href="addStudent.php" class="navbar__links">View Student List</a>
                </li>
                <li class="navbar__item">
                    <a href="addParent.php" class="navbar__links">View Parents List</a>
                </li>
                </ul>

                    <div class="navbar__btn">
                        <a href="logout.php" class="button">Logout</a>
                    </div>
            </div>
        </nav>
    </header>
    <h1 class = "successMessage">Student successfully added!</h1>
    
    <div class = "centerButton">
        <a href="addStudent.php" class = "viewUserList" >View Student List</a>
    </div>

    
</body>
</html>