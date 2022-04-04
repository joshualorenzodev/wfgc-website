<?php
    include_once("./src/libs/connect.php");

    // if (!isset($_SESSION['role'])) {
	// 	header("Location: login.php");
    // }
    
    $category_query = "SELECT * FROM `category`
                       WHERE category_id = :category_id";
    $category_statement = $db->prepare($category_query);
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT);
    $category_statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
    $category_statement->execute(); 
    $row = $category_statement->fetch();

    if(isset($_POST['edit_category'])) {

        $query = "UPDATE `category` 
                  SET category_title = :category_title
                  WHERE category_id = :category_id";
        $statement = $db->prepare($query);    
        $category_title = filter_input(INPUT_POST, 'category_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $statement->bindValue(':category_title', $category_title, PDO::PARAM_STR);
        $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $statement->execute();
        
        header("Location: admin.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>



<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<body>

<div class="container">
	<div class="row">
	    
	    <div class="col-md-8 col-md-offset-2">
	        
    		<h1>Add new category</h1>
    		
    		<form action="" method="POST">
    		    
    		    <div class="form-group">
                    <input type="number" name="category_id" value="<?= $row['category_id'] ?>" hidden>
    		        <label for="category_title">Category Title <span class="require">*</span></label>
    		        <input type="text" class="form-control" name="category_title" value="<?= $row['category_title'] ?>" required/>
    		    </div>
    	
    		    <div class="form-group">
    		        <button type="submit" class="btn btn-primary" name="edit_category">
    		            Save
    		        </button>
    		        <a class="btn btn-default" href="admin.php">
    		            Cancel
    		        </a>
    		    </div>
    		    
    		</form>
		</div>
	</div>
</div>

</body>
</html>