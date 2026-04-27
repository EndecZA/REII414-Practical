<?php
    session_start();
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
           <?php if ($current_tab == 'settings'): ?>
            <h3>Project Settings</h3>
            
            <?php 
            if (isset($_SESSION['user_title']) && ($_SESSION['user_title'] == 'Manager' || $_SESSION['user_title'] == 'Admin')) {
                echo '<div style="margin-bottom: 20px;">
                        <a href="manage_projects.php"><button>+ Add New Project</button></a>
                        <a href="add_phases.php" style="margin-left: 10px;"><button>+ Add Phases</button></a>
                      </div>';
            }
            ?>
            <?php else: ?>
                <p>Viewing: <?php echo strtoupper($current_tab); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>