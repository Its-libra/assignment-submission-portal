<?php
include "db_connect.php"; // DB connection

// Define search term early to avoid undefined variable
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Assignments - Admin Panel</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-image: url('images/image10.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            min-height: 100vh;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
            background-color: rgba(255, 255, 255, 0.88);
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

        .main-content {
            flex-grow: 1;
            padding: 40px;
        }

        table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        h2 {
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">Admin Panel</h4>
        <a href="admin_dashboard.php"><i class="bi bi-person-fill"></i> Dashboard</a>
        <a href="admin_add_faculty.php"><i class="bi bi-person-plus-fill"></i> Add Faculty</a>
        <a href="admin_add_subject.php"><i class="bi bi-journal-plus"></i> Add Subject</a>
        <a href="admin_view_faculty.php"><i class="bi bi-people-fill"></i> View Faculty</a>
        <a href="view_subjects.php"><i class="bi bi-journal-bookmark-fill"></i> View Subjects</a>
        <a href="view_assignments.php"><i class="bi bi-clipboard-check"></i> View Assignments</a>
        <a href="view_submissions.php"><i class="bi bi-file-earmark-text"></i> View Submissions</a>
        <a href="index.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="text-left mb-4">All Assignments</h2>

        <!-- Search Form -->
        <form method="GET" action="" class="mb-4 d-flex justify-content-start">
            <div class="input-group" style="max-width: 400px; width: 100%;">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-dark"></i>
                </span>
                <input 
                    type="text" 
                    name="search" 
                    class="form-control border-start-0" 
                    placeholder="Search by title, description, or subject..." 
                    value="<?= htmlspecialchars($search) ?>" 
                    style="box-shadow: none;"
                >
                <button class="btn btn-dark" type="submit">
                    Search
                </button>
            </div>
        </form>

        <!-- Assignment Table -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Subject Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Search query
                if (!empty($search)) {
                    $query = "SELECT a.*, b.sub_name 
                              FROM assignments a 
                              JOIN subjects b ON a.sub_id = b.sub_id 
                              WHERE a.title LIKE '%$search%' 
                                 OR a.description LIKE '%$search%' 
                                 OR b.sub_name LIKE '%$search%'";
                } else {
                    $query = "SELECT a.*, b.sub_name 
                              FROM assignments a 
                              JOIN subjects b ON a.sub_id = b.sub_id";
                }

                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['due_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['sub_name']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No assignments found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
