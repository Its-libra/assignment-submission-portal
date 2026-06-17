<?php
include("db_connect.php");

$faculty_count = 0;
$subject_count = 0;
$assignment_count = 0;
$submission_count = 0;


$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM faculties");
if ($result) {
    $data = mysqli_fetch_assoc($result);
    $faculty_count = $data['total'];
}


$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM subjects");
if ($result) {
    $data = mysqli_fetch_assoc($result);
    $subject_count = $data['total'];
}


$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM assignments");
if ($result) {
    $data = mysqli_fetch_assoc($result);
    $assignment_count = $data['total'];
}


$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM submissions");
if ($result) {
    $data = mysqli_fetch_assoc($result);
    $submission_count = $data['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap and Icons -->
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

    .dashboard-content {
      flex-grow: 1;
      padding: 30px;
    }

    h2 {
      font-weight: 600;
      margin-bottom: 30px;
    }

    .dashboard-card {
      background-color: #fff;
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      padding: 20px;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
    }

    .dashboard-card .icon {
      font-size: 2rem;
      margin-bottom: 10px;
    }

    .count {
      font-size: 2rem;
      font-weight: bold;
    }

    @media (max-width: 768px) {
      .wrapper {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }

      .dashboard-content {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<div class="wrapper">
  <!-- Sidebar -->
  <div class="sidebar">
    <h4>Admin Panel</h4>
    <a href="admin_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="admin_add_faculty.php"><i class="bi bi-person-plus-fill"></i> Add Faculty</a>
    <a href="admin_add_subject.php"><i class="bi bi-journal-plus"></i> Add Subject</a>
    <a href="admin_view_faculty.php"><i class="bi bi-people-fill"></i> View Faculty</a>
    <a href="view_subjects.php"><i class="bi bi-journal-bookmark-fill"></i> View Subjects</a>
    <a href="view_assignments.php"><i class="bi bi-clipboard-check"></i> View Assignments</a>
    <a href="view_submissions.php"><i class="bi bi-file-earmark-text"></i> View Submissions</a>
    <a href="index.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>

  <!-- Main Dashboard Content -->
  <div class="dashboard-content container-fluid">
    <h2>Welcome, Admin</h2>

    <div class="row g-4">
      <div class="col-12 col-md-6 col-lg-3">
        <div class="dashboard-card text-center border-top border-4 border-dark">
          <div class="icon text-dark"><i class="bi bi-person-fill"></i></div>
          <h5>Total Faculty</h5>
          <div class="count"><?php echo $faculty_count; ?></div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="dashboard-card text-center border-top border-4 border-dark">
          <div class="icon text-dark"><i class="bi bi-book-fill"></i></div>
          <h5>Total Subjects</h5>
          <div class="count"><?php echo $subject_count; ?></div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="dashboard-card text-center border-top border-4 border-dark">
          <div class="icon text-dark"><i class="bi bi-clipboard-data"></i></div>
          <h5>Total Assignments</h5>
          <div class="count"><?php echo $assignment_count; ?></div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="dashboard-card text-center border-top border-4 border-dark">
          <div class="icon text-dark"><i class="bi bi-file-earmark-check-fill"></i></div>
          <h5>Total Submissions</h5>
          <div class="count"><?php echo $submission_count; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
