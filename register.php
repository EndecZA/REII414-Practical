<?php
include 'db.php'; // Load the connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $name  = $_POST['fullname'];
    $email = $_POST['email'];
    $pass  = $_POST['password'];
	$user  = $_POST['username'];
	$title = "Employee";

    // Security: Hash the password
    $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);

    // SQL to insert the data
    $sql = "INSERT INTO users (fullname, email, password, username, title) VALUES (?, ?, ?, ?,?)";
    
    // Using Prepared Statements (Essential for university rubrics/security)
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $hashed_pass, $user, $title);

    if (mysqli_stmt_execute($stmt)) {
        echo "<h1>Welcome aboard!</h1>";
        echo "<p>User created successfully. <a href='index.html'>Click here to Login</a></p>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>