<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<title>Dashboard</title>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">

	<div class="welcome-msg">WELCOME, <?php echo strtoupper(htmlspecialchars($_SESSION['user_name'])); ?></div>

    <div class="section-header">To-Do</div>

    <table class="data-table">
        <tr>
            <th>Task</th>
            <th>Project</th>
            <th>Status</th>
            <th>Deadlines</th>
            <th>Notes</th>
        </tr>
        <tr>
           
        </tr>
    </table>
	
	<div class="section-header">Projects</div>
	
	<table class="data-table">
        <tr>
            <th>Project</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Manager</th>
        </tr>
        <tr>
           
        </tr>
    </table>
	
	<div class="section-header">Notifications</div>
	
	<table class="data-table">
        <tr>
            <th>Project</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Manager</th>
        </tr>
        <tr>
           
        </tr>
    </table>
	
</body>
</html>