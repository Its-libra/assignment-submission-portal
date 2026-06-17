<?php
session_start();
include "header.php";
include "db_connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Student Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('images/image10.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      max-width: 450px;
      margin: 100px auto;
      padding: 30px;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
    }
  </style>
</head>
<body>

<div class="card">
  <h4 class="text-center mb-4">Reset Password</h4>
  <form method="POST">
    <div class="mb-3">
      <label for="enroll_no" class="form-label">Enrollment Number</label>
      <input type="text" name="enroll_no" class="form-control" required />
    </div>
    <div class="mb-3">
      <label for="new_password" class="form-label">New Password</label>
      <input type="password" name="new_password" class="form-control" required />
    </div>
    <div class="mb-3">
      <label for="confirm_password" class="form-label">Confirm Password</label>
      <input type="password" name="confirm_password" class="form-control" required />
    </div>
    <button type="submit" name="reset" class="btn btn-success w-100">Reset Password</button>
  </form>

  <?php
  if (isset($_POST['reset'])) {
      $enroll_no = $_POST['enroll_no'];
      $new_password = $_POST['new_password'];
      $confirm_password = $_POST['confirm_password'];

      if ($new_password !== $confirm_password) {
          echo "<div class='alert alert-danger mt-3'>Passwords do not match!</div>";
      } else {
          $query = "UPDATE students SET pass='$new_password' WHERE enroll_no='$enroll_no'";
          if (mysqli_query($conn, $query)) {
              echo "<div class='alert alert-success mt-3'>Password reset successfully!</div>";
          } else {
              echo "<div class='alert alert-danger mt-3'>Error resetting password. Try again.</div>";
          }
      }
  }
  ?>
</div>

</body>
</html>

<?php include "footer.php"; ?>
