<?php
include "db_connect.php"; // Database connection

// Search filter
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Submissions - Admin Panel</title>
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

        h2 {
            font-weight: 600;
        }

        table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .table th, .table td {
            vertical-align: middle;
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
        <h2 class="text-left mb-4">All Assignment Submissions</h2>

        <!-- Search Filter -->
        <form method="GET" class="mb-4" style="max-width: 500px;">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-dark"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0"
                    placeholder="Search by title, enroll no, grade or remarks..."
                    value="<?= htmlspecialchars($search) ?>" style="box-shadow: none;">
                <button class="btn btn-dark" type="submit">Search</button>
            </div>
        </form>

        <!-- Table -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Assignment Title</th>
                    <th>Student Enroll No</th>
                    <th>Submitted At</th>
                    <th>Grade</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($search)) {
                    $query = "SELECT a.*, b.title, c.enroll_no 
                              FROM submissions a
                              JOIN assignments b ON a.assignment_id = b.assignment_id
                              JOIN students c ON a.s_id = c.s_id
                              WHERE b.title LIKE '%$search%' 
                                 OR c.enroll_no LIKE '%$search%' 
                                 OR a.grade LIKE '%$search%' 
                                 OR a.remarks LIKE '%$search%'";
                } else {
                    $query = "SELECT a.*, b.title, c.enroll_no 
                              FROM submissions a
                              JOIN assignments b ON a.assignment_id = b.assignment_id
                              JOIN students c ON a.s_id = c.s_id";
                }

                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['enroll_no']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['submitted_at']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['grade']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['remarks']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No submissions found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
