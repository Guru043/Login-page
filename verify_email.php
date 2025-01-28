<?php
include 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT email FROM users WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();

    if ($email) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $stmt = $conn->prepare("UPDATE users SET password_hash = ?, reset_token = NULL WHERE email = ?");
            $stmt->bind_param("ss", $new_password, $email);

            if ($stmt->execute()) {
                echo "Password updated successfully. <a href='login.php'>Login here</a>";
            } else {
                echo "Error updating password.";
            }
        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Enter New Password</h2>
    <form method="POST">
        <input type="password" name="password" placeholder="Enter new password" required><br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
