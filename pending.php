<?php include "header.php"; ?>
<?php session_start(); ?>
    <body class="text-white bg-color">

        <!-- Navbar -->
        <?php include "navigation.php"; ?>

        <div class="container">
            <div class="row">
                <!-- left -->
                <div class="col-md-8">
                    <div class="container">
                        <div class="container px-5 pt-5">
                            <div class="row m-0 p-0">
                        
                                <?php if(isset($_SESSION["username"])){ ?>
                                        <a href="add_post.php"><button class="btn btn-danger">+ Add post</button></a>
                                    <?php }?>
                            </div>
                        </div>
                        <?php
                            $query = "SELECT * FROM posts WHERE post_status = 'Draft'";
                            $allPostsQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

                            if(mysqli_num_rows($allPostsQuery)<=0){
                                echo "<h1>No posts</h1>";
                            }
                            else{
                            while($row=mysqli_fetch_assoc($allPostsQuery)){
                                $postTitle = $row["post_title"];
                                $postDate = $row["post_date"];
                                $postImage = $row["post_image"];
                                $postCategoryId = $row["post_category_id"];

                                $query = "SELECT cat_title FROM categories WHERE cat_id = $postCategoryId";
                                $categoryNameQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                $row = mysqli_fetch_row($categoryNameQuery);
                                $catTitle = $row[0];
                        ?>

                        <div class="container p-5 pt-2">
                            
                            <div class="row tile-color m-0 p-0">
                                <div class="col">
                                    <div>
                                        <img class="mx-0"src="profile.png" width="50" alt="profile-pic">
                                        <span class="overlay-text fs-4"> <?php echo $postTitle; ?></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <a href="#">
                                        <p class="text-end bi bi-chat-right-text m-2 text-white"> 1</p>
                                    </a>
                                </div>
                            </div>
                            <p class="px-3 py-1 mt-2 mb-0 tile-color">
                                <?php echo "<a class='text-secondary text-decoration-none'>$postDate</a>";?>
                                <?php echo "<a class='text-danger text-decoration-none'>$catTitle</a>" ?></p>
                            <img src="images/<?php echo $postImage; ?>" width="100%" alt="meme">
                        </div>
                        <?php }} ?>
                    </div>
                </div>

                <!-- right -->
                <div class="col-md-4 p-5">
                    <div class="container tile-color p-4">

                        <?php
                            if(isset($_SESSION["username"])){
                                include "includes/profile.php";

                            }else{

                                if(isset($_GET["source"])){
                                    $source = $_GET["source"];
    
                                    switch($source){
                                        case "register":
                                            include "includes/register.php";
                                            break;
                                        case "forgotPass":
                                            include "includes/forgot_password.php";
                                            break;
                                    }
                                }else{
                                    include "includes/login.php";
                                }
                            }
                
                        ?>
                    </div>
                    <div class="container p-4 mt-3 tile-color">
                            <p>Recommend</p>
                    </div>
                </div>
            </div>
        </div>
<!-- footer -->
<?php include "footer.php"; ?>