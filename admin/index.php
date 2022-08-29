<?php include "includes/admin_header.php"; ?>
        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>
        <div class="my-container">
            <div class="tile-color text-end">
            <p class="p-3"><a href="../includes/logout.php" class="text-secondary logout-link"><?php echo $_SESSION["username"]; ?>  <span class="bi bi-box-arrow-right"></span></p></a>
            </div>
            <div class="container">
                <!-- MAIN -->
                Main
            </div>
        </div>
<?php include "includes/admin_footer.php"; ?>