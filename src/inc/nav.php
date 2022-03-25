<?php
    session_start();

    require_once ('./src/libs/connect.php');

    if(!isset($_SESSION['role'])) {
        $login_btn = "login";
    } else if($_SESSION['role'] == 'admin') {
        $login_btn = "admin";
    } else if($_SESSION['role'] == 'user') {
        $login_btn = "logout";
    } else {
        $login_btn = "login";
    }
?>
<header class="main-header">
    <div class="logo">
        <a href="index.php"><img src="./assets/logo_transparent.png" alt="Logo" id="wfgc-logo"></a>
    </div>
    <nav class="main-nav">
        <ul class="nav-bar">
            <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
            <li class="nav-item"><a href="ministries.php" class="nav-link">Ministries</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Sermon</a></li>
            <li class="nav-item"><a href="give.php" class="nav-link">Give</a></li>
            <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
            <li class="nav-item"><a href="<?=$login_btn?>.php" class="nav-link"><?=ucwords($login_btn)?></a></li>
        </ul>
    </nav>
</header>