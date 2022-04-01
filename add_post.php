<?php
	session_start();

	if (!isset($_SESSION['role'])) {
		header("Location: login.php");
    }

?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
	<div class="row">
	    
	    <div class="col-md-8 col-md-offset-2">
	        
    		<h1>Create post</h1>
    		
    		<form action="post_authentication.php" method="POST">
    		    
    		    <!-- <div class="form-group has-error">
    		        <label for="slug">Slug <span class="require">*</span> <small>(This field use in url path.)</small></label>
    		        <input type="text" class="form-control" name="slug" />
    		        <span class="help-block">Field not entered!</span>
    		    </div>
    		     -->
                 
    		    <div class="form-group">
    		        <label for="title">Title <span class="require">*</span></label>
    		        <input type="text" class="form-control" name="post_title" id="post_title" required />
    		    </div>
    		    
    		    <div class="form-group">
    		        <label for="post_content">Content <span class="require">*</label>
    		        <textarea rows="5" class="form-control" name="post_content" id="post_content" required ></textarea>
    		    </div>

				<div class="form-group">
					<select class="form-select" aria-label="Default select example" required>
						<option selected>Category</option>
						<option value="1">Faith</option>
						<option value="2">Love</option>
						<option value="3">Praise</option>
					</select>
				</div>
    		    
				<div class="form-group">
					<label for='post_image'>Post image <span class="require">*</label>
					<input type='file' name='post_image' id='post_image' >
				</div>

    		    <div class="form-group">
    		        <button type="submit" class="btn btn-primary" name="create_post">
    		            Create
    		        </button>
    		        <a class="btn btn-default" href="blog.php">
    		            Cancel
    		        </a>
    		    </div>
    		    
    		</form>
		</div>
		
	</div>
</div>