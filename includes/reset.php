<?php
    if(!isset($_GET["email"])|| !isset($_GET["token"])){
        header("Location: index.php");
    }
    $message="";
    $getEmail = mysqli_real_escape_string($connection,$_GET["email"]);
    $getToken = mysqli_real_escape_string($connection,$_GET["token"]);
    if($stmt = mysqli_prepare($connection,"SELECT username,user_email,user_token FROM users WHERE user_email = ?")){
        mysqli_stmt_bind_param($stmt,'s', $getEmail);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$username,$email,$token);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if($getEmail!==$email || $getToken!==$token){
            header("Location: index.php");
        }
    }

    if(isset($_POST["submit"])){
        if(strlen($_POST["password1"])==0 && strlen($_POST["password1"])==0) $message="Fields cannot be empty!";
        else if($_POST["password1"]!==$_POST["password2"]) $message="Passwords are not the same!";
        else if(strlen($_POST["password1"])<4) $message="Password should be at least 4 characters!";
        else{
            $password = mysqli_real_escape_string($connection, $_POST["password1"]);

            $passwordHashed = password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));

            if($stmt = mysqli_prepare($connection,"UPDATE users SET user_password='$passwordHashed', user_token='' WHERE user_email = ?")){
                mysqli_stmt_bind_param($stmt,'s',$getEmail);
                mysqli_stmt_execute($stmt);
                if(mysqli_stmt_affected_rows($stmt)>0) header("Location: index.php?reset=1");
            }
        }
    }
?>
<form action="" method="POST">
    <div class="input-group mb-2">
        <input name="password1" type="password" class="form-control bg-dark border-dark text-secondary" placeholder="New password">
    </div>
    <div class="input-group mb-2">
        <input name="password2" type="password" class="form-control bg-dark border-dark text-secondary" placeholder="Confirm password">
    </div>
    <div class="input-group mb-2">
        <input name="submit" type="submit" class="btn btn-danger form-control" value="Reset password">
    </div>
</form>
<?php echo $message ? $message: ""; ?>
<div class="row">
    <div class="col-md"><a class="text-secondary" href="index.php?source=register">Register</a></div>
    <div class="col-md text-end"><a class="text-white" href="index.php">Login</a></div>  
</div>