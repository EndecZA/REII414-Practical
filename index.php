<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$u_id = intval($_SESSION['user_id']);
$u_title = $_SESSION['user_title'];

// Query tasks reaching their deadline within 1 day
if ($u_title === 'Manager' || $u_title === 'Admin') {
    // Managers get alerted on tasks within projects they oversee
    $check_deadline_query = "SELECT t.id AS task_id, p.id AS project_id, p.name AS project_name, t.tags 
                             FROM tasks t
                             JOIN phases ph ON t.phase_id = ph.id
                             JOIN projects p ON ph.project_id = p.id
                             WHERE p.manager_id = ? AND t.deadline <= DATE_ADD(NOW(), INTERVAL 1 DAY) AND t.deadline >= NOW()";
} else {
    // Employees get alerted on their own assigned tasks
    $check_deadline_query = "SELECT t.id AS task_id, p.id AS project_id, p.name AS project_name, t.tags 
                             FROM tasks t
                             JOIN phases ph ON t.phase_id = ph.id
                             JOIN projects p ON ph.project_id = p.id
                             JOIN project_assignments pa ON p.id = pa.project_id
                             WHERE pa.user_id = ? AND t.deadline <= DATE_ADD(NOW(), INTERVAL 1 DAY) AND t.deadline >= NOW()";
}

$dl_stmt = mysqli_prepare($conn, $check_deadline_query);
mysqli_stmt_bind_param($dl_stmt, "i", $u_id);
mysqli_stmt_execute($dl_stmt);
$dl_res = mysqli_stmt_get_result($dl_stmt);

