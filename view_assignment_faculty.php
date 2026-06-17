<?php
include "db_connect.php";
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Assignments - Faculty Panel</title>
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

    .content-wrapper {
      flex-grow: 1;
      padding: 40px;
    }

    h3 {
      font-weight: bold;
    }

    .table th, .table td {
      vertical-align: middle;
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
  <div class="content-wrapper">
    <h3 class="mb-4 text-left"><i class="bi bi-journal-text"></i> All Assignments</h3>

   <!-- Search Form -->
<form method="GET" action="" class="mb-4" style="max-width: 500px;">
  <div class="input-group">
    <span class="input-group-text bg-white border-end-0">
      <i class="bi bi-search text-dark"></i>
    </span>
    <input 
      type="text" 
      name="search" 
      class="form-control border-start-0" 
      placeholder="Search by title, description, or subject..." 
      value="<?= htmlspecialchars($search) ?>"
    >
    <button class="btn btn-dark" type="submit">Search</button>
  </div>
</form>


    <!-- Assignments Table -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
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
          if (!empty($search)) {
            $query = "SELECT a.*, b.sub_name 
                      FROM assignments a 
                      JOIN subjects b ON a.sub_id = b.sub_id 
                      WHERE a.title LIKE '%$search%' 
                         OR a.description LIKE '%$search%' 
                         OR b.sub_name LIKE '%$search%' 
                      ORDER BY a.due_date DESC";
          } else {
            $query = "SELECT a.*, b.sub_name 
                      FROM assignments a 
                      JOIN subjects b ON a.sub_id = b.sub_id 
                      ORDER BY a.due_date DESC";
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
            echo "<tr><td colspan='4' class='text-center text-muted'>No assignments found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
