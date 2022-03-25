<?php
    session_start();
    require ('./src/libs/connect.php');

    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] != 'admin') {
            header("Location: index.php");
        }
    }

        // SQL is written as a String.
    $query = "SELECT * FROM `users` ORDER BY `registration_date`";

    // A PDO::Statement is prepared from the query.
    $statement = $db->prepare($query);

    // Execution on the DB server is delayed until we execute().
    $statement->execute(); 

?>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head> -->

<?php include ('./src/inc/header.php') ?>

<body>

    <h1>Welcome to admin, <?=$_SESSION['fname']?></h1>

    <a href="logout.php"><button class="btn btn-warning">Logout</button></a>
    <a href="index.php"><button class="btn btn-info">Home</button></a>
    <a href="add_user.php"><button class="btn btn-primary">Add User</button></a>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle ">
            <thead>
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Registration Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $statement->fetch()): ?>
                    <?php
                        $tbl_user_id = $row['user_id'];
                        $tbl_fname = $row['fname'];
                        $tbl_lname = $row['lname'];
                        $tbl_username = $row['username'];
                        $tbl_email = $row['email'];
                        $tbl_role = $row['role'];
                        $tbl_registratin_date = $row['registration_date'];

                        $_SESSION['user_id']    = $tbl_user_id;
                        $_SESSION['fname']      = $tbl_fname;
                        $_SESSION['lname']      = $tbl_lname;
                        $_SESSION['username']   = $tbl_username;
                        $_SESSION['email']   = $tbl_email;
                        $_SESSION['role']       = $tbl_role;
                    ?>
                    <tr>
                        <th scope="row"><?=$tbl_user_id?></th>
                        <td><?=$tbl_fname?></td>
                        <td><?=$tbl_lname?></td>
                        <td><?=$tbl_username?></td>
                        <td><?=$tbl_email?></td>
                        <td><?=$tbl_role?></td>
                        <td><?=$tbl_registratin_date?></td>
                        <td><a href="edit_user.php" class="btn btn-success">Edit</a></td>
                        <td><a href="delete_user.php" class="btn btn-danger">Delete</a</td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
        
        
        
    </body>
    
    </html>