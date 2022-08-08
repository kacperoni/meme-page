<?php include "header.php"; ?>
<?php session_start(); ?>
    <body class="text-white bg-color">

        <!-- Navbar -->
        <?php include "navigation.php"; ?>

        <div class="container pt-5">
            <div class="row">
                <!-- left -->
                <div class="col-md-8">
                    <div class="container">
                        <div class="container px-5 pt-5">
                            <div class="tile-color p-5">
                                <h2>User Information</h2>
                                <!-- get user info -->
                                <?php
                                    $userId = $_SESSION["user_id"];

                                    $query = "SELECT * FROM users WHERE user_id = $userId";
                                    $selectUserQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

                                    while($row = mysqli_fetch_assoc($selectUserQuery)){
                                        $userFirstname = $row["user_firstname"];
                                        $userGender = $row["user_gender"];
                                        $userCountry = $row["user_country"];
                                        $userCity = $row["user_city"];
                                        $userBirthdate = $row["user_birthdate"];
                                        $userProfilePic = $row["user_image"];

                                        if(empty($userProfilePic) or $userProfilePic === NULL){
                                            $userProfilePic = "profile.png";
                                        }
                                    }
                                ?>
                                <form action="" method="POST">
                                    <div class="input-group mb-2">
                                        <input type="text" name="first_name" class="form-control bg-dark border-dark text-secondary" placeholder="First name" value="<?php echo $userFirstname; ?>">
                                    </div>
                                    <div class="input-group mb-2">
                                        <select name="gender" class="form-control bg-dark border-dark text-secondary">
                                            <?php
                                                if(!$userGender){
                                                    echo "<option value=''>Select Gender</option>";
                                                }
                                            ?>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="text" name="country" class="form-control bg-dark border-dark text-secondary" placeholder="Country" value="<?php echo $userCountry; ?>">
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="text" name="city" class="form-control bg-dark border-dark text-secondary" placeholder="City" value="<?php echo $userCity; ?>">
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="text" onfocus="(this.type='date')" name="birth_date" class="form-control bg-dark border-dark text-secondary" placeholder="Date of birth" value="<?php echo $userBirthdate; ?>">
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="submit" name="submit" class="btn btn-danger w-100" value="Save">
                                    </div>
                                </form>
                                <!-- update user info -->
                                <?php
                                    if(isset($_POST["submit"])){
                                        $userFirstname = $_POST["first_name"];
                                        $userGender = $_POST["gender"];
                                        $userCountry = $_POST["country"];
                                        $userCity = $_POST["city"];
                                        $userBirthdate = $_POST["birth_date"];
                                        if(empty($userBirthdate)){
                                            $query = "UPDATE users SET user_firstname = '$userFirstname', user_gender = '$userGender', user_country = '$userCountry', ";
                                            $query .= "user_city = '$userCity' WHERE user_id = $userId";
    
                                            $updateUserInfoQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
    
                                            header("Location: settings.php");
                                        }else{
                                            $query = "UPDATE users SET user_firstname = '$userFirstname', user_gender = '$userGender', user_country = '$userCountry', ";
                                            $query .= "user_city = '$userCity', user_birthdate = '$userBirthdate' WHERE user_id = $userId";

                                            $updateUserInfoQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

                                            header("Location: settings.php");
                                        }
                                    }
                                ?>
                                <hr>
                                <h2>Avatar</h2>
                                <div class="text-center">
                                    <img src="<?php echo 'images/avatars/'.$userProfilePic;?>" alt="profile_pic" width="200" class="mb-2">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="input-group mb-2">
                                            <input type="file" name="profile_pic"class="form-control bg-dark border-dark text-secondary">
                                        </div>
                                        <div class="input-group mb-2">
                                            <input type="submit" name="upload" class="btn btn-danger w-100" value="Save">
                                        </div>
                                    </form>
                                </div>
                                <!-- upload profile pics -->
                                <?php
                                    if(isset($_POST["upload"])){
                                        $profilePic = $_FILES["profile_pic"]["name"];
                                        $profilePicTmp = $_FILES["profile_pic"]["tmp_name"];
                                        
                                        move_uploaded_file($profilePicTmp,"images/avatars/$profilePic");
                                        $_SESSION["user_profile_pic"]=$profilePic;

                                        $query = "UPDATE users SET user_image = '$profilePic' WHERE user_id = $userId";
                                        $uploadProfilePicQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

                                        header("Location: settings.php");
                                    }
                                ?>
                                <hr>
                                <h2>Password</h2>
                                <form action="" method="POST">
                                    <div class="input-group mb-2">
                                        <input type="text" name="user_password" class="form-control bg-dark border-dark text-secondary" placeholder="Current password">
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="text" name="new_password" class="form-control bg-dark border-dark text-secondary" placeholder="New password">
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="text" name="new_password2" class="form-control bg-dark border-dark text-secondary" placeholder="Repeat password">
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="submit" name="change_password" class="btn btn-danger w-100" value="Save">
                                    </div>
                                </form>
                                <!-- changing password -->
                                <?php
                                    if(isset($_POST["change_password"])){
                                        $userId = $_SESSION["user_id"];
                                        $currentPassword = $_POST["user_password"];
                                        $newPassword1 = $_POST["new_password"];
                                        $newPassword2 = $_POST["new_password2"];

                                        $query = "SELECT user_password FROM users WHERE user_id = $userId";
                                        $selectUserPassword = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                        $row = mysqli_fetch_row($selectUserPassword);
                                        $userPassword = $row[0];

                                        if($newPassword1 === $newPassword2 and password_verify($currentPassword,$userPassword)){
                                            $newPassword = password_hash($newPassword1,PASSWORD_BCRYPT,array('cost'=>12));
                                            $query = "UPDATE users SET user_password ='$newPassword' WHERE user_id = $userId";
                                            $changePasswordQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                                            echo "<h3>Password has been changed!<h3>";
                                        }else if(!password_verify($currentPassword, $userPassword)){
                                            echo "<h3>Wrong password! Please try again.</h3>";
                                        }else if($newPassword1 !== $newPassword2){
                                            echo "<h3>New passwords didn't match! Please try again.</h3>";
                                        }
                                    }
                                ?>
                                <hr>
                                <h2>Delete account</h2>
                                <div class="text-center">
                                    <p>If you want to delete your account click <a href="#" class="text-danger">here</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript" src="js/likes.js"></script>

                <!-- right -->
                <div class="col-md-4 p-5">
                    <div class="container tile-color p-4">

                        <?php
                            if(isset($_SESSION["username"])){
                                include "includes/profile.php";

                            }else{

                                if(isset($_GET["source"])){
                                    $source = $_GET["source"];
    
                                    switch($source){
                                        case "register":
                                            include "includes/register.php";
                                            break;
                                        case "forgotPass":
                                            include "includes/forgot_password.php";
                                            break;
                                    }
                                }else{
                                    include "includes/login.php";
                                }
                            }
                
                        ?>
                    </div>
                    <div class="container p-4 mt-3 tile-color">
                            <p>Recommend</p>
                    </div>
                </div>
            </div>
            
        </div>

        
<!-- footer -->
<?php include "footer.php"; ?>