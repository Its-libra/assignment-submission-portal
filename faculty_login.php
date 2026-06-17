<?php
session_start();
include "db_connect.php";

$login_error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM faculties WHERE faculty_username='$username' AND faculty_pass='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['faculty_username'] = $username;
        header("Location: faculty_dashboard.php");
        exit();
    } else {
        $login_error = "Invalid username or password!";
    }
}
?>

<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Faculty Login</title>
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

    body {
      display: flex;
      flex-direction: column;
    }

    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
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

<body>
<main>
  <div class="card">
    <h3 class="text-center mb-4">
      <i class="bi bi-person-badge-fill text-primary"></i> Faculty Login
    </h3>

    <?php if (!empty($login_error)): ?>
      <div class="alert alert-danger text-center">
        <?= $login_error ?>
      </div>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required />
      </div>
      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required />
      </div>
      <button type="submit" name="login" class="btn btn-primary btn-login">
        <i class="bi bi-box-arrow-in-right"></i> Login
      </button>
      <div class="text-center mt-3">
        <a href="faculty_forgot_password.php" class="text-decoration-none">Forgot Password?</a>
      </div>
    </form>
  </div>
</main>
</body>
</html>
<?php include "footer.php"; ?>
