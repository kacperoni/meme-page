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
                <li class="bi bi-image"> 0/0</li>
                <li class="bi bi-chat-right-text"> 0</li>
            </ul>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-6 bg-dark text-center">
        My profile
    </div>
    <div class="col-6 bg-dark text-center">
        Settings
    </div>
    
</div>