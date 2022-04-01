<?php
    session_start();
    require_once("./src/libs/connect.php");
    
        // SQL is written as a String.
        $query =    "SELECT p.post_id,
                            p.post_author_id, 
                            u.fname, 
                            u.lname,
                            p.post_title,
                            p.post_content,
                            p.post_image_id,
                            p.post_publish_date
                    FROM `post` AS p
                    INNER JOIN users AS u ON p.post_id = :post_id
                    LIMIT 1";

        // A PDO::Statement is prepared from the query.
        $statement = $db->prepare($query);
    
        // Sanitize $_GET['id'] to ensure it's a number.
        $post_id = filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT);
    
        // Bind the :id parameter in the query to the sanitized
        // $id specifying a binding-type of Integer.
        $statement->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    
        // Execution on the DB server is delayed until we execute().
        $statement->execute(); 
    
        // Fetch the post selected by primary key id.
        $post = $statement->fetch();
        
?>

<!DOCTYPE html>
<html lang="en">
    
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$post['post_title']?></title>
</head>
<body>
    <h1><?= $post['post_title'] ?></h1>
    <p class="lead">
                    by <a href="index.php"><?= $post['fname'] . " " . $post['lname']?></a>
                </p>
    <p>Posted on <?= $post['post_publish_date']?></p>
    <img src="./assets/post/<?= $post['post_image_id'] ?>" alt="">
    <p><?= $post['post_content'] ?></p>

    <?php if(isset($_SESSION['userid']) && isset($_SESSION['role'])) :?>
        <?php if($post['post_author_id'] == $_SESSION['userid'] || $_SESSION['role'] == 'admin'  ) :?>
                <a href="edit_post.php?post_id=<?= $post['post_id'] ?>">
                    <button class="btn btn-primary" name="edit_post" >Edit</button>
                </a>

                <a href="delete_post.php?post_id=<?= $post['post_id'] ?>">
                    <button class="btn btn-danger" name="delete_post" >Delete</button>
                </a>
                <?php endif ?>
    <?php endif ?>



    
</body>
</html>