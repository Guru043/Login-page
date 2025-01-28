<?php
include 'db.php';

$message = ''; // Initialize a message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(32)); // Generate a secure token

    $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
    $stmt->bind_param("ss", $token, $email);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $reset_link = "http://localhost/user_system/verify_email.php?token=$token";
        $subject = "Password Reset Request";
        $messageBody = "Click the link to reset your password: $reset_link";
        $headers = "From: noreply@yourdomain.com";

        if (mail($email, $subject, $messageBody, $headers)) {
            $message = "Password reset link has been sent to your email.";
        } else {
            $message = "Failed to send email. Please check your server's mail configuration.";
        }
    } else {
        $message = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="reset_password.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required><br>
            <button type="submit">Send Reset Link</button>
        </form>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
