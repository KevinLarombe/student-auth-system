
<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$name = htmlspecialchars(
    $_SESSION["user_name"],
    ENT_QUOTES,
    "UTF-8"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container dashboard">
        <h1>Dashboard</h1>
        <p class="subtitle">You are successfully logged in.</p>

        <div class="welcome">
            <h2>Hello, <?= $name ?>!</h2>
            <p>Welcome to your account dashboard.</p>
            <p>Your user ID is:
                <?= (int) $_SESSION["user_id"] ?>
            </p>
        </div>

        <form method="POST" action="logout.php">
            <button type="submit" class="logout-button">
                Log Out
            </button>
        </form>
    </div>
</body>
</html>
