<?php
include("db_connect.php");
session_start();

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// Fetch admins for dropdown
$admins_sql = "SELECT admin_id, username FROM admins";
$admins_result = mysqli_query($conn, $admins_sql);

// Handle form submit
if (isset($_POST['add_faculty'])) {
    $name = mysqli_real_escape_string($conn, $_POST['faculty_name']);
    $username = mysqli_real_escape_string($conn, $_POST['faculty_username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);
    $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);

    // Insert into database
    $insert_query = "INSERT INTO faculties (faculty_name, faculty_username, faculty_email, faculty_pass, admin_id) 
                     VALUES ('$name', '$username', '$email', '$password', '$admin_id')";

    if (mysqli_query($conn, $insert_query)) {
        // Send welcome email to the entered email address
        $mail = new PHPMailer(true);

        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'makwanatanvi680@gmail.com';         // <-- Your Gmail
            $mail->Password   = 'jehn yhft nkiu mlsc';            // <-- App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('your_email@gmail.com', 'Admin - Assignment Portal');
            $mail->addAddress($email, $name);  // <- faculty's email from form

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Assignment Portal';
            $mail->Body    = "
                <h3>Dear $name,</h3>
                <p>You have been successfully added as a <strong>Faculty Member</strong> to the Assignment Portal.</p>
                <p><strong>Username:</strong> $username</p>
                <p><strong>Password:</strong> (hidden for security)</p>
                <p>Please log in and change your password after your first login.</p>
                <br>
                <p>Regards,<br>Admin Team</p>
            ";
            $mail->AltBody = "Dear $name,\nYou have been added as a faculty member.\nUsername: $username\n\nRegards,\nAdmin Team";

            $mail->send();
            echo "<script>alert('Faculty added and email sent successfully.');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Faculty added, but email could not be sent. Error: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('Error adding faculty.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Faculty - Admin Panel</title>
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

    .content {
      flex-grow: 1;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .card {
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      background-color: #fff;
      width: 100%;
      max-width: 600px;
    }

    .form-label {
      font-weight: 500;
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

      .content {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<div class="wrapper">
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

  <div class="content">
    <div class="card">
      <h3 class="mb-4 text-center"><i class="bi bi-person-plus-fill"></i> Add New Faculty</h3>
      <form method="POST" action="">
        <div class="mb-3">
          <label for="faculty_name" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="faculty_name" name="faculty_name" required>
        </div>
        <div class="mb-3">
          <label for="faculty_username" class="form-label">Username</label>
          <input type="text" class="form-control" id="faculty_username" name="faculty_username" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email ID</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="pass" class="form-label">Faculty Password</label>
          <input type="password" class="form-control" id="pass" name="pass" required>
        </div>
        <div class="mb-3">
          <label for="admin_id" class="form-label">Assign to Admin</label>
          <select id="admin_id" name="admin_id" class="form-select" required>
            <option value="" disabled selected>Select Admin</option>
            <?php while ($admin = mysqli_fetch_assoc($admins_result)): ?>
              <option value="<?= $admin['admin_id'] ?>"><?= htmlspecialchars($admin['username']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="d-grid">
          <button type="submit" name="add_faculty" class="btn btn-success">Add Faculty</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php mysqli_close($conn); ?>
</body>
</html>
