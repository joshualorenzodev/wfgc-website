<?php
	session_start();

	if (!isset($_SESSION['role'])) {
		header("Location: login.php");
    }

    require '\xampp\htdocs\WD2\php-image-resize-master\lib\ImageResize.php';
    require '\xampp\htdocs\WD2\php-image-resize-master\lib\ImageResizeException.php';
    use \Gumlet\ImageResize;

    // file_upload_path() - Safely build a path String that uses slashes appropriate for our OS.
    // Default upload path is an 'uploads' sub-folder in the current folder.
    function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
       $current_folder = dirname(__FILE__);
       
       // Build an array of paths segment names to be joins using OS specific slashes.
       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
       
       // The DIRECTORY_SEPARATOR constant is OS specific.
       return join(DIRECTORY_SEPARATOR, $path_segments);
    }

    // file_is_an_image() - Checks the mime-type & extension of the uploaded file for "image-ness".
    function file_is_valid($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png', 'pdf'];
        
        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = mime_content_type($temporary_path);

        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
        
        return $file_extension_is_valid && $mime_type_is_valid;
    }

    // Moves the original file and resized copies
    function move_files($temporary_image_path, $new_image_path, $image_mime_type) {
        
        $extension = '.' . pathinfo($new_image_path, PATHINFO_EXTENSION);
        $filename = str_replace(' ', '_', basename($new_image_path, $extension));
		$_SESSION['file_name'] = $filename;

        // Checks if it's pdf, if not a pdf then it will just move it but resize the images.
        if($image_mime_type !== 'application/pdf') {
            // Moves temp file to upload directory
            move_uploaded_file($temporary_image_path, $new_image_path);
            
            // Create an ImageResize object stored in $image variable
            $image = new ImageResize($new_image_path);
            
            // Resizes it to 400px
            $image->resizeToWidth(400);
            $medium_size = $filename . '_medium' . $extension;
            $image->save($medium_size);
            rename(__DIR__ . DIRECTORY_SEPARATOR . $filename . '_medium' . $extension, __DIR__ . DIRECTORY_SEPARATOR. 'uploads' . DIRECTORY_SEPARATOR . $medium_size );
            
            // Resizes it to 50px
            $image->resizeToWidth(50);
            $thumb_size = $filename . '_thumbnail' . $extension;
            $image->save($thumb_size);
            rename(__DIR__ . DIRECTORY_SEPARATOR . $filename . '_thumbnail' . $extension, __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR. $thumb_size );

        } else {
            move_uploaded_file($temporary_image_path, $new_image_path);
        }
    }
    
    $image_upload_detected = isset($_FILES['post_image']) && ($_FILES['post_image']['error'] === 0);
    $upload_error_detected = isset($_FILES['post_image']) && ($_FILES['post_image']['error'] > 0);

    if ($image_upload_detected) { 
        $image_filename        = str_replace(' ', '_', $_FILES['post_image']['name']);
        $image_mime_type       = $_FILES['post_image']['type'];
        $temporary_image_path  = $_FILES['post_image']['tmp_name'];
        $new_image_path        = file_upload_path($image_filename);
		
        if (file_is_valid($temporary_image_path, $new_image_path)) {
            if (!file_exists(dirname($new_image_path)) && !is_dir(dirname($new_image_path))) {
                // Creates an uploads directory if it doesn't exist
                mkdir(dirname($new_image_path));
                move_files($temporary_image_path, $new_image_path, $image_mime_type);
            } else {
                move_files($temporary_image_path, $new_image_path, $image_mime_type);
            }
        }
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
    		
    		<form action="post_authentication.php" method="POST" enctype="multipart/form-data">
    		    
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
					<select class="form-select" name="category" aria-label="Category" required>
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