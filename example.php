<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Assignment Submission Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Arial', sans-serif;
      color: rgb(18, 145, 123);
      overflow-x: hidden;
    }
    .navbar {
      background-color: #00796b;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    .navbar-brand {
      font-size: 1.5rem;
      font-weight: bold;
      color: #ffffff !important;
    }
    .nav-link {
      color: #ffffff !important;
      font-weight: 500;
      transition: color 0.3s;
    }
    .nav-link:hover {
      color: rgb(19, 160, 144) !important;
    }
    .hero {
      position: relative;
      background: url('images/image10.jpg') no-repeat center center / cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .hero::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background-color: rgba(255, 255, 255, 0.4);
      z-index: 1;
    }
    .hero-content {
      position: relative;
      z-index: 2;
      animation: fadeIn 0.6s ease-in-out;
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
      color: #004d40;
      text-shadow: 2px 2px 6px rgba(255, 255, 255, 0.8);
    }
    .hero p {
      font-size: 1.25rem;
      margin-top: 15px;
      color: #004d40;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @media (max-width: 768px) {
      .hero h1 {
        font-size: 2rem;
      }

      .hero p {
        font-size: 1rem;
      }
    }
    .footer {
      background-color: #004d40;
      color: #ffffff;
      padding: 40px 0;
      text-align: center;
    }
    .footer a {
      color: #ffffff;
      text-decoration: none;
    }
    .footer a:hover {
      color: rgb(9, 125, 104);
      text-decoration: underline;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark px-4">
  <a class="navbar-brand" href="menu.php">
    <i class="bi bi-clipboard-check-fill me-2"></i> Assignment Portal
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarContent">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <a class="nav-link" href="menu.php"><i class="bi bi-house-door-fill"></i> Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php"><i class="bi bi-info-circle-fill"></i> About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class="bi bi-person-circle"></i> Login</a>
      </li>
    </ul>
  </div>
</nav>
<section class="hero">
  <div class="hero-content text-white">
    <h1>Welcome to the Assignment Submission Portal</h1>
    <p>Submit, review, and manage assignments online – fast and easy!</p>
  </div>
</section>

<footer class="footer text-center">
  <div class="container">
    <p>&copy; 2025 Assignment Submission Portal. All Rights Reserved.</p>
    <p>
      <a href="menu.php"><i class="bi bi-house-door-fill"></i> Home</a> |
      <a href="index.php"><i class="bi bi-person-circle"></i> Login</a>
    </p>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>