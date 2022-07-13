<?php include "header.php"; ?>
    <body class="text-white bg-color">

        <!-- Navbar -->
        <?php include "navigation.php"; ?>

        <div class="container">
            <div class="row">
                <!-- left -->
                <div class="col-md-8">
                    <div class="container">
                        <?php
                            $query = "SELECT * FROM posts";
                            $allPostsQuery = mysqli_query($connection,$query);

                            if(!$allPostsQuery) die("QUERY FAILED ".mysqli_error($connection));

                            while($row=mysqli_fetch_assoc($allPostsQuery)){
                                $postTitle = $row["post_title"];
                                $postDate = $row["post_date"];
                                $postImage = $row["post_image"];
                                $postCategoryId = $row["post_category_id"];
                        ?>

                        <div class="container p-5">
                            <div class="container tile-color d-flex p-0">
                                <img src="profile.png" width="50" alt="profile-pic">
                                <p class="m-2"><?php echo $postTitle; ?></p>
                                <!-- <p class="text-end">1</p> -->
                            </div>
                            <p class="px-3 py-1 mt-2 mb-0 tile-color"><?php echo $postDate; ?> Category: <?php echo $postCategoryId; ?></p>
                            <img src="images/<?php echo $postImage; ?>" width="100%" alt="meme">
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- right -->
                <div class="col-md-4 p-5">
                    <div class="container tile-color p-4">
                        <!-- login form -->
                        <form action="">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control bg-dark border-dark" placeholder="Enter username or email">
                            </div>
                            <div class="input-group mb-2">
                                <input type="password" class="form-control bg-dark border-dark" placeholder="Password">
                            </div>
                            <div class="input-group mb-2">
                                <input type="submit" class="btn btn-danger form-control" value="Login">
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md">Forgot password</div>
                            <div class="col-md text-end">Register</div>  
                        </div>
                    </div>
                    <div class="container p-4 mt-3 tile-color">
                            <p>Recommend</p>
                    </div>
                </div>
            </div>
        </div>
<!-- footer -->
<?php include "footer.php"; ?>