<?php
session_start();
if (!isset($_SESSION['user_name']) || $_SESSION['user_name'] !== 'admin') {
    die("Access Denied: You do not have permission to view this page.");
}

include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <h2>User Role Management</h2>
    <table border="1" width="100%">
        <tr><th>Name</th><th>Current Title</th><th>Action</th></tr>
        <?php
        $res = mysqli_query($conn, "SELECT id, fullname, title FROM users");
        while($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
                    <td>{$row['fullname']}</td>
                    <td>{$row['title']}</td>
                    <td>
                        <form action='update_role.php' method='POST'>
                            <input type='hidden' name='user_id' value='{$row['id']}'>
                            <select name='new_title'>";
                            
                            $titles = ['Employee', 'Manager', 'Senior Employee', 'Admin'];
                            foreach ($titles as $t) {
                                $selected = ($row['title'] == $t) ? 'selected' : '';
                                echo "<option value='$t' $selected>$t</option>";
                            }

                            echo "</select>
                            <button type='submit'>Update</button>
                        </form>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>