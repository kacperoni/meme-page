<?php
    $query = "SELECT post_id FROM posts WHERE post_status = 'Published'";
    $allPostIdQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
    $allIds = array();

    while($row = mysqli_fetch_assoc($allPostIdQuery)){
        $allIds[]=$row['post_id'];
    }

    $countOfPosts = count($allIds);
    $randIndex = rand(0,$countOfPosts-1);

    $randomPostId = $allIds[$randIndex];
?>

<nav class="navbar navbar-dark p-2 navbar-expand-md tile-color fixed-top justify-content-center">
    <div class="container-fluid px-5">
        <a class="bi bi-tsunami navbar-brand px-5 text-danger" href="index.php"> Memes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mx-5">
                <li class="nav-item">
                    <a href="pending.php" class="nav-link">Pending</a>
                </li>
                <li class="nav-item">
                    <a href="post.php?post_id=<?php echo $randomPostId; ?>" class="nav-link">Random</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <?php
                            $query = "SELECT * FROM categories";
                            $allCategoriesQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

                            while($row = mysqli_fetch_assoc($allCategoriesQuery)){
                                $catId = $row["cat_id"];
                                $catTitle = $row["cat_title"];
                                echo "<li><a class='dropdown-item' href='index.php?category=$catId'>$catTitle</a></li>";
                            }

                        ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>