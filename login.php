<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahoy!Login</title>
    <link rel="stylesheet" href="style.css">
</head>



<body class = "login-body">
    <div class="login-container">
        <form class="login-form">
		<img src="logo.jpeg" alt="Ahoy Logo" class="login-logo">
            
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
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