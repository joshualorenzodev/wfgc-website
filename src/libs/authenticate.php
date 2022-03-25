<?php
    require ('connect.php');

    session_start();
    
    if(isset($_POST['login'])) {        
        $query = "SELECT * FROM `users` WHERE username = :username AND password = :password";
        
        $statement = $db->prepare($query);
        
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->bindValue(':password', $password, PDO::PARAM_STR);

        $statement->execute();

        $row = $statement->fetch();

        $db_user_id     = $row['user_id'];
        $db_username    = $row['username'];
        $db_password    = $row['password'];
        $db_fname       = $row['fname'];
        $db_lname       = $row['lname'];
        $db_email       = $row['email'];
        $db_role        = $row['role'];
        $db_status      = $row['acc_status'];

    }

    if ($username !== $db_username && $password !== $db_password) {
        header("Location: ../../login.php");
    } else if($username == $db_username && $password == $db_password) {
        
        $_SESSION['userid']    = $db_user_id;
        $_SESSION['username']   = $db_username;
        $_SESSION['fname']      = $db_fname;
        $_SESSION['lname']      = $db_lname;
        $_SESSION['role']       = $db_role;
        $_SESSION['status']     = $db_status;
        
        $query = "UPDATE `users` SET acc_status = :acc_status WHERE `user_id` = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':acc_status', 'online', PDO::PARAM_STR);        
        $statement->bindValue(':id', $_SESSION['userid'] , PDO::PARAM_INT);
        $statement->execute();
    

        header("Location: ../../admin.php");
    } else {
        header("Location: ../../login.php");
    }
?>