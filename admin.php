<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != 'admin') {
        header("Location: index.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Welcome to admin, <?=$_SESSION['fname']?></h1>

    <a href="logout.php"><button>Logout</button></a>
</body>
</html>