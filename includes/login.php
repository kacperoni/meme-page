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

        $query = "SELECT user_password FROM users WHERE username = '$username'";
        $selectUserPasswordQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
        $row = mysqli_fetch_row($selectUserPasswordQuery);
        if(empty($row)) echo "Username doesn't exist!";
        else{
            $userPassword = $row[0];
            $password = crypt($password, $userPassword);
            if(!hash_equals($userPassword, $password)) echo "Invalid password, try again!";
            else{
                $query = "SELECT * from users WHERE username = '$username'";
                $selectUserQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));
                while($row = mysqli_fetch_assoc($selectUserQuery)){
                    $userId = $row["user_id"];
                }
                
                session_start();
                $_SESSION["username"]=$username;
                $_SESSION["user_id"]= $userId;
                

                header("Location: index.php");
            }
        }
    }
?>
<div class="row">
    <div class="col-md"><a class="text-secondary" href="index.php?source=forgotPass">Forgot password</a></div>
    <div class="col-md text-end"><a class="text-white" href="index.php?source=register">Register</a></div>  
</div>