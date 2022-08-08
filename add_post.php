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
                        <div class="container p-5">
                            <div class="row tile-color m-0 p-0">
                                <div class="col">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                    
                                        <div class="input-group my-2">
                                            <input type="text" name="postTitle" class="form-control bg-dark border-dark text-secondary" placeholder="Title">
                                        </div>

                                        <div class="input-group my-2">
                                            <input type="file" name="postImage" class="form-control bg-dark border-dark text-secondary" value="Choose image">
                                        </div>

                                        <div class="input-group my-2">
                                            <textarea name="postContent" class="form-control bg-dark border-dark text-secondary" cols="30" rows="10" placeholder="Content (Optional)"></textarea>
                                        </div>

                                        <div class="my-2">
                                            <?php
                                                $query = "SELECT * FROM categories";
                                                $allCategoriesQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

                                                while($row = mysqli_fetch_assoc($allCategoriesQuery)){
                                                    $catId = $row["cat_id"];
                                                    $catTitle = $row["cat_title"];
                                            ?>

                                            <input type="radio" class="btn-check" name="postCategories" id="<?php echo 'cat'.$catId; ?>" value="<?php echo $catId; ?>" autocomplete="off">
                                            <label class="btn btn-dark" for="<?php echo 'cat'.$catId; ?>"><?php echo $catTitle; ?></label>

                                            <?php
                                                }
                                            ?>
                                            <div class="my-2 text-center">
                                                <input type="submit" class="btn btn-danger mx-3 w-25" name="add" value="Add post">
                                                <a href="index.php" class="btn btn-dark mx-3 w-25">Cancel</a>
                                            </div>
                                        </div>
                                    </form>
                                    <?php
                                        if(isset($_POST["add"])){
                                            $postTitle = $_POST["postTitle"];
                                            $postContent = $_POST["postContent"];
                                            $postAuthorId = $_SESSION["user_id"];
                                            $postImage = $_FILES["postImage"]["name"];
                                            $postImageTmp = $_FILES["postImage"]["tmp_name"];
                                            $postDate = date('d-m-y');

                                            if(!empty($postTitle)){
                                                $postCatId = $_POST["postCategories"];

                                            move_uploaded_file($postImageTmp, "images/$postImage");
                                            
                                            $query = "INSERT INTO posts (post_title,post_author_id,post_date,post_image,post_content,post_category_id) ";
                                            $query .= "VALUES ('$postTitle', $postAuthorId, now() ,'$postImage', '$postContent', $postCatId);";
                                            
                                            $insertPostQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                            }else{
                                                echo "<div class='text-danger text-center'>Fill up the fields!</div>";
                                            }
                                            
                                        } 
                                    ?>
                                </div>
                            </div>
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