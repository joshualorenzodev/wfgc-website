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

    <a href="logout.php"><button>Logout</button></a>
    <a href="index.php"><button>Home</button></a>

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
                <tr>
                    <th scope="row">1</th>
                    <td>John</td>
                    <td>Doe</td>
                    <td>jdoe</td>
                    <td>jdeo@gmail.com</td>
                    <td>user</td>
                    <td>2022-03-24</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>John</td>
                    <td>Doe</td>
                    <td>jdoe</td>
                    <td>jdeo@gmail.com</td>
                    <td>user</td>
                    <td>2022-03-24</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>John</td>
                    <td>Doe</td>
                    <td>jdoe</td>
                    <td>jdeo@gmail.com</td>
                    <td>user</td>
                    <td>2022-03-24</td>
                </tr>
            </tbody>
        </table>
    </div>
        
        
        
    </body>
    
    </html>