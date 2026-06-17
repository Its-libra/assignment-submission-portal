<?php
include "db_connect.php";

// Delete subject
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM subjects WHERE sub_id=$delete_id");
    header("Location: view_subjects.php");
    exit();
}

// Fetch subjects with optional filter
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
if (!empty($search)) {
    $query = "SELECT s.sub_id, s.sub_code, s.sub_name, a.username AS admin_username 
              FROM subjects s
              LEFT JOIN admins a ON s.admin_id = a.admin_id
              WHERE s.sub_code LIKE '%$search%' OR s.sub_name LIKE '%$search%'";
} else {
    $query = "SELECT s.sub_id, s.sub_code, s.sub_name, a.username AS admin_username 
              FROM subjects s
              LEFT JOIN admins a ON s.admin_id = a.admin_id";
}
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Subjects - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-image: url('images/image10.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
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

        .main {
            flex-grow: 1;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .bi-pencil-square {
            color: #20c997;
            cursor: pointer;
        }

        .bi-pencil-square:hover {
            color:  #0d4d4d;
        }

        .bi-trash {
            color: #dc3545;
            cursor: pointer;
        }

        .bi-trash:hover {
            color: #000;
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
    <div class="main">
        <h2 class="mb-4 text-left">Subjects Assigned</h2>

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
      placeholder="Search by code or sub-name..." 
      value="<?= htmlspecialchars($search) ?>" 
      style="box-shadow: none;"
    >
    <button class="btn btn-dark" type="submit">
      Search
    </button>
  </div>
</form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Admin Username</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['sub_code']) ?></td>
                                <td><?= htmlspecialchars($row['sub_name']) ?></td>
                                <td><?= htmlspecialchars($row['admin_username'] ?? 'Unknown') ?></td>
                                <td class="text-center">
                                    <a href="edit_subject.php?id=<?= $row['sub_id'] ?>" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="?delete_id=<?= $row['sub_id'] ?>" onclick="return confirm('Delete this subject?');" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No subjects found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
