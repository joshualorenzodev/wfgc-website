<?php
    session_start();
    include("./src/libs/functions.php");
    include_once("./src/libs/connect.php");

    require '\xampp\htdocs\WD2\php-image-resize-master\lib\ImageResize.php';
    require '\xampp\htdocs\WD2\php-image-resize-master\lib\ImageResizeException.php';
    use \Gumlet\ImageResize;

    // file_upload_path() - Safely build a path String that uses slashes appropriate for our OS.
    // Default upload path is an 'uploads' sub-folder in the current folder.
    function file_upload_path($original_filename, $upload_subfolder_name = 'post') {
       $current_folder = 'assets';
       
       // Build an array of paths segment names to be joins using OS specific slashes.
       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
       
       // The DIRECTORY_SEPARATOR constant is OS specific.
       return join(DIRECTORY_SEPARATOR, $path_segments);
    }

    // file_is_an_image() - Checks the mime-type & extension of the uploaded file for "image-ness".
    function file_is_valid($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
        
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
        
        move_uploaded_file($temporary_image_path, $new_image_path);
        
        // Create an ImageResize object stored in $image variable
        $image = new ImageResize($new_image_path);
        
        // Resizes it to 650px
        $image->resizeToWidth(650);
        $resized_image = $filename . $extension;
        $image->save($resized_image);
        unlink($new_image_path);
        rename(__DIR__ . DIRECTORY_SEPARATOR . $filename . $extension, __DIR__ . DIRECTORY_SEPARATOR . './assets/post' . DIRECTORY_SEPARATOR. $resized_image );
        
        // Moves temp file to upload directory
        // Resizes it to 50px
        // $image->resizeToWidth(50);
        // $thumb_size = $filename . '_thumbnail' . $extension;
        // $image->save($thumb_size);
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

    if(isset($_POST['create_post'])) {

        $query = "INSERT INTO `post` (post_title, post_author_id, post_content, post_category_id, post_image_id) VALUES (:post_title, :post_author_id, :post_content, :post_category_id, :post_image_id)";
        $statement = $db->prepare($query);

        $post_title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_author_id = filter_var($_SESSION['userid'], FILTER_SANITIZE_NUMBER_INT);
        $post_content = filter_input(INPUT_POST, 'post_content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $post_category_id = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
        $post_image_id = filter_var($image_filename, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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
        $post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);
        
        if ($_POST['delete_image']) {
            unlink("./assets/post/" . $_POST['image_filename']);
            $post_image_id = "";
        } else {
            $post_image_id = filter_var($image_filename, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        
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