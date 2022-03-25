<?php
    session_start();
    include_once('./src/libs/connect.php');

    $id      = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);

    // Build the parameterized SQL query and bind to the above sanitized values.
    $query     = "DELETE FROM `users` WHERE user_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    
    // Execute the UPDATE.
    $statement->execute();

    header("Location: ./admin.php");
    exit;
?>