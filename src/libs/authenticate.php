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
        $db_password_hash = $row['password_hash'];
        $db_fname       = $row['fname'];
        $db_lname       = $row['lname'];
        $db_email       = $row['email'];
        $db_role        = $row['role'];
        $db_status      = $row['acc_status'];
        
        if ($username !== $db_username && password_verify($password, $db_password_hash)) {
            $_SESSION['successful_login'] = false;
            header("Location: ../../login.php");
        } else if($username == $db_username && password_verify($password, $db_password_hash)) {
            
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
            
            $_SESSION['successful_login'] = true;
            header("Location: ../../admin.php");
        } else {
            $_SESSION['successful_login'] = false;
            header("Location: ../../login.php");
        }
    }

    if(isset($_POST['register'])) {
        $query = "INSERT INTO `users` (username, password, fname, lname, email, role, password_hash) VALUES (:username, :password, :fname, :lname, :email, :role, :password_hash)";
        $statement = $db->prepare($query);
        
        $reg_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg_password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg_fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg_lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $reg_role = 'user';

        $reg_password_hash = password_hash($reg_password, PASSWORD_BCRYPT);

        $statement->bindValue(':username', $reg_username, PDO::PARAM_STR);
        $statement->bindValue(':password', $reg_password, PDO::PARAM_STR);
        $statement->bindValue(':fname', $reg_fname, PDO::PARAM_STR);
        $statement->bindValue(':lname', $reg_lname, PDO::PARAM_STR);
        $statement->bindValue(':email', $reg_email, PDO::PARAM_STR);
        $statement->bindValue(':role', $reg_role, PDO::PARAM_STR);

        $statement->bindValue(':password_hash', $reg_password_hash, PDO::PARAM_STR);

        if($reg_password == $reg_password2) {
            $statement->execute();
            $_SESSION['status'] = 'online';
            $_SESSION['role'] = $reg_role;
            header("Location: ../../index.php");

        } else {
            $_SESSION['pw_match'] = false;
            header("Location: ../../register.php");
        }
    }

    
    if(isset($_POST['update'])) {
        $query     = "UPDATE `users` SET fname = :fname, lname = :lname, username = :username, email = :email, `role` = :user_role WHERE user_id = :user_id";
        $statement = $db->prepare($query);
        
        $reg_user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        $reg_fname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg_lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $reg_role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $statement->bindValue(':user_id', $reg_user_id, PDO::PARAM_STR);
        $statement->bindValue(':fname', $reg_fname, PDO::PARAM_STR);
        $statement->bindValue(':lname', $reg_lname, PDO::PARAM_STR);
        $statement->bindValue(':username', $reg_username, PDO::PARAM_STR);
        $statement->bindValue(':email', $reg_email, PDO::PARAM_STR);
        $statement->bindValue(':user_role', $reg_role, PDO::PARAM_STR);

        $statement->execute();
        header("Location: ../../admin.php");
        exit;
    }

    if(isset($_POST['add_user'])) {
        $query = "INSERT INTO `users` (username, password, fname, lname, email, role, password_hash) VALUES (:username, :password, :fname, :lname, :email, :role, :password_hash)";
        $statement = $db->prepare($query);
        
        $reg_fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg_lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $reg_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $reg_role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_EMAIL);
        $reg_role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_EMAIL);

        $reg_password_hash = password_hash($reg_password, PASSWORD_BCRYPT);

        $statement->bindValue(':username', $reg_username, PDO::PARAM_STR);
        $statement->bindValue(':password', $reg_password, PDO::PARAM_STR);
        $statement->bindValue(':fname', $reg_fname, PDO::PARAM_STR);
        $statement->bindValue(':lname', $reg_lname, PDO::PARAM_STR);
        $statement->bindValue(':email', $reg_email, PDO::PARAM_STR);
        $statement->bindValue(':role', $reg_role, PDO::PARAM_STR);
        $statement->bindValue(':password_hash', $reg_password_hash, PDO::PARAM_STR);

        $statement->execute();
        header("Location: ../../admin.php");
    }
?>