<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "root", "", "assignment_portal");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$success_msg = "";
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enroll_no = trim($_POST['student_enroll_no'] ?? '');
    $assignment_id = $_POST['assignment_id'] ?? '';
    $subject_id = $_POST['subject_id'] ?? '';
    $sub_code = $_POST['sub_code'] ?? '';

    if (!isset($_FILES['submission_file']) || $_FILES['submission_file']['error'] !== 0) {
        $error_msg = "Please upload your assignment file (PDF).";
    } else {
        $stmt_lookup = mysqli_prepare($conn, "SELECT s_id FROM students WHERE enroll_no = ?");
        mysqli_stmt_bind_param($stmt_lookup, "s", $enroll_no);
        mysqli_stmt_execute($stmt_lookup);
        mysqli_stmt_bind_result($stmt_lookup, $student_id);
        mysqli_stmt_fetch($stmt_lookup);
        mysqli_stmt_close($stmt_lookup);

        if (!$student_id) {
            $error_msg = "Enrollment number not found. Please enter a valid enrollment number.";
        } else {
            $file_name = $_FILES['submission_file']['name'];
            $file_tmp = $_FILES['submission_file']['tmp_name'];
            $file_type = $_FILES['submission_file']['type'];

            $allowed_types = ['application/pdf'];
            if (!in_array($file_type, $allowed_types)) {
                $error_msg = "Only PDF files are allowed.";
            } else {
                $upload_dir = "uploads/";
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $new_file_name = $upload_dir . time() . "_" . basename($file_name);

                if (move_uploaded_file($file_tmp, $new_file_name)) {
                    $stmt_insert = mysqli_prepare($conn, "INSERT INTO submissions (assignment_id, s_id, file_name, file_type, submitted_at) VALUES (?, ?, ?, ?, NOW())");
                    mysqli_stmt_bind_param($stmt_insert, "iiss", $assignment_id, $student_id, $new_file_name, $file_type);

                    if (mysqli_stmt_execute($stmt_insert)) {
                        $success_msg = "Assignment submitted successfully!";
                    } else {
                        $error_msg = "Database error: " . mysqli_error($conn);
                        unlink($new_file_name);
                    }
                    mysqli_stmt_close($stmt_insert);
                } else {
                    $error_msg = "Failed to upload the file.";
                }
            }
        }
    }
}

// ✅ Modified to exclude overdue assignments
$assignment_query = "SELECT assignment_id, title FROM assignments WHERE due_date >= CURDATE() ORDER BY due_date DESC";
$assignments = mysqli_query($conn, $assignment_query);

$subject_query = "SELECT sub_id, sub_name, sub_code FROM subjects ORDER BY sub_name ASC";
$subjects = mysqli_query($conn, $subject_query);

$subjects_array = [];
if ($subjects && mysqli_num_rows($subjects) > 0) {
    while ($row = mysqli_fetch_assoc($subjects)) {
        $subjects_array[$row['sub_id']] = [
            'name' => $row['sub_name'],
            'code' => $row['sub_code']
        ];
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Submit Assignment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
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

    .card {
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      padding: 30px;
      background-color: #fff;
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
    <div class="card">
      <h3 class="mb-4 text-center"><i class="bi bi-upload"></i> Submit Assignment</h3>

      <?php if ($success_msg): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success_msg); ?></div>
      <?php endif; ?>

      <?php if ($error_msg): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_msg); ?></div>
      <?php endif; ?>

      <form action="" method="POST" enctype="multipart/form-data" novalidate>
        <div class="mb-3">
          <label for="student_enroll_no" class="form-label">Your Enrollment Number</label>
          <input type="text" class="form-control" id="student_enroll_no" name="student_enroll_no" required
            value="<?php echo htmlspecialchars($_POST['student_enroll_no'] ?? '', ENT_QUOTES); ?>">
        </div>

        <div class="mb-3">
          <label for="subject_id" class="form-label">Select Subject Name</label>
          <select class="form-select" id="subject_id" name="subject_id" required>
            <option value="" disabled <?php echo !isset($_POST['subject_id']) ? 'selected' : ''; ?>>Select Subject</option>
            <?php foreach ($subjects_array as $sub_id => $subject): 
              $selected = (isset($_POST['subject_id']) && $_POST['subject_id'] == $sub_id) ? 'selected' : '';
            ?>
              <option value="<?php echo $sub_id; ?>" <?php echo $selected; ?>>
                <?php echo htmlspecialchars($subject['name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="assignment_id" class="form-label">Select Assignment</label>
          <select class="form-select" id="assignment_id" name="assignment_id" required>
            <option value="" disabled <?php echo !isset($_POST['assignment_id']) ? 'selected' : ''; ?>>Select Assignment</option>
            <?php
              if ($assignments && mysqli_num_rows($assignments) > 0) {
                  while ($row = mysqli_fetch_assoc($assignments)) {
                      $selected = (isset($_POST['assignment_id']) && $_POST['assignment_id'] == $row['assignment_id']) ? 'selected' : '';
                      echo "<option value='{$row['assignment_id']}' $selected>" . htmlspecialchars($row['title']) . "</option>";
                  }
              } else {
                  echo "<option disabled>No upcoming assignments available</option>";
              }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="submission_file" class="form-label">Upload Assignment (PDF only)</label>
          <input type="file" class="form-control" id="submission_file" name="submission_file" accept="application/pdf" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-success">Submit Assignment</button>
        </div>
      </form>
    </div>
  </main>
</div>
</body>
</html>
