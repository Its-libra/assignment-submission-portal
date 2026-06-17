<?php
include "db_connect.php";

function getCount($conn, $query) {
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['total'] ?? 0;
}

$student_count = getCount($conn, "SELECT COUNT(*) AS total FROM students");
$assignment_count = getCount($conn, "SELECT COUNT(*) AS total FROM assignments");
$submission_count = getCount($conn, "SELECT COUNT(*) AS total FROM submissions");
$graded_count = getCount($conn, "SELECT COUNT(*) AS total FROM submissions WHERE grade IS NOT NULL");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Faculty Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
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
      padding: 30px;
    }

    h2 {
      font-weight: 600;
      margin-bottom: 30px;
    }

    .dashboard-card {
      background-color: #fff;
      color: #000;
      border-radius: 10px;
      border: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
    }

    .count {
      font-size: 2rem;
      font-weight: bold;
    }

    @media (max-width: 767.98px) {
      .wrapper {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding-bottom: 0;
      }

      .content-wrapper {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
<div class="wrapper">
  <nav class="sidebar">
    <h4>Faculty Panel</h4>
    <a href="faculty_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="faculty_add_student.php"><i class="bi bi-person-plus-fill"></i> Add Students</a>
    <a href="faculty_student_view.php"><i class="bi bi-people-fill"></i> View Students</a>
    <a href="create_assignment.php"><i class="bi bi-journal-plus"></i> Create Assignments</a>
    <a href="view_assignment_faculty.php"><i class="bi bi-journal-text"></i> View Assignments</a>
    <a href="view_submissions_faculty.php"><i class="bi bi-folder-symlink"></i> View Submissions</a>
    <a href="give_grades.php"><i class="bi bi-check2-square"></i> Grade & Remarks</a>
    <a href="menu.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </nav>

  <!-- Main Content -->
  <main class="content-wrapper container-fluid">
    <h2>Welcome, Faculty</h2>

    <div class="row g-4">
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card dashboard-card shadow border-top border-4 border-dark">
          <div class="card-body text-center">
            <i class="bi bi-people-fill text-dark mb-2" style="font-size: 2rem;"></i>
            <h5 class="card-title">Students</h5>
            <p class="count"><?php echo $student_count; ?></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="card dashboard-card shadow border-top border-4 border-dark">
          <div class="card-body text-center">
            <i class="bi bi-journal-text text-dark mb-2" style="font-size: 2rem;"></i>
            <h5 class="card-title">Assignments</h5>
            <p class="count"><?php echo $assignment_count; ?></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="card dashboard-card shadow border-top border-4 border-dark">
          <div class="card-body text-center">
            <i class="bi bi-folder-check text-dark mb-2" style="font-size: 2rem;"></i>
            <h5 class="card-title">Submissions</h5>
            <p class="count"><?php echo $submission_count; ?></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="card dashboard-card shadow border-top border-4 border-dark">
          <div class="card-body text-center">
            <i class="bi bi-check2-square text-dark mb-2" style="font-size: 2rem;"></i>
            <h5 class="card-title">Graded</h5>
            <p class="count"><?php echo $graded_count; ?></p>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

</body>
</html>
