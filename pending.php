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
                        <?php include "includes/delete_modal.php"; ?>
                            <div class="row m-0 p-0">
                        
                                <?php if(isset($_SESSION["username"])){ ?>
                                        <a href="add_post.php"><button class="btn btn-danger">+ Add post</button></a>
                                    <?php }?>
                            </div>
                        </div>
                        <?php
                            $query = "SELECT * FROM posts WHERE post_status = 'Draft' ORDER BY post_date DESC";
                            $allPostsQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

                            if(mysqli_num_rows($allPostsQuery)<=0){
                                echo "<h1>No posts</h1>";
                            }
                            else{
                            while($row=mysqli_fetch_assoc($allPostsQuery)){
                                $postId = $row["post_id"];
                                $postTitle = $row["post_title"];
                                $postDate = $row["post_date"];
                                $postImage = $row["post_image"];
                                $postCategoryId = $row["post_category_id"];
                                $postAuthorId = $row["post_author_id"];
                                $postContent = $row["post_content"];

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
                                        <img class="mx-0"src="images/avatars/<?php echo $postAuthorPic; ?>" width="50" alt="profile-pic">
                                        <span class="overlay-text fs-4"> <?php echo $postTitle; ?></span>
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
                                <?php echo "<a class='text-secondary text-decoration-none'>$postDate</a>";?>
                                <?php echo "<a class='text-danger text-decoration-none'>$catTitle</a>" ?></p>
                            <?php if(!empty($postContent)): ?>
                                <p class="px-3 py-1 mt-2 mb-0 tile-color"><?php echo $postContent; ?></p>
                            <?php endif; ?>
                            <img src="images/<?php echo $postImage; ?>" width="100%" alt="meme">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <button class="btn btn-danger">+</button>
                                    <strong class="mx-3">1</strong>
                                    <button class="btn btn-warning">&#9733;</button>
                                </div>
                                <?php
                                    if(isset($_SESSION["user_role"]) && $_SESSION["user_role"]=="Admin"){
                                ?>
                                    
                                <div class="col-6 text-end">
                                    <a href="pending.php?accept=<?php echo $postId; ?>"><button class="btn btn-success">&#x2713;</button></a>
                                    <!-- <a href="pending.php?delete=<?php echo $postId; ?>"><button class="btn btn-danger">&#10005;</button></a> -->
                                    <a rel="<?php echo $postId;?>"href="#" class="delete_link"><button class="btn btn-danger">&#10005;</button></a>

                                </div>
                                <?php
                                    }
                                ?>
                            </div>
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

<?php
    if(isset($_GET["accept"])){
        $postId = $_GET["accept"];
        
        $query = "UPDATE posts SET post_status = 'Published' WHERE post_id = $postId";
        $acceptPostQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
        header("Location: pending.php");
    }

    if(isset($_GET["delete"])){
        $postId = $_GET["delete"];

        $query = "DELETE FROM posts WHERE post_id = $postId";
        $deletePostQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
        header("Location: pending.php");
    }
?>

<script src="js/delete_post.js"></script>