<?php
$conn = mysqli_connect("localhost", "root", "", "assignment_portal");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$success = $error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
    $admin_id = (int) $_POST['admin_id'];

    $check_query = "SELECT * FROM subjects WHERE sub_code = '$subject_code'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error = "Subject code already exists!";
    } else {
        $insert = "INSERT INTO subjects (sub_name, sub_code, admin_id) 
                   VALUES ('$subject_name', '$subject_code', $admin_id)";
        if (mysqli_query($conn, $insert)) {
            $success = "Subject added successfully.";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

$admin_result = mysqli_query($conn, "SELECT admin_id, username FROM admins");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Subject - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-image: url('images/image10.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .wrapper {
            flex: 1;
            display: flex;
            min-height: 100vh;
            background-color: rgba(255, 255, 255, 0.85);
        }

        .sidebar {
            flex-shrink: 0;
            width: 250px;
            background-color: rgb(145, 214, 206);
            color: #000;
            padding-top: 1rem;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: bold;
        }

        .sidebar a {
            color: #000;
            text-decoration: none;
            display: block;
            padding: 15px 20px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #0d4d4d;
            color: #fff;
        }

        .content {
            flex: 1;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #0d4d4d;
            border: none;
        }

        .btn-primary:hover {
            background-color: #083636;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Admin Panel</h4>
        <a href="admin_dashboard.php"><i class="bi bi-person-fill"></i> Dashboard</a>
        <a href="admin_add_faculty.php"><i class="bi bi-person-plus-fill"></i> Add Faculty</a>
        <a href="admin_add_subject.php"><i class="bi bi-journal-plus"></i> Add Subject</a>
        <a href="admin_view_faculty.php"><i class="bi bi-people-fill"></i> View Faculty</a>
        <a href="view_subjects.php"><i class="bi bi-journal-bookmark-fill"></i> View Subjects</a>
        <a href="view_assignments.php"><i class="bi bi-clipboard-check"></i> View Assignments</a>
        <a href="view_submissions.php"><i class="bi bi-file-earmark-text"></i> View Submissions</a>
        <a href="index.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="card">
            <h3 class="text-center mb-4"><i class="bi bi-journal-plus"></i> Add New Subject</h3>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="subject_name" class="form-label">Subject Name</label>
                    <input type="text" class="form-control" id="subject_name" name="subject_name" required>
                </div>
                <div class="mb-3">
                    <label for="subject_code" class="form-label">Subject Code</label>
                    <input type="text" class="form-control" id="subject_code" name="subject_code" required>
                </div>
                <div class="mb-3">
                    <label for="admin_id" class="form-label">Assign to Admin</label>
                    <select name="admin_id" id="admin_id" class="form-select" required>
                        <option value="">-- Select Admin --</option>
                        <?php while ($row = mysqli_fetch_assoc($admin_result)): ?>
                            <option value="<?= $row['admin_id'] ?>"><?= htmlspecialchars($row['username']) ?> (ID: <?= $row['admin_id'] ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Add Subject</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
