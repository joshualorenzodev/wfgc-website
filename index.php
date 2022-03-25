<?php


?>
<?php include './src/inc/header.php'?>

    <div class="container-fluid">
        <div class="hero">
            <?php include './src/inc/nav.php'?>

            <div class="hero-content-container">
                <div class="hero-content">
                    <h1 class="hero-title">Jesus Christ is the same yesterday <br>and today and forever.</h1>
                    <p class="hero-tagline">Join us Sunday at 10:00am In-Person & Online</p>
                    <div class="hero-btns">
                        <a href="https://www.facebook.com/bethel.churchwinnipeg/" class="hero-btn">Livestream</a>
                        <a href="https://www.youtube.com/channel/UCj19-mZHRsHR6l6Ncyl3elg" class="hero-btn">YouTube</a>
                    </div>
                </div>
            </div>
        </div>
        
        <section class="cta-cards">
            <div class="cta-card">
                <h2 class="card-title">Stay in the loop</h2>
                <p class="card-text">Get a run down of what's on this week at Gateway.</p>
                <a href="announcement.php" class="card-btn">This Week</a>
            </div>
            <div class="cta-card">
                <h2 class="card-title">Join a group</h2>
                <p class="card-text">Connecting outside of Sunday is a great way to build relationships and your faith.</p>
                <a href="contact.php" class="card-btn">More Info</a>
            </div>
            <div class="cta-card">
                <h2 class="card-title">Reach out</h2>
                <p class="card-text">We'd be honoured to get to know you. Send us a message today.</p>
                <a href="contact.php" class="card-btn">Connect</a>
            </div>
            <div class="cta-card">
                <h2 class="card-title">Meet Us</h2>
                <p class="card-text">We'd be honoured to get to know you. Send us a message today.</p>
                <a href="https://www.google.com/maps/place/898+Henderson+Hwy,+Winnipeg,+MB+R2K+3T4/@49.9327396,-97.1020901,17z/data=!3m1!4b1!4m5!3m4!1s0x52ea7051826fd54d:0xc8be4e8781a71579!8m2!3d49.9327362!4d-97.0999014" target="_blank" class="card-btn">Directions</a>
            </div>
        </section>

        <section id="prayer">
            <div class="prayer-content">
                <h2>Need a prayer?</h2>
                <p>Life happens. In moments of difficulty or uncertainty prayer is a powerful response because we trust our situation to the creator of all things. We'd love to pray for you.</p>
                <a href="contact.php">Ask for Prayer</a>
            </div>
        </section>

        <section class="cta-content">
            <div class="content-card">
                <a href="register.php">
                    <img class="content-icon" src="./assets/mail.png" alt="Newsletter">
                    <h2 class="content-title">Weekly Email</h2>
                    <p class="content-text">Subscribe to our weekly email newsletter</p>
                </a>
            </div>
            <div class="content-card">
                <a href="blog.php">
                    <img class="content-icon" src="./assets/watch.png" alt="Watch">
                    <h2 class="content-title">Watch</h2>
                    <p class="content-text">Check out recent sermons from WFGC</p>
                </a>
            </div>
            <div class="content-card">
                <a href="give.php">
                    <img class="content-icon" src="./assets/give.png" alt="Give">
                    <h2 class="content-title">Give</h2>
                    <p class="content-text">Bring your tithes and offerings online</p>
                </a>
            </div>
        </section>

        <?php include './src/inc/footer-section.php'?>
    </div>
<?php include './src/inc/footer.php'?>