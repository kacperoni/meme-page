<form action="" method="POST">
    <div class="input-group mb-2">
        <input type="text" name="username" class="form-control bg-dark border-dark text-secondary" placeholder="Username">
    </div>
    <div class="input-group mb-2">
        <input type="email" name="email" class="form-control bg-dark border-dark text-secondary" placeholder="Email">
    </div>
    <div class="input-group mb-2">
        <input type="password" name="password1" class="form-control bg-dark border-dark text-secondary" placeholder="Password">
    </div>
    <div class="input-group mb-2">
        <input type="password" name="password2" class="form-control bg-dark border-dark text-secondary" placeholder="Confirm password">
    </div>
    <div class="input-group mb-2">
        <input type="submit" name="register" class="btn btn-danger form-control" value="Register">
    </div>
</form>

<?php
    if(isset($_POST["register"])){
        $username = mysqli_real_escape_string($connection,$_POST["username"]);
        $email = mysqli_real_escape_string($connection, $_POST["email"]);
        $password1 = mysqli_real_escape_string($connection, $_POST["password1"]);
        $password2 = mysqli_real_escape_string($connection, $_POST["password2"]);

        if(empty($username)||empty($email)||empty($password1)||empty($password2)){
            echo "Fields cannot be empty!";
        }
        else if($password1 !== $password2){
            echo "Password doesn't match!";
        }
        else{
            $query = "SELECT user_randSalt FROM users";
            $selectRandsaltQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
            $row = mysqli_fetch_assoc($selectRandsaltQuery);
            $randSalt = $row['user_randSalt'];

            $password = crypt($password1,$randSalt);

            $query = "INSERT INTO users (username, user_email, user_password)";
            $query .= "VALUES ('$username', '$email', '$password')";

            $insertUserQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

            echo "Thank you for registration!";
            
        }
    }
?>

<div class="row">
    <div class="col-md"><a class="text-secondary" href="index.php?source=forgotPass">Forgot password</a></div>
    <div class="col-md text-end"><a class="text-white" href="index.php">Login</a></div>  
</div>

