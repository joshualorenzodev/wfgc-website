<?php
    session_start();
    include("./src/libs/functions.php");
    include_once("./src/libs/connect.php");

    if(isset($_POST['create_post'])) {
        $query = "INSERT INTO `post` (post_title, post_author_id, post_content, post_category_id, post_image_id) VALUES (:post_title, :post_author_id, :post_content, :post_category_id, :post_image_id)";
        $statement = $db->prepare($query);

        $post_title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_author_id = filter_var($_SESSION['userid'], FILTER_SANITIZE_NUMBER_INT);
        $post_content = filter_input(INPUT_POST, 'post_content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_category_id = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
        $post_image_id = 'gospel.jpg';

        $statement->bindValue(':post_title', $post_title, PDO::PARAM_STR);
        $statement->bindValue(':post_author_id', $post_author_id, PDO::PARAM_INT);
        $statement->bindValue(':post_content', $post_content, PDO::PARAM_STR);
        $statement->bindValue(':post_category_id', $post_category_id, PDO::PARAM_INT);
        $statement->bindValue(':post_image_id', $post_image_id, PDO::PARAM_STR);

        $statement->execute();

        header("Location: blog.php");

    }

    if(isset($_POST['edit_post'])) {
    
        $query     = "UPDATE `post` SET post_title = :post_title,
                                        post_content = :post_content,
                                        post_category_id = :post_category_id,
                                        post_image_id = :post_image_id
                                    WHERE post_id = :post_id";
        $statement = $db->prepare($query);
        
        $post_title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_content = filter_input(INPUT_POST, 'post_content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_category_id = filter_input(INPUT_POST, 'post_category_id', FILTER_SANITIZE_NUMBER_INT);
        // $post_image_id = filter_input(INPUT_POST, 'post_image_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_image_id = 'gospel.jpg';
        $post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);

        $statement->bindValue(':post_title', $post_title, PDO::PARAM_STR);
        $statement->bindValue(':post_content', $post_content, PDO::PARAM_STR);
        $statement->bindValue(':post_category_id', $post_category_id, PDO::PARAM_INT);
        $statement->bindValue(':post_image_id', $post_image_id, PDO::PARAM_STR);
        $statement->bindValue(':post_id', $post_id, PDO::PARAM_INT);

        $statement->execute();
        
        header("Location: view_post.php?post_id=.$post_id.");
        exit;
    
    }
?>