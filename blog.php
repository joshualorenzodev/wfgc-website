<?php
    include_once("./src/libs/connect.php");

    if(isset($_GET['category_id'])) {
        
        $query = "SELECT p.post_id, 
                        concat(u.fname,' ',u.lname) AS 'full_name',
                        p.post_title,
                        c.category_title,
                        p.post_content,
                        p.post_image_id,
                        p.post_publish_date
                    FROM `post` p, `users` u, `category` c
                    WHERE p.post_author_id = u.user_id AND 
                        p.post_category_id = c.category_id AND
                        p.post_category_id = :post_category_id
                    ORDER BY `post_publish_date` DESC";
        $statement = $db->prepare($query);
        $post_category_id = filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT);
        $statement->bindValue(':post_category_id', $post_category_id, PDO::PARAM_INT);
    } else if (isset($_GET['search_query'])) {
        $query = "SELECT p.post_id, 
                        concat(u.fname,' ',u.lname) AS 'full_name',
                        p.post_title,
                        c.category_title,
                        p.post_content,
                        p.post_image_id,
                        p.post_publish_date
                FROM `post` p, `users` u, `category` c
                WHERE p.post_author_id = u.user_id AND 
                    p.post_category_id = c.category_id AND
                    
                    p.post_title LIKE :search_query OR
                    u.fname LIKE :search_query OR
                    u.lname LIKE :search_query OR
                    p.post_content LIKE :search_query OR
                    c.category_title LIKE :search_query
                ORDER BY `post_publish_date` DESC";
        $statement = $db->prepare($query);
        $search_query = "%" . filter_input(INPUT_GET, 'search_query', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "%";
        $statement->bindValue(':search_query', $search_query, PDO::PARAM_STR);
    } else {
        $query =    "SELECT p.post_id, 
                        concat(u.fname,' ',u.lname) AS 'full_name',
                        p.post_title,
                        c.category_title,
                        p.post_content,
                        p.post_image_id,
                        p.post_publish_date
                    FROM `post` p, `users` u, `category` c
                    WHERE p.post_author_id = u.user_id AND 
                          p.post_category_id = c.category_id
                    ORDER BY `post_publish_date` DESC";
        $statement = $db->prepare($query);
    }
    
    $statement->execute();


    $category_query = "SELECT * FROM `category`";
    $category_statement = $db->prepare($category_query);
    $category_statement->execute();
?>


<?php include './src/inc/header.php'?>
<?php include './src/inc/nav.php'?>

<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <!-- <h1 class="page-header">Page Heading <small>Secondary Text</small></h1> -->
            <?php while($row = $statement->fetch()) : ?>
                <?php
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['full_name'];
                    $post_content = $row['post_content'];
                    $post_category = $row['category_title'];
                    $post_image_id = $row['post_image_id'];
                    $post_publish_date = date( "M d, Y g:i:s A", strtotime($row['post_publish_date']));
                ?>
                
                <!-- First Blog Post -->
                <h2>
                    <a href="view_post.php?post_id=<?= $post_id ?>"><?= $post_title?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?= $post_author?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?= $post_publish_date?></p>
                <a href="search.php?category=<?= $post_category ?>"?>#<?= $post_category ?></a>
                <hr>
                <img class="img-responsive" src="./assets/post/<?=$post_image_id?>" alt="">
                <hr>

                <?php if(strlen($post_content) > 300): ?>
                            <?=substr($post_content, 0, 300) . '...'?>
                            <!-- <a href="show.php?id=<?=$post['id']?>">Read More</a> -->
                            <br>
                            <a class="btn btn-primary mt-2" href="view_post.php?post_id=<?= $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <?php else: ?>
                            <p><?= $post_content?></p>
                <?php endif ?>
                <hr>
            <?php endwhile ?>
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-4">

            <!-- Blog Search Well -->
            <div class="well">
                <h4>Blog Search</h4>
                <div class="input-group">
                    <form action="blog.php" method="GET">
                        <input type="text" name="search_query" class="form-control">
                        <button class="btn btn-dark" type="submit">Search</button>
                    </form>
                </div>
                <!-- /.input-group -->
            </div>

            <!-- Blog Categories Well -->
            <div class="well">
                <h4 class="mt-3">Blog Categories</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-unstyled">
                            <?php while ($row = $category_statement->fetch() ) :?>
                                <li><a href="blog.php?category_id=<?= $row['category_id'] ?>">#<?= $row['category_title'] ?></a></li>
                            <?php endwhile ?>
                        </ul>
                    </div>
                    <!-- /.col-lg-6 -->
                    <!-- <div class="col-lg-6">
                        <ul class="list-unstyled">
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                        </ul>
                    </div> -->
                    <!-- /.col-lg-6 -->
                </div>
                <!-- /.row -->
            </div>

            <!-- Side Widget Well -->
            <!-- <div class="well">
                <h4>Side Widget Well</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus
                    laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
            </div> -->

            <a class="btn btn-success" href="add_post.php">Create Post</a>
        </div>
    </div>
    <hr>
</div>
<!-- <?php include './src/inc/footer-section.php'?> -->
<?php include './src/inc/footer.php'?>