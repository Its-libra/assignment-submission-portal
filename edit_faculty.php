<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "assignment_portal");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    $_SESSION['message'] = "Invalid faculty ID.";
    header("Location: admin_view_faculty.php");
    exit();
}

$fid = intval($_GET['id']);

// Handle update form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['faculty_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['faculty_email']));

    if (!empty($name) && !empty($email)) {
        $update = "UPDATE faculties SET faculty_name='$name', faculty_email='$email' WHERE faculty_id=$fid";
        if (mysqli_query($conn, $update)) {
            $_SESSION['message'] = "Faculty details updated successfully.";
        } else {
            $_SESSION['message'] = "Error updating faculty: " . mysqli_error($conn);
        }
        header("Location: admin_view_faculty.php");
        exit();
    } else {
        $_SESSION['message'] = "Name and email cannot be empty.";
    }
}

// Get faculty data
$query = "SELECT * FROM faculties WHERE faculty_id=$fid";
$result = mysqli_query($conn, $query);
$faculty = mysqli_fetch_assoc($result);

if (!$faculty) {
    $_SESSION['message'] = "Faculty not found.";
    header("Location: admin_view_faculty.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Faculty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Faculty</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-warning">
            <?= $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Faculty Name</label>
            <input type="text" name="faculty_name" class="form-control" value="<?= htmlspecialchars($faculty['faculty_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Faculty Email</label>
            <input type="email" name="faculty_email" class="form-control" value="<?= htmlspecialchars($faculty['faculty_email']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="admin_view_faculty.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
