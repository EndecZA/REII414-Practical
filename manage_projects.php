<?php
session_start();
// Security: Only allow Managers or Admin to access this
if (!isset($_SESSION['user_title']) || ($_SESSION['user_title'] !== 'Manager' && $_SESSION['user_title'] !== 'Admin')) {
    die("Access Denied: Only Managers can create projects.");
}

include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create New Project</title>
     <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <h2>Create New Project</h2>
    <form action="process_projects.php" method="POST">
        <table border="0">
            <tr>
                <td>Project Name:</td>
                <td><input type="text" name="project_name" required></td>
            </tr>
            <tr>
                <td>Initial Phase Name:</td>
                <td><input type="text" name="phase_name" required></td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit">Create Project</button></td>
            </tr>
        </table>
    </form>
</body>
</html>