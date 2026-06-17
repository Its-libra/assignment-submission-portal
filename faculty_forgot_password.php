<?php
include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Faculty Forgot Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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
      background-color: rgba(255,255,255,0.95);
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
    }
  </style>
</head>
<body>
  <div class="card">
    <h4 class="text-center mb-4">Reset Password</h4>
    <form method="POST" action="">
      <div class="mb-3">
        <label for="username" class="form-label">Enter Your Username</label>
        <input type="text" name="username" class="form-control" required />
      </div>
      <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" name="new_password" class="form-control" required />
      </div>
      <div class="mb-4">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" required />
      </div>
      <button type="submit" name="reset" class="btn btn-success w-100">Reset Password</button>
    </form>

    <?php
    if (isset($_POST['reset'])) {
        include "db_connect.php";
        $username = $_POST['username'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password !== $confirm_password) {
            echo "<div class='alert alert-danger mt-3'>Passwords do not match!</div>";
        } else {
            $update = "UPDATE faculties SET faculty_pass='$new_password' WHERE faculty_username='$username'";
            if (mysqli_query($conn, $update)) {
                echo "<div class='alert alert-success mt-3'>Password updated successfully!</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Failed to update password. Try again.</div>";
            }
        }
    }
    ?>
  </div>
</body>
</html>

<?php include "footer.php"; ?>
