<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($password_hash);
    $stmt->fetch();

    if (password_verify($password, $password_hash)) {
        echo "<div class='container'>Login successful. <a href='index.html'>Go to Home</a></div>";
    } else {
        echo "<div class='container'>Invalid email or password.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <a href="reset_password.php">Forgot Password?</a>
        <br><br>
        <button onclick="navigateToRegister()">Not a user? Register</button>
    </div>

    <script>
        // Redirect to the registration page
        function navigateToRegister() {
            window.location.href = "register.php";
        }
    </script>
</body>
</html>
