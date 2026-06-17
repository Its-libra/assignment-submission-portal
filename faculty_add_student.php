<?php
include 'db_connect.php';
session_start();

// Insert logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);
    $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $enrollment = mysqli_real_escape_string($conn, $_POST['enrollment']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);

    // Insert student
    $insert_query = "INSERT INTO students (faculty_id, s_name, enroll_no, s_email, pass) 
                     VALUES ('$faculty_id', '$student_name', '$enrollment', '$email', '$password')";

    if (mysqli_query($conn, $insert_query)) {
        $success_message = "Student added successfully!";
    } else {
        $error_message = "Error adding student: " . mysqli_error($conn);
    }
}

$sql = "SELECT faculty_id, faculty_name FROM faculties";
$result = mysqli_query($conn, $sql);

$faculties = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $faculties[] = $row;
    }
} else {
    die("Error fetching faculties: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add Student - Assign Faculty</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
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
    .card {
      max-width: 600px;
      margin: auto;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      background-color: #fff;
    }
    .form-label {
      font-weight: 500;
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
  <div class="sidebar p3">
    <h4>Faculty Panel</h4>
    <a href="faculty_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="faculty_add_student.php"><i class="bi bi-person-plus-fill"></i> Add Students</a>
    <a href="faculty_student_view.php"><i class="bi bi-people-fill"></i> View Students</a>
    <a href="create_assignment.php"><i class="bi bi-journal-plus"></i> Create Assignments</a>
    <a href="view_assignments_faculty.php"><i class="bi bi-journal-text"></i> View Assignments</a>
    <a href="view_submissions_faculty.php"><i class="bi bi-folder-symlink"></i> View Submissions</a>
    <a href="give_grades.php"><i class="bi bi-check2-square"></i> Grade & Remarks</a>
    <a href="index.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>

  <!-- Main Content -->
  <div class="content-wrapper">
    <div class="card">
      <h3 class="mb-4 text-center"><i class="bi bi-person-plus-fill"></i> Add New Student</h3>
      <?php if (!empty($success_message)): ?>
  <div class="alert alert-success"><?php echo $success_message; ?></div>
<?php endif; ?>
<?php if (!empty($error_message)): ?>
  <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>

      <form action="" method="POST">

        <div class="mb-3">
          <label for="faculty_id" class="form-label">Assign Faculty</label>
          <select id="faculty_id" name="faculty_id" class="form-select" required>
            <option value="" disabled selected>-- Select Faculty --</option>
            <?php foreach ($faculties as $faculty): ?>
              <option value="<?php echo htmlspecialchars($faculty['faculty_id']); ?>">
                <?php echo htmlspecialchars($faculty['faculty_name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="student_name" class="form-label">Full Name</label>
          <input type="text" id="student_name" name="student_name" class="form-control" required />
        </div>

        <div class="mb-3">
          <label for="enrollment" class="form-label">Enrollment Number</label>
          <input type="text" id="enrollment" name="enrollment" class="form-control" required />
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email ID</label>
          <input type="email" id="email" name="email" class="form-control" required />
        </div>

        <div class="mb-3">
          <label for="pass" class="form-label">Password</label>
          <input type="password" id="pass" name="pass" class="form-control" required />
        </div>

        <button type="submit" class="btn btn-success w-100">Add Student</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
