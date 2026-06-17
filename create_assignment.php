<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "root", "", "assignment_portal");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$success_msg = "";
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $due_date = $_POST['due_date'] ?? '';
    $sub_id = $_POST['sub_id'] ?? '';
    $file_name = "";

    if (isset($_FILES['assignment_file']) && $_FILES['assignment_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $original_name = basename($_FILES['assignment_file']['name']);
        $file_tmp = $_FILES['assignment_file']['tmp_name'];
        $file_name = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $original_name);
        $target_path = $upload_dir . $file_name;

        if (!move_uploaded_file($file_tmp, $target_path)) {
            $error_msg = "Failed to upload file.";
        }
    }

    if ($title && $description && $due_date && $sub_id && !$error_msg) {
        $sql = "INSERT INTO assignments (title, description, due_date, sub_id, file_name) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssis", $title, $description, $due_date, $sub_id, $file_name);
            if (mysqli_stmt_execute($stmt)) {
                $success_msg = "Assignment created successfully.";
            } else {
                $error_msg = "Error inserting assignment: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error_msg = "Failed to prepare statement: " . mysqli_error($conn);
        }
    } elseif (!$error_msg) {
        $error_msg = "Please fill in all required fields.";
    }
}

$subject_query = "SELECT sub_id, sub_name FROM subjects";
$subjects = mysqli_query($conn, $subject_query);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Assignment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
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
      padding: 40px;
    }
    .card {
      max-width: 700px;
      margin: auto;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      background-color: white;
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
    <div class="card">
      <h3 class="mb-4 text-center"><i class="bi bi-journal-plus"></i> Create Assignment</h3>

      <?php if ($success_msg): ?>
        <div class="alert alert-success"><?php echo $success_msg; ?></div>
      <?php endif; ?>

      <?php if ($error_msg): ?>
        <div class="alert alert-danger"><?php echo $error_msg; ?></div>
      <?php endif; ?>

      <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="title" class="form-label">Assignment Title</label>
          <input type="text" class="form-control" id="title" name="title" required
            value="<?php echo htmlspecialchars($_POST['title'] ?? '', ENT_QUOTES); ?>">
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES); ?></textarea>
        </div>

        <div class="mb-3">
          <label for="sub_id" class="form-label">Select Subject</label>
          <select class="form-select" name="sub_id" id="sub_id" required>
            <option value="" disabled <?php echo !isset($_POST['sub_id']) ? 'selected' : ''; ?>>Choose subject</option>
            <?php
              if ($subjects && mysqli_num_rows($subjects) > 0) {
                  while ($row = mysqli_fetch_assoc($subjects)) {
                      $selected = (isset($_POST['sub_id']) && $_POST['sub_id'] == $row['sub_id']) ? 'selected' : '';
                      echo "<option value='{$row['sub_id']}' $selected>{$row['sub_name']}</option>";
                  }
              } else {
                  echo "<option disabled>No subjects available</option>";
              }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="due_date" class="form-label">Due Date</label>
          <input type="date" class="form-control" id="due_date" name="due_date" required
            value="<?php echo htmlspecialchars($_POST['due_date'] ?? '', ENT_QUOTES); ?>">
        </div>

        <div class="mb-3">
          <label for="assignment_file" class="form-label">Upload File</label>
          <input type="file" class="form-control" name="assignment_file" id="assignment_file" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Create Assignment</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
