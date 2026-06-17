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

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query = "
SELECT a.assignment_id, a.title, a.description, a.due_date, a.file_name
FROM assignments a
WHERE a.assignment_id NOT IN (
    SELECT assignment_id FROM submissions WHERE s_id = $student_id
)
";

if (!empty($search)) {
    $query .= " AND (a.title LIKE '%$search%' OR a.description LIKE '%$search%')";
}

$query .= " ORDER BY a.due_date ASC";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error fetching pending assignments: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Pending Assignments</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-image: url('images/image10.jpg');
      background-size: cover;
      background-position: center center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      margin: 0;
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

    .table th, .table td {
      vertical-align: middle;
      padding: 12px;
    }

    .table-hover tbody tr:hover {
      background-color: rgba(145, 214, 206, 0.3);
    }

    .table thead {
      background-color: #0d4d4d;
      color: white;
    }

    .card {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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

  <div class="content-wrapper container">
    <h3 class="mb-4 text-left"><i class="bi bi-clock-history"></i> Pending Assignments</h3>

    <!-- Search Form -->
    <form method="GET" action="" class="mb-4" style="max-width: 400px;">
      <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by title or description..." value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-dark" type="submit"><i class="bi bi-search"></i> Search</button>
      </div>
    </form>

    <div id="printArea">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm bg-white">
          <thead class="text-center">
            <tr>
              <th>Title</th>
              <th>Description</th>
              <th>Due Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php
                  $id = $row['assignment_id'];
                  $title = htmlspecialchars($row['title']);
                  $desc = htmlspecialchars($row['description']);
                  $due = htmlspecialchars($row['due_date']);
                  $file = htmlspecialchars($row['file_name']);
                  $is_overdue = (strtotime($due) < strtotime(date("Y-m-d")));
                ?>
                <tr class="<?= $is_overdue ? 'table-danger' : '' ?>">
                  <td><?= $title ?></td>
                  <td><?= $desc ?></td>
                  <td><?= $due ?></td>
                  <td>
                    <?php if (!$is_overdue): ?>
                      <a href="submit_assignment.php?assignment_id=<?= $id ?>" class="btn btn-sm btn-primary mb-1">
                        <i class="bi bi-upload"></i> Submit
                      </a>
                    <?php else: ?>
                      <span class="text-danger fw-bold">Overdue</span>
                    <?php endif; ?>

                    <?php if (!empty($file)): ?>
                      <a href="uploads/<?= $file ?>" class="btn btn-sm btn-warning mb-1" target="_blank">
                        <i class="bi bi-download"></i> Assignment File
                      </a><br>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-muted text-center">All assignments are submitted. Great job!</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php mysqli_close($conn); ?>

<script>
  function downloadSinglePDF(divId) {
    const element = document.getElementById(divId);
    const clone = element.cloneNode(true);
    clone.style.display = "block";

    const opt = {
      margin: 0.5,
      filename: divId + '.pdf',
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: { scale: 2 },
      jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(clone).save();
  }
</script>

</body>
</html>
