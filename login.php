<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahoy! Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class = "login-body">

    <div class="login-container">
        <form class="login-form" action="login_process.php" method="POST">
            <img src="logo.jpeg" alt="Ahoy Logo" class="login-logo">
            
            <div class="input-group">
                <label for="user_input">Email</label>
                <input type="text" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="login-btn">Login</button>
			
            <p class="signup-link">Don't have an account? <a href="sign_up.php">Sign up</a></p>
        </form>
    </div>
</body>
</html>