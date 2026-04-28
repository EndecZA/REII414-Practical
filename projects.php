<?php
    session_start();
	include 'db.php';
    $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'phases';
	$selected_project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Projects</title>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="project-info-bar">
            <div class="project-select">
                <form method="GET" action="projects.php">
                <input type="hidden" name="tab" value="<?php echo htmlspecialchars($current_tab); ?>">
                <label><strong>PROJECT:</strong></label>
                <select name="id" onchange="this.form.submit()">
                    <option value="">Select a Project</option>
                    <?php
                    $proj_res = mysqli_query($conn, "SELECT id, name FROM projects");
                    while($p = mysqli_fetch_assoc($proj_res)) {
                        $selected = ($selected_project_id == $p['id']) ? 'selected' : '';
                        echo "<option value='{$p['id']}' $selected>{$p['name']}</option>";
                    }
                    ?>
                </select>
            </form>
            </div>

            <div class="manager-display">
                <strong>MANAGER:</strong> (DISP MANA)
            </div>
        </div>

        <div class="tab-container">
            <a href="?tab=phases" class="tab <?php echo ($current_tab == 'phases') ? 'active' : ''; ?>">PHASES</a>
            <a href="?tab=risk" class="tab <?php echo ($current_tab == 'risk') ? 'active' : ''; ?>">RISK MANAGEMENT</a>
            <a href="?tab=settings" class="tab <?php echo ($current_tab == 'settings') ? 'active' : ''; ?>">SETTINGS</a>
        </div>

      <div class="content-box">
		   <?php if ($current_tab == 'settings'): ?>
				<h3>Project Settings</h3>
				
				<?php 
				if (isset($_SESSION['user_title']) && ($_SESSION['user_title'] == 'Manager' || $_SESSION['user_title'] == 'Admin')) {
					echo '<div style="margin-bottom: 20px;">
							<a href="manage_projects.php"><button>+ Add New Project</button></a>
							<a href="add_phases.php" style="margin-left: 10px;"><button>+ Add Phases</button></a>
							<a href="assign_employee.php" style="margin-left: 10px;"><button>+ Assign Employee</button></a>
						  </div>';
				}
				?>

				<h3>Project Team</h3>
				<table border="1">
					<tr><th>Assigned Employee Name</th></tr>
					<?php
					// Make sure $selected_project_id is defined
					$selected_project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
					
					if ($selected_project_id > 0) {
						$query = "SELECT u.fullname 
								  FROM users u 
								  JOIN project_assignments pa ON u.id = pa.user_id 
								  WHERE pa.project_id = ?";
						
						$stmt = mysqli_prepare($conn, $query);
						mysqli_stmt_bind_param($stmt, "i", $selected_project_id);
						mysqli_stmt_execute($stmt);
						$result = mysqli_stmt_get_result($stmt);
						
						while($row = mysqli_fetch_assoc($result)) {
							echo "<tr><td>" . htmlspecialchars($row['fullname']) . "</td></tr>";
						}
					} else {
						echo "<tr><td>Please select a project to view the team.</td></tr>";
					}
					?>
				</table>
				<br>

			<?php else: ?>
				<p>Viewing: <?php echo strtoupper($current_tab); ?></p>
			<?php endif; ?>
		</div>
    </div>
</body>
</html>