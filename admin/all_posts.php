<?php include "includes/admin_header.php"; ?>
        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>
        <div class="my-container">
            <div class="tile-color text-end">
            <p class="p-3"><a href="../includes/logout.php" class="text-secondary logout-link"><?php echo $_SESSION["username"]; ?>  <span class="bi bi-box-arrow-right"></span></p></a>
            </div>
            <div class="container text-white">
                    <div class="card bg-dark">
                        <div class="card-header d-flex">
                            <div class="col-1">Picture</div>
                            <div class="col-1">ID</div>
                            <div class="col-2">Title</div>
                            <div class="col-2">Author</div>
                            <div class="col-1">Category</div>
                            <div class="col-2">Date</div>
                            <div class="col-1">Status</div>
                        </div>
                        <!-- image modal -->
                        <?php include "includes/image_modal.php"; ?>
                        <ul class="list-group">
                <?php
                    $query = "SELECT * FROM posts ORDER BY post_date DESC";
                    $allUsersQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

                    while($row=mysqli_fetch_assoc($allUsersQuery)):
                        $postId = $row["post_id"];
                        $postTitle = $row["post_title"];
                        $postCategoryId = $row["post_category_id"];
                        $selectCategoryQuery = mysqli_query($connection,"SELECT cat_title FROM categories WHERE cat_id = $postCategoryId")
                        or die("SQL Error :: ".mysqli_error($connection));
                        $postCategory = mysqli_fetch_row($selectCategoryQuery)[0];
                        $postImage = $row["post_image"];
                        $postStatus = $row["post_status"];
                        $postDate = date_format(date_create($row["post_date"]),' Y-m-d');
                        $postAuthorId = $row["post_author_id"];
                        $selectAuthorQuery = mysqli_query($connection, "SELECT username FROM users WHERE user_id = $postAuthorId")
                        or die("SQL Error :: ".mysqli_error($connection));
                        $postAuthor = mysqli_fetch_row($selectAuthorQuery)[0];
                        
                ?>
                <li class="list-group-item d-flex bg-dark text-white">
                    <div class="col-1">
                            <img class="rounded-circle post-image-modal" src="../images/<?php echo $postImage; ?>" alt="post_pic" width="50">
                    </div>
                    <div class="col-1"><?php echo $postId; ?></div>
                    <div class="col-2"><?php echo $postTitle; ?></div>
                    <div class="col-2"><?php echo $postAuthor; ?></div>
                    <div class="col-1"><?php echo $postCategory; ?></div>
                    <div class="col-2"><?php echo $postDate; ?></div>
                    <div class="col-1"><?php echo $postStatus; ?></div>
                    <div class="col-3">
                        <a href="all_posts.php?postIdToDelete=<?php echo $postId; ?>"><button class="btn btn-danger">X</button></a>
                        <?php if($postStatus == "Draft"): ?>
                        <a href="all_posts.php?postIdToAccept=<?php echo $postId; ?>"><button class="btn btn-success">&#x2713;</button></a>
                        <?php elseif($postStatus == "Published"): ?>
                        <a href="all_posts.php?postIdToDraft=<?php echo $postId; ?>"><button class="btn btn-warning">&#9660;</button></a>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endwhile; ?>
                    </ul>
                    </div>
                <?php
                    if(isset($_GET["postIdToDelete"])){
                        $postId = mysqli_real_escape_string($connection,$_GET["postIdToDelete"]);
                        $query = "DELETE FROM posts WHERE post_id = $postId";
                        $deletePostQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                        header("Location: all_posts.php");
                    }

                    if(isset($_GET["postIdToAccept"])){
                        $postId = mysqli_real_escape_string($connection,$_GET["postIdToAccept"]);
                        $query = "UPDATE posts SET post_status = 'Published' WHERE post_id = $postId";
                        $publishPostQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                        header("Location: all_posts.php");
                    }

                    if(isset($_GET["postIdToDraft"])){
                        $postId = mysqli_real_escape_string($connection,$_GET["postIdToDraft"]);
                        $query = "UPDATE posts SET post_status = 'Draft' WHERE post_id = $postId";
                        $publishPostQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                        header("Location: all_posts.php");
                    }
                ?>
            </div>
        </div>
<?php include "includes/admin_footer.php"; ?>
<script>
    $(document).ready(function(){
        $(".post-image-modal").click(function(){
            var image = $(this).attr('src');
            $('#imagepreview').attr('src', image); // here asign the image to the modal when the user click the enlarge link
            $('#postImageModal').modal('show');
        });
    });
</script>