<?php
    session_start();
	include 'db.php';
    $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'phases';
	$selected_project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$phase_filter = isset($_GET['phase_filter']) ? intval($_GET['phase_filter']) : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
	<link rel="icon" type="image/jpeg" href="logo.jpeg">
    <title>Ahoy! Projects</title>
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
    <strong>MANAGER:</strong>
    <?php
    if ($selected_project_id > 0) {
        $mgr_stmt = mysqli_prepare($conn, "SELECT u.fullname FROM users u 
                                           JOIN projects p ON u.id = p.manager_id 
                                           WHERE p.id = ?");
        mysqli_stmt_bind_param($mgr_stmt, "i", $selected_project_id);
        mysqli_stmt_execute($mgr_stmt);
        $mgr_result = mysqli_stmt_get_result($mgr_stmt);
        $mgr_row = mysqli_fetch_assoc($mgr_result);
        echo $mgr_row ? htmlspecialchars($mgr_row['fullname']) : 'No manager assigned';
    } else {
        echo 'Select a project';
    }
    ?>
</div>
</div>
<div class="tab-container">

<a href="?tab=phases&id=<?php echo $selected_project_id; ?>"
class="tab <?php echo ($current_tab == 'phases') ? 'active' : ''; ?>">
PHASES
</a>

<a href="?tab=risk&id=<?php echo $selected_project_id; ?>"
class="tab <?php echo ($current_tab == 'risk') ? 'active' : ''; ?>">
RISK MANAGEMENT
</a>

<a href="?tab=settings&id=<?php echo $selected_project_id; ?>"
class="tab <?php echo ($current_tab == 'settings') ? 'active' : ''; ?>">
SETTINGS
</a>

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

			<?php elseif ($current_tab == 'risk'): ?>

<div class="risk-container">

<div class="risk-button-container">   <!-- ← add this wrapper -->
        <a href="projects.php?tab=create_risk&id=<?php echo $selected_project_id; ?>"
           class="risk-btn">
            Create New Risk
        </a>
    </div>
	
	 <br style="clear:both;"> 

    <table class="risk-table">

        <tr>
            <th>Risk No.</th>
            <th>Description</th>
            <th>Category</th>
            <th>Probability</th>
            <th>Impact</th>
            <th>Score</th>
			<th>Edit</th>     
			<th>Delete</th> 
        </tr>

        <?php

        $query =
        "SELECT * FROM risks WHERE project_id=?";

        $stmt =
        mysqli_prepare(
            $conn,
            $query
        );

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $selected_project_id
        );

        mysqli_stmt_execute($stmt);

        $result =
        mysqli_stmt_get_result($stmt);

        while($r =
            mysqli_fetch_assoc($result)) {

            $score =
            $r['probability']
            *
            $r['impact'];

            echo "

            <tr>

            <td>{$r['id']}</td>

            <td>{$r['description']}</td>

            <td>{$r['category']}</td>

            <td>{$r['probability']}</td>

            <td>{$r['impact']}</td>

            <td>$score</td>

            <td><a href='edit_risk.php?id={$r['id']}&project_id={$selected_project_id}' class='risk-btn'>Edit</a></td>
			<td><a href='delete_risk.php?id={$r['id']}&project_id={$selected_project_id}' class='risk-btn' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
			
			</tr>";
        }

        ?>

    </table>

</div>

			<br>

<?php elseif ($current_tab == 'create_risk'): ?>

<h3>Create New Risk</h3>

<div class="risk-container">

<form action="process_risk.php" method="POST">

<input
type="hidden"
name="project_id"
value="<?php echo $selected_project_id; ?>">

<label>Description</label><br>
<input type="text"
       name="description"
       required><br><br>

<label>Category</label><br>
<select name="category" required>
    <option value="">-- Select Category --</option>
    <option value="G">Group</option>
    <option value="I">Individual</option>
    <option value="S">Schedule</option>
    <option value="K">Knowledge</option>
    <option value="T">Technical</option>
    <option value="F">Financial</option>
    <option value="O">Operational</option>
    <option value="L">Legal</option>
    <option value="E">Environmental</option>
</select><br><br>

<label>Probability</label><br>
<input type="number"
       name="probability"
       min="1"
       max="5"
       required><br><br>

<label>Impact</label><br>
<input type="number"
       name="impact"
       min="1"
       max="5"
       required><br><br>

<button type="submit" class="risk-btn">
Save Risk
</button>

</form>

</div>

			<?php elseif($current_tab == 'phases'): ?>
				<h3>Phases & Tasks</h3>
				
				<form method="GET" action="projects.php">
					<input type="hidden" name="id" value="<?php echo $selected_project_id; ?>">
					<input type="hidden" name="tab" value="phases">
					<select name="phase_filter" onchange="this.form.submit()">
						<option value="0">All Phases</option>
						<?php 
						$f_res = mysqli_query($conn, "SELECT id, name FROM phases WHERE project_id = $selected_project_id");
						while($f = mysqli_fetch_assoc($f_res)) {
							$sel = ($phase_filter == $f['id']) ? 'selected' : '';
							echo "<option value='{$f['id']}' $sel>{$f['name']}</option>";
						}
						?>
					</select>
				</form>

				<?php
				$p_sql = ($phase_filter > 0) ? "SELECT * FROM phases WHERE id = $phase_filter" : "SELECT * FROM phases WHERE project_id = $selected_project_id";
				$phases = mysqli_query($conn, $p_sql);
				
				while($phase = mysqli_fetch_assoc($phases)): ?>
					<div style="border:1px solid #ccc; margin-top:20px; padding:10px;">
						<h4>Phase: <?php echo $phase['name']; ?></h4>
						<table border="1" width="100%">
							<tr><th>Task</th><th>Status</th><th>Deadline</th><th>Tags</th><th>File</th></tr>
							<?php
							$tasks = mysqli_query($conn, "SELECT * FROM tasks WHERE phase_id = {$phase['id']}");
							while($t = mysqli_fetch_assoc($tasks)) {
								$s_not_started = ($t['status'] == 'not started') ? 'selected' : '';
								$s_busy        = ($t['status'] == 'busy') ? 'selected' : '';
								$s_completed   = ($t['status'] == 'completed') ? 'selected' : '';

								echo "<tr>
										<td>" . htmlspecialchars($t['title']) . "</td>
										<td>
											<form method=\"POST\" action=\"update_task_status.php\">
												<input type=\"hidden\" name=\"task_id\" value=\"{$t['id']}\">
												<input type=\"hidden\" name=\"redirect_to\" value=\"projects.php?id=$selected_project_id&tab=phases\">
												<select name=\"status\" onchange=\"this.form.submit()\">
													<option value=\"not started\" $s_not_started>Not Started</option>
													<option value=\"busy\" $s_busy>Busy</option>
													<option value=\"completed\" $s_completed>Completed</option>
												</select>
											</form>
										</td>
										<td>{$t['deadline']}</td>
										<td>" . htmlspecialchars($t['tags']) . "</td>
										<td><a href='{$t['file_path']}'>Download</a></td>
									  </tr>";
							}
														?>
						</table>

					<h5>Add New Task</h5>
						<form action="process_task.php" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="phase_id" value="<?php echo $phase['id']; ?>">
							<input type="hidden" name="project_id" value="<?php echo $selected_project_id; ?>">
							
							<input type="text" name="title" placeholder="Task Title" required>
							
							<input type="date" name="deadline">
							<input type="text" name="tags" placeholder="Tags">
							<input type="file" name="task_file">
							<button type="submit">Add Task</button>
						</form>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
    </div>
</body>
</html>