<?php
    session_start();
    include_once('./src/libs/connect.php');


    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query     = "DELETE FROM `users` WHERE user_id = :id";
    $statement = $db->prepare($query);
    
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    $statement->execute();
    $row = $statement->fetch();

    header("Location: ./admin.php");
    exit;
?>