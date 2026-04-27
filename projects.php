<?php
    $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'phases';
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
                <label><strong>PROJECT:</strong></label>
                <select>
                    <option>Option 1</option>
                    <option>Option 2</option>
                </select>
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
            <p><?php echo $current_tab; ?></p>
        </div>
</body>
</html>