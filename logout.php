<?php
    session_start();
    require ('./src/libs/connect.php');

    $query = "UPDATE `users` SET acc_status = :acc_status WHERE `user_id` = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':acc_status', 'offline', PDO::PARAM_STR);        
    $statement->bindValue(':id', $_SESSION['userid'] , PDO::PARAM_INT);
    $statement->execute();

    $_SESSION['userid']    = null;
    $_SESSION['username']   = null;
    $_SESSION['fname']      = null;
    $_SESSION['lname']      = null;
    $_SESSION['role']       = null;
    $_SESSION['status']     = null;

    header("Location: ./index.php")
?>