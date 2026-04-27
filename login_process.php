<?php
session_start(); 
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use a single, clean prepared statement
    $sql = "SELECT id, fullname, password, title FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        // Check hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['user_title'] = $user['title'];

            // Success redirect to your index.php tracking page
            header("Location: index.php");
            exit();
        } else {
			header("Location: login.php");
            //echo "Invalid password. <a href='login.php'>Try again</a>";
        }
    } else {
        echo "No account found with that email. <a href='sign_up.php'>Sign up here</a>";
    }
}
?>