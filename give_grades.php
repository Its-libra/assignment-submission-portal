<?php
session_start();
include "db_connect.php";

// Update grade and remarks
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submission_id'])) {
    $submission_id = $_POST['submission_id'];
    $grade = $_POST['grade'];
    $remarks = $_POST['remarks'];

    $update_query = "UPDATE submissions SET grade='$grade', remarks='$remarks' WHERE submission_id=$submission_id";
    mysqli_query($conn, $update_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Give Grades</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
    iframe {
      border-radius: 10px;
      border: 1px solid #dee2e6;
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
  <h2 class="mb-4 text-center">Grade & Remark Submissions</h2>

  <!-- Filter Form -->
  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
      <input type="text" name="enroll" value="<?= isset($_GET['enroll']) ? htmlspecialchars($_GET['enroll']) : '' ?>" class="form-control" placeholder="Search by Enrollment No">
    </div>
    <div class="col-md-4">
      <input type="text" name="title" value="<?= isset($_GET['title']) ? htmlspecialchars($_GET['title']) : '' ?>" class="form-control" placeholder="Search by Assignment Title">
    </div>
    <div class="col-md-3">
      <select name="graded" class="form-select">
        <option value="">All</option>
        <option value="1" <?= (isset($_GET['graded']) && $_GET['graded'] == '1') ? 'selected' : '' ?>>Graded</option>
        <option value="0" <?= (isset($_GET['graded']) && $_GET['graded'] === '0') ? 'selected' : '' ?>>Not Graded</option>
      </select>
    </div>
    <div class="col-md-1">
      <button type="submit" class="btn btn-dark w-100">Filter</button>
    </div>
  </form>

  <?php if (!empty($message)) : ?>
    <div class="alert alert-info text-center"><?= $message ?></div>
  <?php endif; ?>

  <!-- Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center bg-white shadow-sm">
      <thead class="table-dark">
        <tr>
          <th>Enrollment</th>
          <th>Assignment</th>
          <th>View File</th>
          <th>Grade</th>
          <th>Remarks</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Filtering logic
        $where = "WHERE 1=1";
        if (!empty($_GET['enroll'])) {
          $enroll = mysqli_real_escape_string($conn, $_GET['enroll']);
          $where .= " AND st.enroll_no LIKE '%$enroll%'";
        }
        if (!empty($_GET['title'])) {
          $title = mysqli_real_escape_string($conn, $_GET['title']);
          $where .= " AND a.title LIKE '%$title%'";
        }
        if (isset($_GET['graded']) && $_GET['graded'] !== '') {
          $graded = $_GET['graded'] == '1' ? "IS NOT NULL" : "IS NULL";
          $where .= " AND s.grade $graded";
        }

        $query = "
          SELECT 
            s.submission_id, s.s_id, s.assignment_id, s.file_name,
            s.grade, s.remarks, st.enroll_no, a.title AS assignment_title
          FROM 
            submissions s
            INNER JOIN students st ON s.s_id = st.s_id
            INNER JOIN assignments a ON s.assignment_id = a.assignment_id
          $where
          ORDER BY s.submitted_at DESC
        ";

        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0):
          while ($row = mysqli_fetch_assoc($result)):
            $modal_id = "modal" . $row['submission_id'];
            $file_path = htmlspecialchars($row['file_name']);
        ?>
          <tr>
            <td><?= htmlspecialchars($row['enroll_no']) ?></td>
            <td><?= htmlspecialchars($row['assignment_title']) ?></td>
            <td>
              <?php if (file_exists($file_path)) : ?>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#<?= $modal_id ?>">View PDF</button>
              <?php else : ?>
                <span class="text-danger">File Missing</span>
              <?php endif; ?>
            </td>
            <form method="POST">
              <td>
 <select name="grade" class="form-select form-select-sm" required>
    <option value="">Select</option>
    <option value="A" <?= ($row['grade'] == 'A') ? 'selected' : '' ?>>A</option>
    <option value="B" <?= ($row['grade'] == 'B') ? 'selected' : '' ?>>B</option>
    <option value="C" <?= ($row['grade'] == 'C') ? 'selected' : '' ?>>C</option>
    <option value="D" <?= ($row['grade'] == 'D') ? 'selected' : '' ?>>D</option>
    <option value="F" <?= ($row['grade'] == 'F') ? 'selected' : '' ?>>F</option>
  </select>
</td>

<td>
  <select name="remarks" class="form-select form-select-sm">
    <option value="">Select</option>
    <option value="Excellent" <?= ($row['remarks'] == 'Excellent') ? 'selected' : '' ?>>Excellent</option>
    <option value="Very Good" <?= ($row['remarks'] == 'Very Good') ? 'selected' : '' ?>>Very Good</option>
    <option value="Good" <?= ($row['remarks'] == 'Good') ? 'selected' : '' ?>>Good</option>
    <option value="Bad" <?= ($row['remarks'] == 'Bad') ? 'selected' : '' ?>>Bad</option>
    <option value="Very Poor" <?= ($row['remarks'] == 'Very Poor') ? 'selected' : '' ?>>Very Poor</option>
  </select>
</td> <td>
                <input type="hidden" name="submission_id" value="<?= $row['submission_id'] ?>">
                <button type="submit" class="btn btn-success btn-sm">Save</button>
              </td>
            </form>
          </tr>

          <!-- Modal -->
          <div class="modal fade" id="<?= $modal_id ?>" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Viewing PDF: <?= basename($file_path) ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <iframe src="<?= $file_path ?>" width="100%" height="600px"></iframe>
                </div>
              </div>
            </div>
          </div>

        <?php endwhile; else: ?>
          <tr><td colspan="6" class="text-muted">No submissions found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
