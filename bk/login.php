<?php
session_start();

if (isset($_SESSION['isAdmin'])) {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style/style.css">
    <title>login</title>
</head>
<body>

    <div class="wapper">
        <form action="authAdminLog.php" method="POST">

            <div class="loginFail">
                <p>
                <?php 
                if (isset($_SESSION['loginFail'])) {
                    echo "Username or Password dosn't match";
                }
            ?>
                </p>
            </div>

            <h1>Login</h1>

            <div class="input-box">
                <input name="username" type="text" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input name="password" type="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="login">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
    
</body>
</html>