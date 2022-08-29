<?php include "includes/admin_header.php"; ?>
        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>
        <div class="my-container">
            <div class="tile-color text-end">
            <p class="p-3"><a href="../includes/logout.php" class="text-secondary logout-link"><?php echo $_SESSION["username"]; ?>  <span class="bi bi-box-arrow-right"></span></p></a>
            </div>
            <div class="container text-white">
                <!-- MAIN -->
                <h1>Categories</h1>
                <hr>
                <div class="row">
                    <div class="col">
                        <?php if(!isset($_GET["categoryToChange"])): ?>
                        <h5>Add Category</h5>
                        <form action="" method="POST">
                            <div class="form-group">
                                <input type="text" name="catTitle" class="form-control text-secondary bg-dark border-dark" placeholder="New Category Title"autocomplete="off">
                            </div>
                            <div class="form-group mt-3">
                                <input type="submit" class="btn btn-danger" name="addCategory" value="Add new">
                            </div>
                        </form>
                        <?php else: ?>
                        <h5>Edit Category</h5>
                        <?php
                            $catId = mysqli_real_escape_string($connection,$_GET["categoryToChange"]);
                            $query = "SELECT cat_title FROM categories WHERE cat_id = $catId";
                            $catTitleQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                            $row = mysqli_fetch_row($catTitleQuery);
                        ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <input type="text" name="newCatTitle" class="form-control text-secondary bg-dark border-dark" value="<?php echo $row[0];?>" autocomplete="off">
                            </div>
                            <div class="form-group mt-3">
                                <input type="submit" class="btn btn-danger" name="editCategory" value="Edit">
                            </div>
                        </form>
                        <?php endif; ?>
                        <?php
                            if(isset($_POST["addCategory"])){
                                $catTitle = mysqli_real_escape_string($connection,$_POST["catTitle"]);
                                $query = "INSERT INTO categories (cat_title) VALUES ('$catTitle')";
                                $addCatQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                header("Location: categories.php");
                            }

                            if(isset($_POST["editCategory"])){
                                $newCatTitle = mysqli_real_escape_string($connection,$_POST["newCatTitle"]);
                                $query = "UPDATE categories SET cat_title = '$newCatTitle' WHERE cat_id = $catId";
                                $editCatQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                header("Location: categories.php");
                            }
                        ?>
                    </div>
                    <div class="col">
                        <h5>All Categories</h5>
                        <?php
                            $query = "SELECT * FROM categories ORDER BY cat_title ASC";
                            $allCategoriesQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_errno($connection));
                            while($row=mysqli_fetch_assoc($allCategoriesQuery)):
                        ?>
                        <ul class="list-group">
                            <li class="list-group-item bg-dark text-secondary d-flex justify-content-between align-items-center mb-1"><?php echo $row["cat_title"]; ?>
                            <div class='d-flex flex-row-reverse'>
                                <a href='categories.php?categoryToDelete=<?php echo $row['cat_id']; ?>'><span class='bi bi-x-square-fill text-danger mx-2'></span></a>
                                <a href='categories.php?categoryToChange=<?php echo $row['cat_id']; ?>'><span class='bi bi-pencil-square text-warning'></span></a>
                            </div>
                            </li>
                        </ul>
                        <?php endwhile; ?>
                        <?php
                            if(isset($_GET["categoryToDelete"])){
                                $catId = mysqli_real_escape_string($connection,$_GET["categoryToDelete"]);
                                $query = "DELETE FROM categories WHERE cat_id = $catId";
                                mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_errno($connection));
                                header("Location: categories.php");
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
<?php include "includes/admin_footer.php"; ?>