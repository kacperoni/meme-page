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
                            <div class="col-1">Avatar</div>
                            <div class="col-1">ID</div>
                            <div class="col-2">Username</div>
                            <div class="col-2">E-mail</div>
                            <div class="col-1">Role</div>
                            <div class="col-1">Status</div>
                            <div class="col-1">Ban/Unban</div>
                        </div>
                        <ul class="list-group">
                <?php
                    $query = "SELECT * FROM users";
                    $allUsersQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

                    while($row=mysqli_fetch_assoc($allUsersQuery)):
                        $userId = $row["user_id"];
                        $username = $row["username"];
                        $userEmail = $row["user_email"];
                        $userImage = $row["user_image"] ? $row["user_image"]:"profile.png";
                        $userRole = $row["user_role"];
                        $userBanned = $row["user_banned"] ? $row["user_banned"]:"Active";
                        
                ?>
                <li class="list-group-item d-flex bg-dark text-white">
                    <div class="col-1"><img class="rounded-circle"src="../images/avatars/<?php echo $userImage; ?>" alt="profile_pic" width="50"></div>
                    <div class="col-1"><?php echo $userId; ?></div>
                    <div class="col-2"><?php echo $username; ?></div>
                    <div class="col-2"><?php echo $userEmail; ?></div>
                    <div class="col-1"><?php echo $userRole; ?></div>
                    <div class="col-1"><?php echo $userBanned; ?></div>
                    <div class="col-1">
                        <?php if($userBanned=="Banned"):?>
                        <a href="../admin/users.php?userIdToUnban=<?php echo $userId; ?>"><button class="btn btn-success">Unban</button></a>
                        <?php else: ?>
                        <a href="../admin/users.php?userIdToBan=<?php echo $userId; ?>"><button class="btn btn-danger">Ban</button></a>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endwhile; ?>
                    </ul>
                    </div>
            </div>
        </div>
        <?php 
            if(isset($_GET["userIdToBan"])){
                $userIdToBan = mysqli_real_escape_string($connection,$_GET["userIdToBan"]);
                $query = "UPDATE users SET user_banned = 'Banned' WHERE user_id = $userIdToBan";
                $banUserQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                header("Location: users.php");
            }
            
            if(isset($_GET["userIdToUnban"])){
                echo "halo";
                $userIdToUnban = mysqli_real_escape_string($connection, $_GET["userIdToUnban"]);
                $query = "UPDATE users SET user_banned = '' WHERE user_id = $userIdToUnban";
                $unbanUserQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                header("Location: users.php");
            }
        ?>
<?php include "includes/admin_footer.php"; ?>