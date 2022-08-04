<?php
    if(isset($_POST['data'])){
        $postId = $_POST['data'];
        $query = "UPDATE posts SET ";
        $query .= "post_likes_counter = post_likes_counter+1 ";
        $query .= "WHERE post_id = $postId";

        $addLikeQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
        echo "like";
    }
?>