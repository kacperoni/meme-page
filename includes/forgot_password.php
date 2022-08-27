<?php use PHPMailer\PHPMailer\PHPMailer; ?>
<?php
    require "./vendor/autoload.php";
    $message="";
    if(isset($_POST["submit"])){
        $email = mysqli_real_escape_string($connection, $_POST["email"]);
        $query = "SELECT user_id FROM users WHERE user_email = '$email'";
        $checkEmailQuery = mysqli_query($connection,$query) or die("SQL Error :: ".mysqli_error($connection));

        if(mysqli_num_rows($checkEmailQuery)>=1){
            $length = 50;
            $token = bin2hex(openssl_random_pseudo_bytes($length));
            if($stmt=mysqli_prepare($connection,"UPDATE users SET user_token = '$token' WHERE user_email = ?")){
                mysqli_stmt_bind_param($stmt,'s',$email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                /**
                 * Configure PHPMAILER
                 */

                $mail = new PHPMailer();
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                         //Enable verbose debug output
                $mail->isSMTP();                                               //Send using SMTP
                $mail->SMTPAuth   = true;                                      //Enable SMTP authentication
                $mail->Host       = Smtpconfig::SMTP_HOST;                         //Set the SMTP server to send through
                $mail->Username   = Smtpconfig::SMTP_USER;                         //SMTP username
                $mail->Password   = Smtpconfig::SMTP_PASSWORD;                     //SMTP password
                $mail->Port       = Smtpconfig::SMTP_PORT;                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';

                $mail->setFrom('kacperkubacki@cms.com', 'Kacper Kubacki');
                $mail->addAddress($email);
                $mail->Subject = "Meme-page Reset Your Password!";
                $mail->Body = "<p>Please click this link to reset your password:
                <a href='http://localhost/meme-page/index.php?source=resetPass&email=$email&token=$token'>http://localhost/meme-page/index.php?source=resetPass&email=$email&token=$token</a>
                </p>";

                $message = $mail->send() ? "Please check your e-mail!":"Something went wrong! Try again!";
            }
            
        }else{
            $message="There is no account using this e-mail!";
        }
    }
?>
<form action="" method="POST">
    <div class="input-group mb-2">
        <input name="email" type="email" class="form-control bg-dark border-dark text-secondary" placeholder="E-mail">
    </div>
    <div class="input-group mb-2">
        <input name="submit" type="submit" class="btn btn-danger form-control" value="Reset password">
    </div>
</form>
<?php echo $message ? $message:""; ?>
<div class="row">
    <div class="col-md"><a class="text-secondary" href="index.php?source=register">Register</a></div>
    <div class="col-md text-end"><a class="text-white" href="index.php">Login</a></div>  
</div>