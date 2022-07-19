<nav class="navbar navbar-dark p-2 navbar-expand-lg tile-color">
<div class="container">
    <a class="bi bi-tsunami navbar-brand" href="index.php"> Memes</a>
    <div class="d-flex">
        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="pending.php" class="nav-link">Pending</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Random</a>
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
</div>
</nav>