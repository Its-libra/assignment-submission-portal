<?php
session_start();

if (!isset($_SESSION['enroll_no'])) {
    header("Location: student_login.php");
    exit();
}

$enroll_no = $_SESSION['enroll_no'];

$conn = mysqli_connect("localhost", "root", "", "assignment_portal");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$student_query = "SELECT s_id FROM students WHERE enroll_no = '$enroll_no'";
$student_result = mysqli_query($conn, $student_query);
$student_row = mysqli_fetch_assoc($student_result);
$student_id = $student_row['s_id'] ?? 0;

if (!$student_id) {
    die("Student not found.");
}

// Handle search filter
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query = "
SELECT a.title, a.description, a.due_date, s.grade, s.remarks, s.submitted_at
FROM assignments a
JOIN submissions s ON a.assignment_id = s.assignment_id
WHERE s.s_id = $student_id AND s.grade IS NOT NULL
";

if (!empty($search)) {
    $query .= " AND (a.title LIKE '%$search%' OR a.description LIKE '%$search%' OR s.remarks LIKE '%$search%')";
}

$query .= " ORDER BY s.submitted_at DESC";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error fetching graded assignments: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Graded Assignments</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-image: url('images/image10.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      margin: 0;
    }

    .wrapper {
      display: flex;
      min-height: 100vh;
      background-color: rgba(255, 255, 255, 0.92);
    }

    .sidebar {
      flex-shrink: 0;
      width: 250px;
      background-color: rgb(145, 214, 206);
      color: black;
      padding-top: 1rem;
      position: sticky;
      top: 0;
      height: 100vh;
    }

    .sidebar h4 {
      text-align: center;
      margin-bottom: 1.5rem;
      font-weight: 600;
    }

    .sidebar a {
      color: black;
      text-decoration: none;
      display: block;
      padding: 15px 20px;
      font-weight: 500;
      transition: background-color 0.3s ease;
    }

    .sidebar a:hover {
      background-color: #0d4d4d;
      color: white;
    }

    .content-wrapper {
      flex-grow: 1;
      padding: 40px;
    }

    .card {
      background-color: rgb(145, 214, 206);
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
    }

    .table thead {
      background-color: #0d4d4d;
      color: white;
    }

    .form-control::placeholder {
      color: #666;
    }

    @media (max-width: 767.98px) {
      .wrapper {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
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
    <h4>Student Panel</h4>
    <a href="student_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="submit_assignment.php"><i class="bi bi-upload"></i> Upload Assignment</a>
    <a href="view_pending.php"><i class="bi bi-clock-history"></i> Pending Assignments</a>
    <a href="graded_assignments.php"><i class="bi bi-check2-circle"></i> Graded Assignments</a>
    <a href="index.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </nav>

  <main class="content-wrapper container">
      <h3 class="mb-4 text-left"><i class="bi bi-check2-circle"></i> Graded Assignments</h3>

      <!-- Search Form -->
      <form method="GET" class="mb-4" style="max-width: 400px;">
        <div class="input-group">
          <input type="text" name="search" class="form-control" placeholder="Search title, description, or remarks..." value="<?= htmlspecialchars($search) ?>">
          <button class="btn btn-dark" type="submit"><i class="bi bi-search"></i> Search</button>
        </div>
      </form>

      <table class="table table-bordered table-striped bg-white shadow-sm">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Due Date</th>
            <th>Submitted On</th>
            <th>Grade</th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['title']); ?></td>
              <td><?php echo htmlspecialchars($row['description']); ?></td>
              <td><?php echo htmlspecialchars($row['due_date']); ?></td>
              <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
              <td><?php echo htmlspecialchars($row['grade']); ?></td>
              <td><?php echo htmlspecialchars($row['remarks']); ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center text-muted">No graded assignments available yet.</td>
          </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<?php mysqli_close($conn); ?>
</body>
</html>
