<?php
    require ('connect.php');
    
    if(isset($_POST['login'])) {        
        $query = "SELECT * FROM `users` WHERE username = :username AND password = :password";
        
        $statement = $db->prepare($query);
        
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->bindValue('password', $password, PDO::PARAM_STR);

        $statement->execute();

        $row = $statement->fetch();

        $db_user_id     = $row['user_id'];
        $db_username    = $row['username'];
        $db_password    = $row['password'];
        $db_fname       = $row['fname'];
        $db_lname       = $row['lname'];
        $db_email       = $row['email'];
        $db_role        = $row['role'];
    }

    if ($username !== $db_username && $password !== $db_password) {
        header("Location: ../../login.php");
    } else if($username == $db_username && $password == $db_password) {
        header("Location: ../../admin.php");
    } else {
        header("Location: ../../login.php");
    }
?>