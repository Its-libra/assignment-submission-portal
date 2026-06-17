<?php include "header.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Assignment Portal - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('images/image10.jpg') no-repeat center center / cover;
      min-height: 100vh;
    }

    .container-center {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .login-card {
      background-color: rgba(255, 255, 255, 0.95);
      color: #333;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
      text-align: center;
      width: 100%;
      max-width: 420px;
      transition: transform 0.3s ease-in-out;
    }

    .login-card:hover {
      transform: translateY(-5px);
    }

    .login-card h2 {
      font-weight: bold;
      margin-bottom: 10px;
      color: #004d40;
    }

    .login-card p {
      margin-bottom: 25px;
      font-size: 16px;
    }

    .btn-login {
      width: 100%;
      font-size: 18px;
      padding: 12px;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all 0.3s ease-in-out;
    }

    .btn-login:hover {
      opacity: 0.95;
      transform: scale(1.03);
    }

    .footer-text {
      font-size: 14px;
      margin-top: 20px;
      color: #777;
    }
  </style>
</head>

<body>

  <div class="container-center">
    <div class="login-card">
      <h2><i class="bi bi-box-arrow-in-right me-2"></i>Login Portal</h2>
      <p>Select your role to proceed</p>

      <a href="admin_login.php" class="btn btn-danger btn-login">
        <i class="bi bi-shield-lock-fill"></i> Admin
      </a>

      <a href="faculty_login.php" class="btn btn-primary btn-login">
        <i class="bi bi-person-badge-fill"></i> Faculty
      </a>

      <a href="student_login.php" class="btn btn-success btn-login">
        <i class="bi bi-person-circle"></i> Student
      </a>

    </div>
  </div>

</body>
<?php include "footer.php" ?>
</html>
