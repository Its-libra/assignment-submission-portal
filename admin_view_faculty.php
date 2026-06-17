<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "assignment_portal");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    if (mysqli_query($conn, "DELETE FROM faculties WHERE faculty_id = $delete_id")) {
        $_SESSION['message'] = "Faculty deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting faculty.";
    }
    header("Location: admin_view_faculty.php");
    exit();
}

// Handle search filter
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query = "SELECT f.faculty_id, f.faculty_name, f.faculty_email, a.username AS added_by 
          FROM faculties f
          LEFT JOIN admins a ON f.admin_id = a.admin_id";

if (!empty($search)) {
    $query .= " WHERE f.faculty_name LIKE '%$search%' OR f.faculty_email LIKE '%$search%'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Faculty - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-image: url('images/image10.jpg');
            background-size: cover;
            background-attachment: fixed;
        }

        .wrapper {
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

        .edit-icon {
            color: #20c997;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .edit-icon:hover {
            color: #000;
        }

        .delete-icon {
            color: #dc3545;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .delete-icon:hover {
            color: #000;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
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
    <div class="main-content">
        <h2 class="mb-4">Faculty List</h2>

        <!-- Search Filter -->
<form method="GET" action="" class="mb-4 d-flex justify-content-start">
  <div class="input-group" style="max-width: 400px; width: 100%;">
    <span class="input-group-text bg-white border-end-0">
      <i class="bi bi-search text-dark"></i>
    </span>
    <input 
      type="text" 
      name="search" 
      class="form-control border-start-0" 
      placeholder="Search by name or email..." 
      value="<?= htmlspecialchars($search) ?>" 
      style="box-shadow: none;"
    >
    <button class="btn btn-dark" type="submit">
      Search
    </button>
  </div>
</form>


        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info">
                <?= $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Added By</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($row['faculty_name']) ?></td>
                            <td><?= htmlspecialchars($row['faculty_email']) ?></td>
                            <td><?= htmlspecialchars($row['added_by'] ?? 'Unknown') ?></td>
                            <td class="text-center">
                                <a href="edit_faculty.php?id=<?= $row['faculty_id'] ?>" title="Edit">
                                    <i class="bi bi-pencil-square edit-icon"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="?delete_id=<?= $row['faculty_id'] ?>" onclick="return confirm('Are you sure you want to delete this faculty?');" title="Delete">
                                    <i class="bi bi-trash delete-icon"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No faculty found.</div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
