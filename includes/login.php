<form action="" method="POST">
    <div class="input-group mb-2">
        <input type="text" name="username" class="form-control bg-dark border-dark text-secondary" placeholder="Enter username">
    </div>
    <div class="input-group mb-2">
        <input type="password" name="password" class="form-control bg-dark border-dark text-secondary" placeholder="Password">
    </div>
    <div class="input-group mb-2">
        <input type="submit" name="login" class="btn btn-danger form-control" value="Login">
    </div>
</form>
<?php
    if(isset($_POST["login"])){
        $username = mysqli_real_escape_string($connection, $_POST["username"]);
        $password = mysqli_real_escape_string($connection, $_POST["password"]);

        $query = "SELECT user_password,username FROM users WHERE username = '$username'";
        $selectUserPasswordQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
        $row = mysqli_fetch_row($selectUserPasswordQuery);
        if(empty($row)) echo "Invalid username or password!";
        else{
            $userPassword = $row[0];
            $userUsername = $row[1];
            if($username === $userUsername and password_verify($password,$userPassword) ){
                $query = "SELECT * from users WHERE username = '$username'";
                $selectUserQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                while($row = mysqli_fetch_assoc($selectUserQuery)){
                    $userId = $row["user_id"];
                    $userRole = $row["user_role"];
                    $userEmail = $row["user_email"];
                    $userProfilePic = $row["user_image"];
                }
                
                session_start();
                $_SESSION["username"]=$username;
                $_SESSION["user_id"]= $userId;
                $_SESSION["user_role"] = $userRole;
                $_SESSION["user_email"] = $userEmail;
                if(empty($userProfilePic) or $userProfilePic === NULL){
                    $_SESSION["user_profile_pic"] = "profile.png";
                }else{
                    $_SESSION["user_profile_pic"] = $userProfilePic;
                }
                

                header("Location: index.php");
            }else{
                echo "Invalid username or password, try again!";
            }
        }
    }
?>
<div class="row">
    <div class="col-md"><a class="text-secondary" href="index.php?source=forgotPass">Forgot password</a></div>
    <div class="col-md text-end"><a class="text-white" href="index.php?source=register">Register</a></div>  
</div>