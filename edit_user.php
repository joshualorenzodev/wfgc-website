<?php
    include_once('./src/libs/connect.php');
    session_start();

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query     = "SELECT * FROM `users` WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    
    $statement->bindValue(':user_id', $id, PDO::PARAM_INT);

    $statement->execute();
    $row = $statement->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/register.css">
    <title>Edit User</title>
</head>
<body>
<main>
    <form action="./src/libs/authenticate.php" method="post">
        <h1>Edit User</h1>
        <div>
            <input type="text" name="user_id" id="user_id" value="<?=$row['user_id']?>" hidden>
        </div>
        <div>
            <label for="fname">First name:</label>
            <input type="text" name="fname" id="fname" value="<?=$row['fname']?>">
        </div>
        <div>
            <label for="lname">Last name:</label>
            <input type="text" name="lname" id="lname" value="<?=$row['lname']?>">
        </div>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?=$row['username']?>">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?=$row['email']?>">
        </div>
        <div>
            <label for="role">Role:</label>
            <input type="text" name="role" id="role" value="<?=$row['role']?>">
        </div>
        <button type="submit" name="update">Update</button>
    </form>
</main>
<script src="script.js"></script>
</body>
</html>