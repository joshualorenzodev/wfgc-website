<?php
    require_once("./src/libs/connect.php");

    $post_id = filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT);
    $query     = "DELETE FROM `post` WHERE post_id = :post_id";
    $statement = $db->prepare($query);
    $statement->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: blog.php");
?>