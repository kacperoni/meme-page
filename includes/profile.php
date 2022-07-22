<div class="row">
    <div class="col-5 p-0">
        <img class="img-fluid" src="profile.png" width="100" alt="profile_pic">
    </div>
    <div class="col-7">
        <div class="row bg-dark">
            <div class="col-10">
                <?php echo $_SESSION["username"]; ?>
            </div>
            <div class="col-2">
                <a class="bi bi-box-arrow-right text-white" href="includes/logout.php"></a>
            </div>
        </div>
        <div class="row">
            <ul class="mt-2" style="list-style-type:none;">
                <?php
                $userId = $_SESSION['user_id'];
                    $query = "SELECT * FROM posts WHERE post_author_id = $userId";
                    $allUserPostsQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                    $numOfPosts = mysqli_num_rows($allUserPostsQuery);

                    $query = "SELECT * FROM posts WHERE post_author_id = $userId AND post_status = 'Published'";
                    $allUserPublishedPostsQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                    $numOfPublishedPosts = mysqli_num_rows($allUserPublishedPostsQuery);

                ?>
                <li class="bi bi-image"> <?php echo $numOfPublishedPosts."/".$numOfPosts; ?></li>
                <li class="bi bi-chat-right-text"> 0</li>
            </ul>
        </div>
    </div>
</div>

<div class="row mt-2">
    <a href="#" id="menu" class='col-4 bg-dark text-center'>My profile</a>
    <a href="#" class='col-4 bg-dark text-center'>Settings</a>
    <a href="#" class='col-4 bg-dark text-center'>Favorites</a>
</div>