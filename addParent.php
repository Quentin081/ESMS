<?php
include('connect.php');

$userType = 'parent';

$stmt = $conn->prepare("SELECT id, fName, lName, email, userType, phone FROM users WHERE userType = ?");
$stmt ->bind_param("s", $userType);

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a new Teacher</title>
    <link rel="stylesheet" href="styles.css" />
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
                    <a href="addParent.php" class="navbar__links">View Parent List</a>
                </li>
                </ul>

                    <div class="navbar__btn">
                        <a href="logout.php" class="button">Logout</a>
                    </div>
            </div>
        </nav>
    </header><br><br><br><br><br><br>
    <div class="bodyContent">
    <h1 style="text-align:center;">Current Parent List</h1><br>
    
    <?php
    
    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tbody>
                    <tr>
                        <td>" . htmlspecialchars($row["id"]) . "</td>
                        <td>" . htmlspecialchars($row["fName"]). " " . htmlspecialchars($row["lName"]). "</td>
                        <td>" . htmlspecialchars($row["email"]) . "</td>
                        <td>" . htmlspecialchars($row["phone"]) . "</td>
                    </tr>
                <tbody>";
        }
        echo "</table>";
    }

    $stmt->close();
    $conn->close();
    ?>
    <br>
    <div class="addTeacher"> 
    <button id="openModalBtn" class = "addTeacherBtn">Add a Parent</button>
</div>

<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeModalBtn">&times;</span>
        <h2 style="text-align:center;">Add a Parent:</h2><br>
        <form action="registerParent.php" method="POST">
            <div class="col-md-12 cold-md-offset-3" align="center">
                <div class="addUser">
                    <label for="fName">First Name:</label>
                    <input type="text" id="f_name" name="fName" placeholder="First Name"><br><br>
                </div>

                <div class="addUser">
                    <label for="lName">Last Name:</label>
                    <input type="text" id="l_name" name="lName" placeholder="Last Name"><br><br>
                </div>

                <div class="addUser">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email"><br><br>
                </div>

                <div class="addUser">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Password"><br><br>
                </div>

                <div class="addUser">
                    <label for="phone">Phone Number:</label>
                    <input type="text" id="phoneNum" name="phone" placeholder="111-111-1111"><br><br>
                </div>

                <div class="addUser">
                    <label for="userType">User Type:</label>
                    <select id="user_type" name="userType" required>
                        <option value="parent" selected>Parent</option>
                    </select><br><br>
                </div>
                
                <div class="addTeacher">
                    <input type="submit" value="Add Parent">
                </div>
            </div>
        </form>
    </div>
</div>
    </div>
<script src="modal.js"></script>

    </div>
</body>
</html>