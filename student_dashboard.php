<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "assignment_portal");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['enroll_no'])) {
    header("Location: student_login.php");
    exit();
}

$enroll_no = $_SESSION['enroll_no'];

// Get student ID
$student_query = "SELECT s_id FROM students WHERE enroll_no = '$enroll_no'";
$student_result = mysqli_query($conn, $student_query);
$student_data = mysqli_fetch_assoc($student_result);
$s_id = $student_data['s_id'];

// Uploaded Assignments
$uploaded_query = "SELECT COUNT(*) AS uploaded_count FROM submissions WHERE s_id = $s_id";
$uploaded_result = mysqli_query($conn, $uploaded_query);
$uploaded_count = mysqli_fetch_assoc($uploaded_result)['uploaded_count'];

// Graded Assignments
$graded_query = "SELECT COUNT(*) AS graded_count FROM submissions WHERE s_id = $s_id AND grade IS NOT NULL";
$graded_result = mysqli_query($conn, $graded_query);
$graded_count = mysqli_fetch_assoc($graded_result)['graded_count'];

// All Pending Assignments
$pending_query = "
SELECT COUNT(*) AS pending_count FROM assignments 
WHERE assignment_id NOT IN (
    SELECT assignment_id FROM submissions WHERE s_id = $s_id
)
";
$pending_result = mysqli_query($conn, $pending_query);
$pending_count = mysqli_fetch_assoc($pending_result)['pending_count'];
// Overdue Assignments
$overdue_query = "
SELECT COUNT(*) AS overdue_count FROM assignments 
WHERE assignment_id NOT IN (
    SELECT assignment_id FROM submissions WHERE s_id = $s_id
) AND due_date < CURDATE()
";
$overdue_result = mysqli_query($conn, $overdue_query);
$overdue_count = mysqli_fetch_assoc($overdue_result)['overdue_count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-image: url('images/image10.jpg');
      background-repeat: no-repeat;
      background-position: center center;
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
      text-align: center;
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
  <!-- Sidebar -->
  <nav class="sidebar">
    <h4>Student Panel</h4>
    <a href="student_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="submit_assignment.php"><i class="bi bi-upload"></i> Upload Assignment</a>
    <a href="view_pending.php"><i class="bi bi-clock-history"></i> Pending Assignments</a>
    <a href="graded_assignments.php"><i class="bi bi-check2-circle"></i> Graded Assignments</a>
    <a href="index.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </nav>

  <!-- Main Content -->
  <main class="content-wrapper container-fluid">
  <h2>Welcome, <?php echo htmlspecialchars($enroll_no); ?></h2>

  <div class="row g-4">
    <div class="col-12 col-md-3">
      <div class="dashboard-card border-top border-4 border-dark">
        <div class="icon text-dark"><i class="bi bi-upload"></i></div>
        <h5>Assignments Uploaded</h5>
        <div class="count"><?php echo $uploaded_count; ?></div>
      </div>
    </div>

    <div class="col-12 col-md-3">
      <div class="dashboard-card border-top border-4 border-dark">
        <div class="icon text-dark"><i class="bi bi-clock-history"></i></div>
        <h5>Pending Assignments</h5>
        <div class="count"><?php echo $pending_count; ?></div>
      </div>
    </div>

    <div class="col-12 col-md-3">
      <div class="dashboard-card border-top border-4 border-dark">
        <div class="icon text-dark"><i class="bi bi-check2-circle"></i></div>
        <h5>Graded Assignments</h5>
        <div class="count"><?php echo $graded_count; ?></div>
      </div>
    </div>

    <div class="col-12 col-md-3">
      <div class="dashboard-card border-top border-4 border-danger">
        <div class="icon text-danger"><i class="bi bi-exclamation-triangle-fill"></i></div>
        <h5>Overdue Assignments</h5>
        <div class="count"><?php echo $overdue_count; ?></div>
      </div>
    </div>
  </div>
</main>

</div>

</body>
</html>