while ($dl_row = mysqli_fetch_assoc($dl_res)) {
    $msg = "Urgent: A task on project '" . $dl_row['project_name'] . "' is due within 24 hours.";
    
    // Check if this specific deadline warning message was already generated to avoid duplication
    $dup_check = mysqli_query($conn, "SELECT id FROM notifications WHERE user_id = $u_id AND message = '" . mysqli_real_escape_string($conn, $msg) . "'");
    if (mysqli_num_rows($dup_check) == 0) {
        $ins_notif = mysqli_prepare($conn, "INSERT INTO notifications (user_id, project_id, message, type) VALUES (?, ?, ?, 'deadline')");
        mysqli_stmt_bind_param($ins_notif, "iis", $u_id, $dl_row['project_id'], $msg);
        mysqli_stmt_execute($ins_notif);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<link rel="icon" type="image/jpeg" href="logo.jpeg">
	<title>Dashboard</title>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">

	<div class="welcome-msg">WELCOME, <?php echo strtoupper(htmlspecialchars($_SESSION['user_name'])); ?></div>

<div class="section-header">To-Do</div>
    <table class="data-table" border="1" width="100%">
        <tr>
            <th>Task</th>
            <th>Project</th>
            <th>Status</th>
            <th>Deadlines</th>
            <th>Tags</th>
        </tr>
        <?php
        // Filter out 'completed' status so they disappear from the dashboard
        if ($u_title === 'Manager' || $u_title === 'Admin') {
            $task_query = "SELECT t.id AS task_id, t.title AS task_name, p.id AS project_id, p.name AS project_name, t.status, t.deadline, t.tags
                           FROM tasks t
                           JOIN phases ph ON t.phase_id = ph.id
                           JOIN projects p ON ph.project_id = p.id
                           WHERE p.manager_id = ? AND t.status != 'completed'";
} else {
    $task_query = "SELECT t.id AS task_id, t.title AS task_name, p.id AS project_id, p.name AS project_name, t.status, t.deadline, t.tags
                   FROM tasks t
                   JOIN phases ph ON t.phase_id = ph.id
                   JOIN projects p ON ph.project_id = p.id
                   JOIN project_assignments pa ON p.id = pa.project_id
                   WHERE pa.user_id = ? AND t.status != 'completed'";
}

        $t_stmt = mysqli_prepare($conn, $task_query);
        mysqli_stmt_bind_param($t_stmt, "i", $u_id);
        mysqli_stmt_execute($t_stmt);
        $t_result = mysqli_stmt_get_result($t_stmt);

        if (mysqli_num_rows($t_result) > 0) {
            while ($task_row = mysqli_fetch_assoc($t_result)) {
                $task_deadline = !empty($task_row['deadline']) ? $task_row['deadline'] : 'No deadline';
                $task_tags = !empty($task_row['tags']) ? htmlspecialchars($task_row['tags']) : '-';
                
                // Track dropdown selections
                $s_not_started = ($task_row['status'] == 'not started') ? 'selected' : '';
                $s_busy        = ($task_row['status'] == 'busy') ? 'selected' : '';
                $s_completed   = ($task_row['status'] == 'completed') ? 'selected' : '';

                echo "<tr>
                        <td>" . htmlspecialchars($task_row['task_name']) . "</td>
                        <td><a href='projects.php?id={$task_row['project_id']}&tab=phases'>" . htmlspecialchars($task_row['project_name']) . "</a></td>
                        
                        <td>
                            <form method=\"POST\" action=\"update_task_status.php\">
                                <input type=\"hidden\" name=\"task_id\" value=\"{$task_row['task_id']}\">
                                <input type=\"hidden\" name=\"redirect_to\" value=\"index.php\">
                                <select name=\"status\" onchange=\"this.form.submit()\">
                                    <option value=\"not started\" $s_not_started>Not Started</option>
                                    <option value=\"busy\" $s_busy>Busy</option>
                                    <option value=\"completed\" $s_completed>Completed</option>
                                </select>
                            </form>
                        </td>
                        
                        <td>" . htmlspecialchars($task_deadline) . "</td>
                        <td>" . $task_tags . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' align='center'>No pending tasks found.</td></tr>";
        }
        ?>
    </table>
	
	<div class="section-header">Projects</div>
	
	<table class="data-table">
        <tr>
            <th>Project</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Manager</th>
        </tr>
		<?php
        $user_id = intval($_SESSION['user_id']);
        $user_title = $_SESSION['user_title'];

        if ($user_title === 'Manager' || $user_title === 'Admin') {
      
            $query = "SELECT p.id, p.name AS project_name, 'N/A' AS deadline, 'Active' AS status, u.fullname AS manager_name
                      FROM projects p
                      JOIN users u ON p.manager_id = u.id
                      WHERE p.manager_id = ?";
        } else {
            $query = "SELECT p.id, p.name AS project_name, 'N/A' AS deadline, 'Active' AS status, u.fullname AS manager_name
                      FROM projects p
                      JOIN project_assignments pa ON p.id = pa.project_id
                      JOIN users u ON p.manager_id = u.id
                      WHERE pa.user_id = ?";
        }

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td><a href='projects.php?id={$row['id']}&tab=phases'>" . htmlspecialchars($row['project_name']) . "</a></td>
                        <td>{$row['deadline']}</td>
                        <td>{$row['status']}</td>
                        <td>" . htmlspecialchars($row['manager_name']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4' align='center'>No projects found.</td></tr>";
        }
        ?>
    </table>
	
	<div class="section-header">Notifications</div>
    
    <table class="data-table" border="1" width="100%">
        <tr>
            <th>Alert Message</th>
            <th>Project View Link</th>
            <th>Action</th>
        </tr>
        <?php
        $sess_user_id = intval($_SESSION['user_id']);
        $notif_query = "SELECT id, message, project_id FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
        
        $n_stmt = mysqli_prepare($conn, $notif_query);
        mysqli_stmt_bind_param($n_stmt, "i", $sess_user_id);
        mysqli_stmt_execute($n_stmt);
        $n_result = mysqli_stmt_get_result($n_stmt);

        if (mysqli_num_rows($n_result) > 0) {
            while ($n_row = mysqli_fetch_assoc($n_result)) {
                echo "<tr>
                        <td>" . htmlspecialchars($n_row['message']) . "</td>
                        <td><a href='projects.php?id={$n_row['project_id']}&tab=phases'>View Project Workspace</a></td>
                        <td><a href='clear_notification.php?notif_id={$n_row['id']}'><button style='color:red;'>Clear Alert</button></a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3' align='center'>No new notifications.</td></tr>";
        }
        ?>
    </table>
	
</body>
</html>