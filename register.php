<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>

<body background="img/Background2.svg">
    <div class="container">
        <div class="login-box">
            <div class="logo">
                <img src="img/Logo.svg" alt="Design Mart Logo">
            </div>
            <div class="inputan">
                <h2>Create Account</h2>
                <p>Join Now, Sell Your Designs, Earn More!</p>
            </div>
            <form action="#" method="post">

                <div class="input-group">
                    <img src="assets/profile.svg" alt="email">
                    <input type="text" name="username" placeholder="Username" required>
                </div>

                <div class="input-group">
                    <img src="assets/Email.svg" alt="Email Icon">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <img src="assets/Password.svg" alt="">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="show-password"></span>
                </div>

                <button type="submit" class="btn-sign-up">Sign Up</button>
                <div class="sign-in-my-account">
                    <a href="login.php"><b>Sign In to My Account</b></a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>