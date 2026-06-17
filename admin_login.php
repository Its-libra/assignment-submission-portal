<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Login</title>
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

    .card h3 {
      font-weight: bold;
      color: #333;
    }

    .btn-login {
      width: 100%;
      font-size: 16px;
      padding: 10px;
    }
  </style>
</head>

<body>

<main>
  <div class="card">
    <h3 class="text-center mb-4">
      <i class="bi bi-shield-lock-fill text-primary"></i> Admin Login
    </h3>
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
    </form>
    <p class="text-center mt-3">Not registered? 
      <a href="register_admin.php">Register here</a>
    </p>
  </div>
</main>
</body>
<?php include "footer.php" ?>
<?php
include 'db_connect.php'; 

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $url = "admin_dashboard.php?user=" . urlencode($username);
        echo "<html><head>";
        echo "<meta http-equiv='refresh' content='0;url=$url'>";
        echo "</head><body></body></html>";
        exit();
    } else {
        $url = "admin_login.php?error=1";
        echo "<html><head>";
        echo "<meta http-equiv='refresh' content='0;url=$url'>";
        echo "</head><body></body></html>";
        exit();
    }
}
?>
</html>


