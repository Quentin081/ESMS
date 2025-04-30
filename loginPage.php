<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

    <div class="container">
            <div class="col-md-12 cold-md-offset-3" align="center">
                <h1 style="font-size:35px;">Welcome to the ESMS!</h1>
                <h2 style="color: crimson;font-size:15px;">
                    <?php
                        error_reporting(0);
                        session_start();
                        echo $_SESSION['loginMessage'];
                    ?>
                </h2>

                <form action="login.php" method="POST">
                    <div class="inputGroup">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" required placeholder="Enter School Email" /><br><br>
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" required placeholder="Enter password" /><br><br>
                        <input type="submit" value="Login" name ="login" class="btn btn-success"><br><br>
                        <p class="psw">
                            <a href="forgotPass.php">Forgot Password?</a>
                        </p>
                    </div>
                </form>
            </div>
    </div>
</body>

</html>