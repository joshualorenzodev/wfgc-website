<?php
    define('DB_DSN','mysql:host=localhost;dbname=cms;charset=utf8');
    define('DB_USER','spideyfan_jjj');
    define('DB_PASS','thanoswasright');
    
    try {
        // Try creating new PDO connection to MySQL.
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);

        // if ($db) {
        //     echo "Connected to the database successfully!";
        // }
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die();
    }
?>