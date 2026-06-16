<?php
session_start();
include 'db.php';

// Security: Only allow Managers or Admin to access this
if (!isset($_SESSION['user_title']) || ($_SESSION['user_title'] !== 'Manager' && $_SESSION['user_title'] !== 'Admin')) {
    die("Access Denied: Only Managers can add phases to projects.");
}

$preset_project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Project Phase</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <h2>Add New Phase to Project</h2>
    <form action="process_phase.php" method="POST">
        <table border="0">
            <tr>
                <td>Select Project:</td>
                <td>
                    <select name="project_id" required>
                        <option value="">-- Select a Project --</option>
                        <?php
                        // Filter projects based on manager role or load all for admin
                        if ($_SESSION['user_title'] === 'Admin') {
                            $proj_sql = "SELECT id, name FROM projects";
                        } else {
                            $proj_sql = "SELECT id, name FROM projects WHERE manager_id = " . intval($_SESSION['user_id']);
                        }
                        
                        $res = mysqli_query($conn, $proj_sql);
                        while ($p = mysqli_fetch_assoc($res)) {
                            $selected = ($preset_project_id == $p['id']) ? 'selected' : '';
                            echo "<option value='{$p['id']}' $selected>" . htmlspecialchars($p['name']) . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>New Phase Name:</td>
                <td><input type="text" name="phase_name" placeholder="e.g., Development, Testing" required></td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit">Add Phase</button></td>
            </tr>
        </table>
    </form>
</body>
</html>