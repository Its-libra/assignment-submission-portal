<?php
include "db_connect.php";

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: view_subjects.php");
    exit();
}

$sub_id = intval($_GET['id']);

// Fetch existing subject data
$query = "SELECT * FROM subjects WHERE sub_id = $sub_id";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) {
    echo "Subject not found.";
    exit();
}

$subject = mysqli_fetch_assoc($result);

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_subject'])) {
    $sub_code = mysqli_real_escape_string($conn, $_POST['sub_code']);
    $sub_name = mysqli_real_escape_string($conn, $_POST['sub_name']);

    $update_query = "UPDATE subjects SET sub_code='$sub_code', sub_name='$sub_name' WHERE sub_id=$sub_id";
    if (mysqli_query($conn, $update_query)) {
        header("Location: view_subjects.php");
        exit();
    } else {
        $error = "Failed to update subject: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Subject</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Edit Subject</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Subject Code</label>
            <input type="text" name="sub_code" class="form-control" value="<?= htmlspecialchars($subject['sub_code']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" name="sub_name" class="form-control" value="<?= htmlspecialchars($subject['sub_name']) ?>" required>
        </div>
        <button type="submit" name="update_subject" class="btn btn-primary">Update</button>
        <a href="view_subjects.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
