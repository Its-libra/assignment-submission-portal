<?php include "header.php"; ?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // PHPMailer

$conn = mysqli_connect("localhost", "root", "", "assignment_portal");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $check = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already registered!";
    } else {
        $sql = "INSERT INTO admins (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            // Send welcome email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'makwanatanvi680@gmail.com';  // your Gmail
                $mail->Password = 'jehn yhft nkiu mlsc';     // your Gmail App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('your_email@gmail.com', 'Assignment Portal');
                $mail->addAddress($email, $username);

                $mail->isHTML(true);
                $mail->Subject = 'Welcome to Assignment Portal';
                $mail->Body = "
                    <h3>Welcome, $username!</h3>
                    <p>Your admin account has been successfully created.</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Login here:</strong> <a href='http://localhost/admin_login.php'>Admin Login</a></p>
                    <br><p>Thank you,<br>Assignment Portal Team</p>
                ";
                $mail->AltBody = "Welcome $username, your admin account has been created.";

                $mail->send();
                $success = "Admin registered and email sent successfully!";
            } catch (Exception $e) {
                $success = "Admin registered, but email could not be sent.";
                $error .= " Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $error = "Registration failed. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            background: url("images/image10.jpg");
        }

        .content {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5 content">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Admin Registration</h4>
                </div>
                <div class="card-body">
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php elseif ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Register</button>
                        <p class="mt-3 text-center">
                            Already Registered? <a href="admin_login.php">Login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
</body>
</html>
