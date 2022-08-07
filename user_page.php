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
                            <div class="row">
                                <div class="col-4 m-0 p-0">
                                    <img class="rounded-circle img-fluid"src="profile.png" alt="profile_pic" width="200">
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <h1><?php echo $_SESSION["username"]; ?></h1>
                                    </div>
                                    <div class="row">
                                        <!-- all user's posts -->
                                        <?php
                                            $username = $_SESSION["username"];
                                            $userId = $_SESSION['user_id'];
                                            $query = "SELECT * FROM posts WHERE post_author_id = $userId";
                                            $allUserPostsQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                            $numOfPosts = mysqli_num_rows($allUserPostsQuery);

                                            $query = "SELECT * FROM posts WHERE post_author_id = $userId AND post_status = 'Published'";
                                            $allUserPublishedPostsQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                            $numOfPublishedPosts = mysqli_num_rows($allUserPublishedPostsQuery);
                                        ?>
                                        <p><span class="bi bi-image mx-1"> <?php echo "$numOfPublishedPosts/$numOfPosts"; ?></span> 

                                        <!-- all user's comments -->
                                        <?php
                                            $username = $_SESSION["username"];
                                            $query = "SELECT * FROM comments WHERE comment_author = '$username'";
                                            $allUsersCommentsQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                            $numOfUserComments = mysqli_num_rows($allUsersCommentsQuery);
                                        ?> 
                                        <span class="bi bi-chat-right-text mx-1"> <?php echo $numOfUserComments; ?></span>
                                        <?php
                                            $query = "SELECT user_create_date FROM users WHERE user_id = $userId";
                                            $userDateQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                            $row=mysqli_fetch_row($userDateQuery);
                                            $userDate = $row["0"];
                                        ?>
                                        <span class="bi bi-flag mx-1"> <?php echo $userDate; ?></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <?php
                                    if(isset($_GET["source"])){
                                ?>
                                    <div class="col-6 m-0 p-1">
                                        <a href="user_page.php"><button class="btn btn-secondary w-100">User's posts</button></a>
                                    </div>
                                    <div class="col-6 m-0 p-1">
                                        <a href="user_page.php?source=comments"><button class="btn btn-danger w-100">User's comments</button></a>
                                    </div>
                                <?php
                                    }else{
                                ?>
                                <div class="col-6 m-0 p-1">
                                    <a href="user_page.php"><button class="btn btn-danger w-100">User's posts</button></a>
                                </div>
                                <div class="col-6 m-0 p-1">
                                    <a href="user_page.php?source=comments"><button class="btn btn-secondary w-100">User's comments</button></a>
                                </div>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="row">
                                <!-- displaying all user's comments -->
                                <?php
                                    if(isset($_GET["source"])){
                                        $query = "SELECT * FROM comments WHERE comment_author = '$username'";
                                        $allUserCommentsQuery = mysqli_query($connection, $query) or die("SQL Error :: ".mysqli_error($connection));

                                        while($row = mysqli_fetch_assoc($allUserCommentsQuery)){
                                            $commentAuthor = $row["comment_author"];
                                            $commentDate = $row["comment_date"];
                                            $commentContent = $row["comment_content"];
                                ?>
                                <div class="container p-0 mt-2 tile-color">
                                <div class="d-flex flex-row comment-row py-3 px-2">
                                    <div class="p-2">
                                        <img src="profile.png" alt="user_profile" width="40">
                                    </div>
                                    <div class="w-100">
                                        <h6 class="text-danger"><?php echo $commentAuthor;?>  <small class="text-secondary"><?php echo $commentDate; ?></small></h6>
                                        <span class="m-b-15 d-block"><?php echo $commentContent; ?></span>
                                    </div>
                                </div>
                                </div> 
                                <?php
                                        }
                                    }else{
                                ?>
                                <!-- displaying all user's posts -->
                                <?php
                                    $query = "SELECT * FROM posts WHERE post_author_id = $userId";
                                    $allUsersPostsQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                    if(mysqli_num_rows($allUserPostsQuery) === 0){
                                        echo "<h2>No posts</h2>";
                                    }

                                    while($row = mysqli_fetch_assoc($allUsersPostsQuery)){
                                        $postAuthor = $_SESSION["username"];
                                        $postId = $row["post_id"];
                                        $postTitle = $row["post_title"];
                                        $postDate = $row["post_date"];
                                        $postImage = $row["post_image"];
                                        $postCategoryId = $row["post_category_id"];
        
                                        $query = "SELECT cat_title FROM categories WHERE cat_id = $postCategoryId";
                                        $categoryNameQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                        $row = mysqli_fetch_row($categoryNameQuery);
                                        $catTitle = $row[0];
                                ?>
                                <div class="container p-0 pt-2">
                                <div class="row tile-color m-0 p-0 mt-5">
                                    <div class="col">
                                        <div>
                                            <img class="mx-0"src="profile.png" width="50" alt="profile-pic">
                                            <span class="overlay-text fs-4">
                                                <a href="post.php?post_id=<?php echo $postId; ?>"><?php echo $postTitle; ?></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <a href="#">
                                            <!-- number of comments -->
                                            <?php
                                                $query = "SELECT * FROM comments WHERE comment_post_id = $postId";
                                                $allPostCommentsQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                                $numOfComments = mysqli_num_rows($allPostCommentsQuery);
                                            ?>
                                            <p class="text-end bi bi-chat-right-text m-2 text-white"> <?php echo $numOfComments; ?></p>
                                        </a>
                                    </div>
                                </div>
                                <p class="px-3 py-1 mt-2 mb-0 tile-color">
                                    <?php echo "<a class='text-danger text-decoration-none'>$postAuthor</a>" ?>
                                    <?php echo "<a class='text-secondary text-decoration-none'>$postDate</a>";?>
                                    <?php echo "<a href='index.php?category=$postCategoryId'class='text-danger text-decoration-none'>$catTitle</a>" ?></p>
                                <img src="images/<?php echo $postImage; ?>" width="100%" alt="meme" class="tile-color">
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button class="btn btn-danger like" title="<?php echo $postId; ?>">+</button>
                                        <strong class="mx-3">7</strong>
                                        <button class="btn btn-warning">&#9733;</button>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }}
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript" src="js/likes.js"></script>

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