<?php
session_start();
include 'db.php';

$risk_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$project_id = isset($_GET['project_id']) ? intval($_GET['project_id']) : 0;

$stmt = mysqli_prepare($conn, "SELECT * FROM risks WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $risk_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$risk = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Edit Risk</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="content-box">
        <h3>Edit Risk</h3>
        <div class="risk-container">
            <form action="process_edit_risk.php" method="POST">
                <input type="hidden" name="risk_id" value="<?php echo $risk['id']; ?>">
                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">

                <label>Description</label><br>
                <input type="text" name="description" value="<?php echo htmlspecialchars($risk['description']); ?>" required><br><br>

                <label>Category</label><br>
<select name="category" required>
    <option value="">-- Select Category --</option>
    <option value="G" <?php echo ($risk['category'] == 'G') ? 'selected' : ''; ?>>Group</option>
    <option value="I" <?php echo ($risk['category'] == 'I') ? 'selected' : ''; ?>>Individual</option>
    <option value="S" <?php echo ($risk['category'] == 'S') ? 'selected' : ''; ?>>Schedule</option>
    <option value="K" <?php echo ($risk['category'] == 'K') ? 'selected' : ''; ?>>Knowledge</option>
    <option value="T" <?php echo ($risk['category'] == 'Technical') ? 'selected' : ''; ?>>Technical</option>
    <option value="F" <?php echo ($risk['category'] == 'Financial') ? 'selected' : ''; ?>>Financial</option>
    <option value="O" <?php echo ($risk['category'] == 'Operational') ? 'selected' : ''; ?>>Operational</option>
    <option value="L" <?php echo ($risk['category'] == 'Legal') ? 'selected' : ''; ?>>Legal</option>
    <option value="E" <?php echo ($risk['category'] == 'Environmental') ? 'selected' : ''; ?>>Environmental</option>
</select><br><br>
                <label>Probability (1-5)</label><br>
                <input type="number" name="probability" min="1" max="5" value="<?php echo $risk['probability']; ?>" required><br><br>

                <label>Impact (1-5)</label><br>
                <input type="number" name="impact" min="1" max="5" value="<?php echo $risk['impact']; ?>" required><br><br>

                <button type="submit" class="risk-btn">Save Changes</button>
                <a href="projects.php?tab=risk&id=<?php echo $project_id; ?>" class="risk-btn">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>