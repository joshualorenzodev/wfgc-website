<?php
    include_once('./src/libs/connect.php');
    session_start();




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/register.css">
    <title>Add User</title>
</head>
<body>
<main>
    <form action="./src/libs/authenticate.php" method="post">
        <h1>Add User</h1>
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
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="temp_pass">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="role">Role:</label>
            <input type="text" name="role" id="role">
        </div>
        <button type="submit" name="add_user">Update</button>
    </form>
</main>
<script src="script.js"></script>
</body>
</html>