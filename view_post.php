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

        $statement = $db->prepare($query);
        $post_id = filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT);
        $statement->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $statement->execute(); 
        $post = $statement->fetch();



        $comment_query = "SELECT cm.comment_content,
                                 cm.comment_id,
                                 cm.comment_publish_date,
                                 concat(u.fname,' ',u.lname) AS 'comment_author'
                            FROM `comments` AS cm, `users` AS u
                            WHERE cm.comment_post_id = :comment_post_id AND
                                  cm.comment_author_id = u.user_id
                            ORDER BY `comment_publish_date` DESC";
        $comment_statement = $db->prepare($comment_query);
        $comment_post_id = filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT);
        $comment_statement->bindValue(':comment_post_id', $comment_post_id, PDO::PARAM_INT);
        $comment_statement->execute(); 

        $captcha_error = "";

        $comment_captcha = filter_input(INPUT_POST, 'captcha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(isset($_POST['post_comment'])) {
            $_SESSION['comment_content'] = $_POST['comment_content'];

            if(empty($comment_captcha)) {
                $captcha_error = "Please enter the captcha";
            } else if ($_SESSION['CAPTCHA_CODE'] == $comment_captcha) {
                $captcha_error = "Correct";
                $add_comment_query = "INSERT INTO `comments` (comment_post_id,
                                                            comment_author_id,
                                                            comment_content) VALUES
                                                            (:comment_post_id,
                                                            :comment_author_id,
                                                            :comment_content)";
                $add_comment_statement = $db->prepare($add_comment_query);
        
                $comment_author_id = filter_var($_SESSION['userid'], FILTER_SANITIZE_NUMBER_INT);
                $comment_content = filter_input(INPUT_POST, 'comment_content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $comment_post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);
        
                $add_comment_statement->bindValue(':comment_post_id', $comment_post_id, PDO::PARAM_INT);
                $add_comment_statement->bindValue(':comment_author_id', $comment_author_id, PDO::PARAM_INT);
                $add_comment_statement->bindValue(':comment_content', $comment_content, PDO::PARAM_STR);
                $add_comment_statement->execute();
                unset($_SESSION['comment_content']);
                header("Location: view_post.php?post_id=$comment_post_id");
            } else if ($_SESSION['CAPTCHA_CODE'] != $comment_captcha) {
                $captcha_error = "Captcha is incorrect. Try again. ";
            } 
            else {
                $captcha_error = "Error validating the captcha";
            }
        }

        
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
                <a href="edit_post.php?post_id=<?= $post['post_id'] ?>" class="btn btn-primary">Edit</a>
                <a href="delete_post.php?post_id=<?= $post['post_id'] ?>" class="btn btn-danger">Delete</a>
        <?php endif ?>
    <?php endif ?>

    <hr>
    <h2>Comments</h2>
    
    <div class="comments">
        <?php while($comment = $comment_statement->fetch()) : ?>
            <?php
                $comment_publish_date = date( "M d, Y g:i A", strtotime($comment['comment_publish_date']));
            ?>
            <div class="comment-card">
                <h4 class="comment-author"><?= $comment['comment_author'] ?> - <span class="comment-date"><?= $comment_publish_date ?></span></h4>
                <p class="comment-content">
                    <?= $comment['comment_content'] ?>
                </p>
                <?php if(isset($_SESSION['userid']) && isset($_SESSION['role'])) :?>
                    <?php if($post['post_author_id'] == $_SESSION['userid'] || $_SESSION['role'] == 'admin'  ) :?>
                        <?php $_SESSION['previous_post'] = $comment_post_id ?>
                        <a href="edit_comment.php?comment_id=<?= $comment['comment_id'] ?>" class="btn btn-primary">Edit</a>
                        <a href="delete_comment.php?comment_id=<?= $comment['comment_id'] ?>" class="btn btn-danger">Delete</a>
                <?php endif ?>
            <?php endif ?>
            </div>

            <hr>
        <?php endwhile ?>
    </div>
    
    
    <div class="comment-form">
        <form method="POST" action="">
            <div class="form-group">
                <h4>Leave a comment</h4> 
                <label for="message">Message</label>
                <input type="number" name="post_id" value="<?= $post['post_id'] ?>" hidden>
                <textarea name="comment_content" cols="30" rows="5" class="form-control"><?= isset($_SESSION['comment_content']) ? $_SESSION['comment_content'] : null ?> </textarea>
                <p for="captcha"><?= $captcha_error ?></p>
                <img src="captcha.php" alt="Captcha"><br>
                <input type="text" name="captcha" id="captcha">
            </div>
 
            <?php if (isset($_SESSION['userid'])) : ?>
                <div class="form-group"> <button type="submit" name="post_comment">Post Comment</button> </div>
                <?php else : ?>
                    <a href="login.php">Login to comment</a>
            <?php endif ?>
        </form>
    </div>


    
</body>
</html>