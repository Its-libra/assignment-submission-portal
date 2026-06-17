<?php include "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About - Assignment Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Arial', sans-serif;
      scroll-behavior: smooth;
    }

    .about-section {
      background: url('images/image10.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    .content {
      background-color: rgba(255, 255, 255, 0.38);
      padding: 30px;
      max-width: 800px;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      animation: fadeIn 1s ease-in-out;
      color: #004d40;
    }

    h2 {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 20px;
    }

    p {
      font-size: 1.2rem;
      line-height: 1.6;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      .content {
        padding: 20px;
      }

      h2 {
        font-size: 1.5rem;
      }

      p {
        font-size: 1rem;
      }
    }

    /* Footer style (in case not already styled in footer.php) */
    footer {
      background-color: #00796b;
      color: #fff;
      padding: 15px 0;
      text-align: center;
      font-size: 1rem;
    }
  </style>
</head>

<body>

  <div class="about-section">
    <div class="content">
      <h2>About Assignment Portal</h2>
      <p>
        The Assignment Portal is a simple and efficient system for managing assignments online. It helps students submit their work, faculty to review it, and admins to oversee the process smoothly.
      </p>
      <p>
        We aim to simplify assignment management for schools and colleges through digital efficiency and easy communication.
      </p>
    </div>
  </div>

  <?php include "footer.php"; ?> 

</body>
</html>
