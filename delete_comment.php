<?php
    require_once("./src/libs/connect.php");

    $comment_id = filter_input(INPUT_GET, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
    $query     = "DELETE FROM `comments` WHERE comment_id = :comment_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
    $statement->execute();

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
?>