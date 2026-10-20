
<?php
session_start();
require_once "db.php";

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

$email = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $error = "Please enter your email and password.";
    } else {
        $stmt = $conn->prepare(
            "SELECT id, name, password_hash
             FROM users
             WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result(
                $id,
                $name,
                $password_hash
            );
            $stmt->fetch();

            if (password_verify($password, $password_hash)) {
                session_regenerate_id(true);

                $_SESSION["user_id"] = $id;
                $_SESSION["user_name"] = $name;

                $stmt->close();
                header("Location: dashboard.php");
                exit;
            }
        }

        $stmt->close();
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome Back</h1>
        <p class="subtitle">Log in to your account.</p>

        <?php if ($error !== ""): ?>
            <p class="message error">
                <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?>"
                autocomplete="email"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >

            <button type="submit">Log In</button>
        </form>

        <p class="footer">
            Don't have an account?
            <a href="register.php">Register here</a>
        </p>
    </div>
</body>
</html>
