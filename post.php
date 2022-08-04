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
                        </div>
                        <?php
                            if(isset($_GET["post_id"])){
                                $postId = $_GET["post_id"];
                                $query = "SELECT * FROM posts WHERE post_id = $postId";
                            }
        
                            $postQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

                            while($row=mysqli_fetch_assoc($postQuery)){
                                $postTitle = $row["post_title"];
                                $postDate = $row["post_date"];
                                $postImage = $row["post_image"];
                                $postCategoryId = $row["post_category_id"];
                                $postAuthorId = $row["post_author_id"];

                                $query = "SELECT cat_title FROM categories WHERE cat_id = $postCategoryId";
                                $categoryNameQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                $row = mysqli_fetch_row($categoryNameQuery);
                                $catTitle = $row[0];

                                $query = "SELECT username FROM users WHERE user_id = $postAuthorId";
                                $postAuthorQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                $row = mysqli_fetch_row($postAuthorQuery);
                                $postAuthor = $row[0];
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
                                <?php echo "<a class='text-danger text-decoration-none'>$postAuthor</a>" ?>
                                <?php echo "<a class='text-secondary text-decoration-none'>$postDate</a>";?>
                                <?php echo "<a class='text-danger text-decoration-none'>$catTitle</a>" ?></p>
                            <img src="images/<?php echo $postImage; ?>" width="100%" alt="meme">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <button class="btn btn-danger">+</button>
                                    <strong class="mx-3">1</strong>
                                    <button class="btn btn-warning">&#9733;</button>
                                </div>
                            </div>
                            <?php } ?>
                        <a href="index.php"><button class="btn btn-danger mt-5 w-100" style="font-size: 1.5em;">Back to homepage</button></a>
                            
                            <!-- leave comment section -->
                            <div class="row mt-5 tile-color">
                                <div class="card-footer py-3">
                                    <div class="d-flex flex-start w-100">
                                        <img class="me-3" src="profile.png" alt="avatar" width="40" height="40"/>
                                        <div class="form-outline w-100">
                                            <form action="" method="POST">
                                                <textarea name="comment_content" class="form-control bg-dark border-dark text-secondary" rows="2" placeholder="Leave a comment"></textarea>
                                    </div>
                                                <input type="submit" name="leave_comment" class="btn btn-secondary h-50 mx-2" value="&#10148;">
                                            </form>
                                        </div>
                                </div>
                                <!-- all comments -->
                                <?php
                                    $query = "SELECT * FROM comments WHERE comment_post_id = $postId";
                                    $allCommentsQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

                                    while($row = mysqli_fetch_assoc($allCommentsQuery)){
                                        $commentAuthor = $row["comment_author"];
                                        $commentDate = $row["comment_date"];
                                        $commentContent = $row["comment_content"];
                                ?>

                                <div class="d-flex flex-row comment-row py-3 px-2">
                                    <div class="p-2">
                                        <img src="profile.png" alt="user_profile" width="40">
                                    </div>
                                    <div class="w-100">
                                        <h6 class="text-danger"><?php echo $commentAuthor;?>  <small class="text-secondary"><?php echo $commentDate; ?></small></h6>
                                        <span class="m-b-15 d-block"><?php echo $commentContent; ?></span>
                                        <div class="comment-footer mt-1">
                                            <?php
                                                if(isset($_SESSION["user_role"])){
                                                    if($_SESSION["user_role"]=="Admin"){
                                                        echo "<button type='button' class='btn btn-warning btn-sm'>Edit</button> ";
                                                        echo "<button type='button' class='btn btn-success btn-sm'>Publish</button> ";
                                                        echo "<button type='button' class='btn btn-danger btn-sm'>Delete</button> ";
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div> 
                                <?php
                                    }
                                ?>
                
                            </div>

                            <!-- add comment php -->
                            <?php
                                if(isset($_POST["leave_comment"])){
                                    if(isset($_SESSION["username"])){
                                        $commentAuthor = $_SESSION["username"];
                                        $commentPostId = $postId;
                                        $commentEmail = $_SESSION["user_email"];
                                        $commentContent = mysqli_real_escape_string($connection,$_POST["comment_content"]);
                                        
                                        $query = "INSERT INTO comments(comment_author, comment_post_id, comment_email, comment_date, comment_content) ";
                                        $query .= "VALUES('$commentAuthor', $commentPostId, '$commentEmail', now(), '$commentContent')";

                                        $addCommentQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

                                        header("Location: post.php?post_id=$postId");
                                    }else{
                                        echo "<p>You must be logged in to comment!</p>";
                                    }
                                }
                            ?>

                        </div>
                        
                        
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