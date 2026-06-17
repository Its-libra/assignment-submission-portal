<?php
// ✅ Always at the top before any output
session_start();

// ✅ Database connection
$conn = mysqli_connect("localhost", "root", "", "assignment_portal");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ✅ Handle form submission
if (isset($_POST['login'])) {
    $enroll_no = trim($_POST['enroll_no']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM students WHERE enroll_no = '$enroll_no' AND pass = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['enroll_no'] = $enroll_no; // ✅ SESSION SET
        header("Location: student_dashboard.php"); // ✅ REDIRECT
        exit();
    } else {
        echo "<script>alert('Invalid enrollment number or password');</script>";
    }
}
?>

<?php include "header.php"; ?> <!-- ✅ Include after PHP logic -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('images/image10.jpg') no-repeat center center fixed;
      background-size: cover;
    }

    .card {
      max-width: 420px;
      width: 100%;
      padding: 30px;
      border-radius: 15px;
      background-color: rgba(255, 255, 255, 0.9);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(4px);
    }

    .btn-login {
      width: 100%;
      padding: 10px;
      font-size: 16px;
    }
  </style>
</head>

<!-- ✅ Important: Flex layout to stick footer at bottom -->
<body style="min-height: 100vh; display: flex; flex-direction: column;">

<main style="flex: 1; display: flex; justify-content: center; align-items: center;">
  <div class="card">
    <h3 class="text-center mb-4">
      <i class="bi bi-person-circle text-primary"></i> Student Login
    </h3>

    <form action="" method="POST">
  <div class="mb-3">
    <label for="enroll_no" class="form-label">Enrollment No</label>
    <input type="text" class="form-control" id="enroll_no" name="enroll_no" required />
  </div>
  <div class="mb-4">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required />
  </div>
  <button type="submit" name="login" class="btn btn-primary btn-login">
    <i class="bi bi-box-arrow-in-right"></i> Login
  </button>
  <div class="text-center mt-3">
    <a href="student_forgot_password.php" class="text-decoration-none">Forgot Password?</a>
  </div>
</form>

  </div>
</main>

<?php include "footer.php"; ?> <!-- ✅ Footer will stay at bottom -->

</body>
</html>
