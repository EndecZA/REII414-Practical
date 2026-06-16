<?php

include 'db.php';

/* Get values from form */
$project_id = intval($_POST['project_id']);
$description = trim($_POST['description']);
$category = trim($_POST['category']);
$probability = intval($_POST['probability']);
$impact = intval($_POST['impact']);


/* Check project exists */
$check = mysqli_prepare(
    $conn,
    "SELECT id FROM projects WHERE id = ?"
);

mysqli_stmt_bind_param(
    $check,
    "i",
    $project_id
);

mysqli_stmt_execute($check);

$result = mysqli_stmt_get_result($check);

if (mysqli_num_rows($result) == 0) {
    die("Invalid project selected.");
}


/* Insert risk */
$query = "
INSERT INTO risks
(project_id, description, probability, impact, category)
VALUES (?, ?, ?, ?, ?)
";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param(
    $stmt,
    "isiis",
    $project_id,
    $description,
    $probability,
    $impact,
    $category
);

if (!mysqli_stmt_execute($stmt)) {
    die("Insert failed: " . mysqli_error($conn));
}


/* Return to risk page */
header(
    "Location: projects.php?tab=risk&id=$project_id"
);

exit;

?>
