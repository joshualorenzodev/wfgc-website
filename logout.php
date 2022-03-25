<?php
    session_start();
    require ('./src/libs/connect.php');

    $query = "UPDATE `users` SET acc_status = :acc_status WHERE `user_id` = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':acc_status', 'offline', PDO::PARAM_STR);        
    $statement->bindValue(':id', $_SESSION['userid'] , PDO::PARAM_INT);
    $statement->execute();

    unset($_SESSION['userid']);
    unset($_SESSION['username']);
    unset($_SESSION['fname']);
    unset($_SESSION['lname']);  
    unset($_SESSION['role']);  
    unset($_SESSION['status']);  
    unset($_SESSION['successful_login']);

    session_destroy();

    header("Location: ./index.php")
?>