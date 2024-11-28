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

            <form method="POST" action="register-proses.php" enctype="multipart/form-data">
                <!-- Avatar Upload -->
                <div class="input-group">
                    <label for="avatar"></label>
                    <input type="file" name="avatar" id="avatar" required>
                </div>

                <!-- Username -->
                <div class="input-group">
                    <img src="assets/profile.svg" alt="Username Icon">
                    <input type="text" name="username" placeholder="Username" required>
                </div>

                <!-- Email -->
                <div class="input-group">
                    <img src="assets/Email.svg" alt="Email Icon">
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <!-- Occupation -->
                <div class="input-group">
                    <input type="text" name="occupation" placeholder="Occupation" required>
                </div>

                <!-- Bank Name -->
                <div class="input-group">
                    <input type="text" name="bank_name" placeholder="Bank Name" required>
                </div>

                <!-- Bank Account -->
                <div class="input-group">
                    <input type="text" name="bank_account" placeholder="Bank Account" required>
                </div>

                <!-- Bank Account Number -->
                <div class="input-group">
                    <input type="number" name="bank_account_number" placeholder="Bank Account Number" required>
                </div>

                <!-- Password -->
                <div class="input-group">
                    <img src="assets/Password.svg" alt="Password Icon">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-sign-up">Sign Up</button>

                <!-- Sign In Link -->
                <div class="sign-in-my-account">
                    <a href="login.php"><b>Sign In to My Account</b></a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>