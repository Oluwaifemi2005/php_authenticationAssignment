

<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$pageTitle = "Dashboard";

$connection = mysqli_connect("localhost", "root", "", "manny_bank");

if (!$connection) {
    die("Database connection failed");
}

$userId = (int) $_SESSION['user_id'];

$query = "SELECT full_name, email FROM users WHERE id = $userId";
$result = mysqli_query($connection, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    die("User not found");
}

$user = mysqli_fetch_assoc($result);

$fullname = $user['full_name'];
$email = $user['email'];

mysqli_close($connection);
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
