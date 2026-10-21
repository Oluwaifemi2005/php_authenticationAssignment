
<?php

$userName = "Manny";


session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_key'])) {
    header("Location: login.php");
    exit;
}

$pageTitle = "Dashboard";
$user = $_SESSION['user_key'];
$fullname = $user['fn'];
$email = $user['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="dashboard">

        <header class="dashboard-header">
            <h2>MyDashboard</h2>

            <nav>
                <a href="dashboard.php">Home</a>
                <a href="signup.php">Sign Up</a>
                <a href="login.php">Login</a>
            </nav>
        </header>

        <main class="dashboard-content">
            <h1>Welcome, <?php echo htmlspecialchars($fullname); ?>! </h1>

            <p>You have successfully reached your dashboard.</p>

            <div class="dashboard-card">
                <h3>Account Overview</h3>
                <p>
                    <strong>Name:</strong>
                    <?php echo htmlspecialchars($fullname); ?>
                </p>

                <p>
                    <strong>Email:</strong>
                    <?php echo htmlspecialchars($email); ?>
                </p>
            </div>

            <div class="dashboard-actions">
                <a href="signup.php" class="dashboard-button">
                    Create Account
                </a>

                <a href="login.php" class="dashboard-button secondary">
                    Back to Login
                </a>
            </div>
        </main>

        <footer class="dashboard-footer">
            <p>&copy; <?php echo date("Y"); ?> MyDashboard. All rights reserved.</p>
        </footer>

    </div>

</body>
</html>
