<?php
    session_start();

    include_once("./src/libs/connect.php");

    if(isset($_POST['create_post'])) {
        $query = "INSERT INTO `post` (post_title, post_author_id, post_content, post_category_id) VALUES (:post_title, :post_author_id, :post_content, :post_category_id)";
        $statement = $db->prepare($query);

        $post_title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_author_id = filter_var($_SESSION['userid'], FILTER_SANITIZE_NUMBER_INT);
        $post_content = filter_input(INPUT_POST, 'post_content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_category_id = 1;

        $statement->bindValue(':post_title', $post_title, PDO::PARAM_STR);
        $statement->bindValue(':post_author_id', $post_author_id, PDO::PARAM_INT);
        $statement->bindValue(':post_content', $post_content, PDO::PARAM_STR);
        $statement->bindValue(':post_category_id', $post_category_id, PDO::PARAM_INT);

        $statement->execute();

        header("Location: blog.php");

    }



    if(isset($_POST['delete_post'])) {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    
        $query     = "DELETE FROM `users` WHERE user_id = :id";
        $statement = $db->prepare($query);
        
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
    
        $statement->execute();
        $row = $statement->fetch();
    
    }
?>