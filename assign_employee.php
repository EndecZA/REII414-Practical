<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_title']) || ($_SESSION['user_title'] !== 'Manager' && $_SESSION['user_title'] !== 'Admin')) {
    die("Access Denied.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h2>Assign Employee to Project</h2>
    <form action="process_assignment.php" method="POST">
        <label>Select Project:</label>
        <select name="project_id">
            <?php
            $res = mysqli_query($conn, "SELECT id, name FROM projects");
            while($row = mysqli_fetch_assoc($res)) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
        </select>
        <br><br>
        <label>Select Employee:</label>
        <select name="user_id">
            <?php
            $res = mysqli_query($conn, "SELECT id, fullname FROM users WHERE title = 'Employee'");
            while($row = mysqli_fetch_assoc($res)) {
                echo "<option value='{$row['id']}'>{$row['fullname']}</option>";
            }
            ?>
        </select>
        <br><br>
        <button type="submit">Assign Employee</button>
    </form>
</body>
</html>