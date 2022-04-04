<?php
    include_once("./src/libs/connect.php");

    // if (!isset($_SESSION['role'])) {
	// 	header("Location: login.php");
    // }

    if(isset($_POST['add_category'])) {

        $query = "INSERT INTO `category` (category_title) VALUES (:category_title)";
        $statement = $db->prepare($query);    
        $category_title = filter_input(INPUT_POST, 'category_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $statement->bindValue(':category_title', $category_title, PDO::PARAM_STR);
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
    <title>Add Category</title>
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
    		        <label for="category_title">Category Title <span class="require">*</span></label>
    		        <input type="text" class="form-control" name="category_title" required />
    		    </div>
    	
    		    <div class="form-group">
    		        <button type="submit" class="btn btn-primary" name="add_category">
    		            Add
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