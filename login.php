<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design Mart - Sign In</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>

<body background="img/Background2.svg">
    <div class="container">
        <div class="login-box">
            <div class="logo">
                <img src="img/Logo.svg" alt="Design Mart Logo">
            </div>
            <div class="inputan">
                <h2>Welcome Back!</h2>
                <p>Please input your details information.</p>
            </div>
            <form action="login-proses.php" method="post">

                <div class="input-group">
                    <img src="assets/Email.svg" alt="Email Icon">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>

                <div class="input-group">
                    <img src="assets/Password.svg" alt="">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="show-password"></span>
                </div>

                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit" class="btn">Sign In</button>
                <div class="create-account">
                    <a href="register.php"><b>Create New Account</b></a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>