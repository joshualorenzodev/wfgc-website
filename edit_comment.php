<?php
    session_start();
    require_once("./src/libs/connect.php");

    $comment_query = "SELECT * FROM `comments`
                       WHERE comment_id = :comment_id";
    $comment_statement = $db->prepare($comment_query);
    $comment_id = filter_input(INPUT_GET, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
    $comment_statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
    $comment_statement->execute(); 
    $row = $comment_statement->fetch();


    if(isset($_POST['edit_comment'])) {

        $query     = "UPDATE `comments` 
                    SET comment_content = :comment_content
                    WHERE comment_id = :comment_id";
        $statement = $db->prepare($query);

        $comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
        $comment_content = filter_input(INPUT_POST, 'comment_content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
        $statement->bindValue(':comment_content', $comment_content, PDO::PARAM_STR);

        $statement->execute();

        header('Location: view_post.php?post_id='. $_SESSION['previous_post']);
        exit;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment</title>
</head>



<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<body>

<div class="container">
	<div class="row">
	    
	    <div class="col-md-8 col-md-offset-2">
	        
    		<h1>Edit Comment</h1>
    		
    		<form action="" method="POST">
    		    
    		    <div class="form-group">
                    <input type="number" name="comment_id" value="<?= $row['comment_id'] ?>" hidden>
    		        <label for="comment_title">Comment <span class="require">*</span></label>
    		        <input type="text" class="form-control" name="comment_content" value="<?= $row['comment_content'] ?>" required/>
    		    </div>
    	
    		    <div class="form-group">
    		        <button type="submit" class="btn btn-primary" name="edit_comment">
    		            Save
    		        </button>
    		        <a class="btn btn-default" href="view_post.php?post_id=<?= $_SESSION['previous_post'] ?>">
    		            Cancel
    		        </a>
    		    </div>
    		    
    		</form>
		</div>
	</div>
</div>

</body>
</html>