<?php
    include_once('./src/libs/connect.php');
    session_start();

    $post_id = filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT);

    $query     = "SELECT * FROM `post` WHERE post_id = :post_id LIMIT 1";
    $statement = $db->prepare($query);
    
    $statement->bindValue(':post_id', $post_id, PDO::PARAM_INT);

    $statement->execute();
    $row = $statement->fetch();
?>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
	<div class="row">
	    
	    <div class="col-md-8 col-md-offset-2">
	        
    		<h1>Edit post</h1>
    		
    		<form action="post_authentication.php" method="POST" enctype="multipart/form-data">
    		    
    		    <!-- <div class="form-group has-error">
    		        <label for="slug">Slug <span class="require">*</span> <small>(This field use in url path.)</small></label>
    		        <input type="text" class="form-control" name="slug" />
    		        <span class="help-block">Field not entered!</span>
    		    </div>
    		     -->
                <input type="number" name="post_id" id="post_id" value="<?= $row['post_id'] ?>" hidden>

    		    <div class="form-group">
    		        <label for="title">Title <span class="require">*</span></label>
    		        <input type="text" class="form-control" name="post_title" id="post_title" required value="<?= $row['post_title'] ?>" />
    		    </div>
    		    
    		    <div class="form-group">
    		        <label for="post_content">Content <span class="require">*</label>
    		        <textarea rows="5" class="form-control" name="post_content" id="post_content" required ><?= $row['post_content'] ?></textarea>
    		    </div>

				<div class="form-group">
					<select class="form-select" name="post_category_id" aria-label="Category" required>
						<option selected disabled>Category</option>
						<option value="1"<?= $row['post_category_id'] == 1 ? 'selected' : '' ?>>Faith</option>
						<option value="2"<?= $row['post_category_id'] == 2 ? 'selected' : '' ?>>Love</option>
						<option value="3"<?= $row['post_category_id'] == 3 ? 'selected' : '' ?>>Peace</option>
					</select>
				</div>
    		    
				<div class="form-group">
					<label for='post_image'>Post image <span class="require">*</label>
					<input type='file' name='post_image' id='post_image' >
				</div>

    		    <div class="form-group">
    		        <button type="submit" class="btn btn-primary" name="edit_post">
    		            Update
    		        </button>
    		        <a class="btn btn-default" href="view_post.php?post_id=<?= $row['post_id'] ?>">
    		            Cancel
    		        </a>
    		    </div>
    		    
    		</form>
		</div>
	</div>
</div>