<?php
include "db_connect.php";
session_start();

// Redirect if no ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: faculty_student_view.php");
    exit();
}

$sid = intval($_GET['id']);

// Fetch student details
$result = mysqli_query($conn, "SELECT * FROM students WHERE s_id = $sid");
if (!$result || mysqli_num_rows($result) === 0) {
    echo "<script>alert('Student not found'); window.location.href='faculty_student_view.php';</script>";
    exit();
}
$student = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
    $enroll = mysqli_real_escape_string($conn, $_POST['enroll_no']);
    $name = mysqli_real_escape_string($conn, $_POST['s_name']);
    $email = mysqli_real_escape_string($conn, $_POST['s_email']);

    $update_query = "UPDATE students SET enroll_no='$enroll', s_name='$name', s_email='$email' WHERE s_id=$sid";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Student updated successfully'); window.location.href='faculty_student_view.php';</script>";
        exit();
    } else {
        $error = "Update failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Edit Student</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Enrollment No</label>
            <input type="text" name="enroll_no" class="form-control" value="<?= htmlspecialchars($student['enroll_no']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="s_name" class="form-control" value="<?= htmlspecialchars($student['s_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="s_email" class="form-control" value="<?= htmlspecialchars($student['s_email']) ?>" required>
        </div>
        <button type="submit" name="update_student" class="btn btn-success">Update</button>
        <a href="faculty_student_view.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>