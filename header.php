<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Assignment Submission Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5.2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      color:rgb(18, 145, 123); 
      overflow-x: hidden;
    }

    .navbar {
      background-color: #00796b; 
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .navbar-brand {
      font-size: 1.5rem;
      font-weight: bold;
      color:rgb(255, 255, 255) !important;
    }

    .nav-link {
      color: #ffffff !important;
      font-weight: 500;
      transition: color 0.3s;
    }

    .nav-link:hover {
      color:rgb(19, 160, 144) !important; 
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
</body>
</html>
