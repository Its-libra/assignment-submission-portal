<?php
include "db_connect.php";
session_start();

// Delete Student
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $check = mysqli_query($conn, "SELECT * FROM students WHERE s_id = $delete_id");
    if (mysqli_num_rows($check) == 1) {
        mysqli_query($conn, "DELETE FROM students WHERE s_id = $delete_id");
        echo "<script>alert('Student deleted successfully'); window.location.href='faculty_student_view.php';</script>";
        exit();
    } else {
        echo "<script>alert('Invalid deletion attempt');</script>";
    }
}

// Search Filter
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$query = "SELECT * FROM students";
if (!empty($search)) {
    $query .= " WHERE enroll_no LIKE '%$search%' OR s_name LIKE '%$search%' OR s_email LIKE '%$search%'";
}
$query .= " ORDER BY s_name ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Students - Faculty</title>
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
            flex-grow: 1;
            padding: 30px;
        }

        .edit-icon {
            color:  #0d4d4d;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .edit-icon:hover {
            color: black;
        }

        .delete-icon {
            color: #dc3545;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .delete-icon:hover {
            color: black;
        }

        @media (max-width: 767.98px) {
            .wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Faculty Panel</h4>
        <a href="faculty_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="faculty_add_student.php"><i class="bi bi-person-plus-fill"></i> Add Students</a>
        <a href="faculty_student_view.php"><i class="bi bi-people-fill"></i> View Students</a>
        <a href="create_assignment.php"><i class="bi bi-journal-plus"></i> Create Assignments</a>
        <a href="view_assignment_faculty.php"><i class="bi bi-journal-text"></i> View Assignments</a>
        <a href="view_submissions_faculty.php"><i class="bi bi-folder-symlink"></i> View Submissions</a>
        <a href="give_grades.php"><i class="bi bi-check2-square"></i> Grade & Remarks</a>
        <a href="index.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2 class="mb-4">Students</h2>

        <!-- Search Filter -->
        <form method="GET" action="" class="mb-3" style="max-width: 500px;">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-dark"></i>
                </span>
                <input 
                    type="text" 
                    name="search" 
                    class="form-control border-start-0" 
                    placeholder="Search by enrollment, name, or email..." 
                    value="<?= htmlspecialchars($search) ?>" 
                    style="box-shadow: none;"
                >
                <button class="btn btn-dark" type="submit">Search</button>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Enrollment</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Submissions</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['enroll_no']); ?></td>
                            <td><?= htmlspecialchars($row['s_name']); ?></td>
                            <td><?= htmlspecialchars($row['s_email']); ?></td>
                            <td class="text-center">
                                <a href="view_submissions_faculty.php?sid=<?= $row['s_id']; ?>" class="btn btn-sm btn-primary">View</a>
                            </td>
                            <td class="text-center">
                                <a href="edit_student.php?id=<?= $row['s_id'] ?>">
                                    <i class="bi bi-pencil-square edit-icon"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="faculty_student_view.php?delete=<?= $row['s_id']; ?>" onclick="return confirm('Are you sure you want to delete this student?');">
                                    <i class="bi bi-trash delete-icon"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No students found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
