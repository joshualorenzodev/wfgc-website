<?php
    session_start();
    
    if (!isset($_SESSION['successful_login'])) {
        $err_msg = '';
    } else if (isset($_SESSION['successful_login']) && $_SESSION['successful_login']) {
        $err_msg = "Login succesful!";
    } else {
        $err_msg = "Login failed. Try again!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/register.css">
    <title>Login</title>
</head>
<body>
<main>
    <form action="./src/libs/authenticate.php" method="post">
        <h1>Login</h1>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>

        <p class="error_message"><?=$err_msg?></p>

        <button type="submit" name="login">Login</button>
        <footer>Not a member? <a href="register.php">Register here</a></footer>
    </form>
</main>
</body>
</html>