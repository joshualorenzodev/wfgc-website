<?php




?>

<?php include './src/inc/header.php'?>
<div class="container-fluid">
    <?php include './src/inc/nav.php'?> 
    <div class="container">
        <div class="col-sm-3">
            <h4>Login</h4>
            <form action="./src/libs/authenticate.php" method="post">
                <div class="form-group">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username"> 
                </div>
                
                <div class="input-group">
                    <input type="password"   name="password" id="password" class="form-control" placeholder="Password"> 
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">Submit</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <!-- <?php include './src/inc/footer-section.php'?> -->
</div>
<?php include './src/inc/footer.php'?>