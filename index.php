<?php include "header.php"; ?>
<?php session_start(); ?>
    <body class="text-white bg-color">

        <!-- Navbar -->
        <?php include "navigation.php"; ?>

        <div class="container pt-5">
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
                            $query = "SELECT * FROM posts WHERE post_status='Published'";
                            $allPostsQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                            $numOfPosts = mysqli_num_rows($allPostsQuery);
                            $postsPerPage = 2;
                            $numOfPages = ceil($numOfPosts/$postsPerPage);
                            $postStart = 0;
                            $pageNum=1;

                            if(isset($_GET["page"])){
                                $pageNum = $_GET["page"];
                                $postStart = ($pageNum*$postsPerPage)-$postsPerPage;
                            }

                            if(isset($_GET['category'])){
                                $category = $_GET['category'];
                                $query = "SELECT * FROM posts WHERE post_status = 'Published' AND post_category_id = $category ";
                                $query .= "ORDER BY post_date DESC";
                            }else{
                                $query = "SELECT * FROM posts WHERE post_status = 'Published' ";
                                $query .= "ORDER BY post_date DESC LIMIT $postStart, $postsPerPage";
                            }
        
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
                                $postAuthorId = $row["post_author_id"];
                                $postId = $row["post_id"];
                                $postContent = $row["post_content"];

                                $query = "SELECT cat_title FROM categories WHERE cat_id = $postCategoryId";
                                $categoryNameQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                $row = mysqli_fetch_row($categoryNameQuery);
                                $catTitle = $row[0];

                                $query = "SELECT username,user_image FROM users WHERE user_id = $postAuthorId";
                                $postAuthorQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                $row = mysqli_fetch_row($postAuthorQuery);
                                $postAuthor = $row[0];
                                $postAuthorPic = $row[1];
                                if(empty($postAuthorPic) or $postAuthorPic === NULL){
                                    $postAuthorPic = "profile.png";
                                }
                        ?>

                        <div class="container p-5 pt-2">
                            
                            <div class="row tile-color m-0 p-0">
                                <div class="col">
                                    <div>
                                        <img class="mx-0"src="images/avatars/<?php echo $postAuthorPic;?>" width="50" alt="profile-pic">
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
                            <?php if(!empty($postContent)): ?>
                                <p class="px-3 py-1 mt-2 mb-0 tile-color"><?php echo $postContent; ?></p>
                            <?php endif; ?>
                            <img src="images/<?php echo $postImage; ?>" width="100%" alt="meme" class="tile-color">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <button class="btn btn-danger like" title="<?php echo $postId; ?>">+</button>
                                    <strong class="mx-3">7</strong>
                                    <button class="btn btn-warning">&#9733;</button>
                                </div>
                            </div>
                        </div>
                        <?php }} ?>
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
                                        case "resetPass";
                                            include "includes/reset.php";
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
            
            <!-- pagination -->
            <?php include "includes/pagination.php"; ?>
        </div>

        
<!-- footer -->
<?php include "footer.php"; ?>