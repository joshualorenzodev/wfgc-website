<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/register.css">
    <title>Register</title>
</head>
<body>
<main>
    <form action="./src/libs/authenticate.php" method="post">
        <h1>Sign Up</h1>
        <div>
            <label for="fname">First name:</label>
            <input type="text" name="fname" id="fname">
        </div>
        <div>
            <label for="lname">Last name:</label>
            <input type="text" name="lname" id="lname">
        </div>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <label for="password2" id="password2_lbl">Retype password:</label>
            <input type="password" name="password2" id="password2" onchange="checkPass()">
        </div>
        <div>
            <label for="agree">
                <input type="checkbox" name="agree" id="agree" value="yes" required /> I agree
                with the
                <a href="#" title="term of services">term of services</a>
            </label>
        </div>
        <button type="submit" name="register">Register</button>
        <footer>Already a member? <a href="login.php">Login here</a></footer>
    </form>
</main>
<script src="script.js"></script>
</body>
</html>