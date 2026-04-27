<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahoy!Sign Up</title>
    <link rel="stylesheet" href="style.css">

</head>
<body class="signup-page">
    <div class="signup-container">
        
        <h2>Join the Crew</h2>
        
        <form action="register.php" method="POST">
            <div class="input-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>

            <div class="input-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Create Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="input-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>

            <button type="submit" class="login-btn">Sign Up</button>
            <p class="signup-link">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>