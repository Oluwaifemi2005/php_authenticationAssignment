<?php
session_start();
include "connectdb.php";

if (!isset($_SESSION['user_key'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user_key'];
$userToken = $user['token'];

// Verify token in database
$query = "SELECT user_id, token_expiration
          FROM tokens
          WHERE token = ?";

$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "s", $userToken);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit;
}

$tokenData = mysqli_fetch_assoc($result);

// Check token expiration
if (time() >= (int) $tokenData['token_expiration']) {

    // Delete expired token
    $deleteQuery = "DELETE FROM tokens WHERE token = ?";
    $deleteStmt = mysqli_prepare($connection, $deleteQuery);

    mysqli_stmt_bind_param($deleteStmt, "s", $userToken);
    mysqli_stmt_execute($deleteStmt);
    mysqli_stmt_close($deleteStmt);

    session_unset();
    session_destroy();

    header("Location: login.php?error=expired");
    exit;
}

// Confirm token belongs to the user in the session
if ((int) $tokenData['user_id'] !== (int) $user['user_id']) {
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit;
}

// Fetch current user information and role from database
$userId = (int) $tokenData['user_id'];

$query = "SELECT id, full_name, email, role
          FROM users
          WHERE id = ?";

$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit;
}

$dbUser = mysqli_fetch_assoc($result);

$fullname = $dbUser['full_name'];
$email = $dbUser['email'];
$pageTitle = "Dashboard";

mysqli_stmt_close($stmt);
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
