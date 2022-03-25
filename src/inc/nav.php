<?php
    session_start();

    require ('./src/libs/connect.php');

    if (!isset($_SESSION['status'])) {
        $login_btn = "login";
    } else {
        $login_btn = "logout";
    }
?>
<header class="main-header">
    <div class="logo">
        <a href="index.php"><img src="./assets/logo_transparent.png" alt="Logo" id="wfgc-logo"></a>
    </div>
    <nav class="main-nav">
        <ul class="nav-bar">
            <li class="nav-item"><a href="#about" class="nav-link">About</a></li>
            <li class="nav-item"><a href="#ministries" class="nav-link">Ministries</a></li>
            <li class="nav-item"><a href="blog.php" class="nav-link">Sermon</a></li>
            <li class="nav-item"><a href="#give" class="nav-link">Give</a></li>
            <li class="nav-item"><a href="<?=$login_btn?>.php" class="nav-link"><?=ucwords($login_btn)?></a></li>
        </ul>
    </nav>
</header>