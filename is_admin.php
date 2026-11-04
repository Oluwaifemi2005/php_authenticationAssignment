
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "connectdb.php";

// Check whether a token exists in the session
if (!isset($_SESSION['user_key']['token'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user_key'];
$userToken = $user['token'];

// Verify token against database
$query = "SELECT user_id, token_expiration FROM tokens WHERE token = ?";

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
mysqli_stmt_close($stmt);

// Check token expiration
if (time() >= (int) $tokenData['token_expiration']) {

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

// Verify that the token belongs to this session's user
if ((int) $tokenData['user_id'] !== (int) $user['user_id']) {
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit;
}

// Retrieve the user's current role from the database
$userId = (int) $tokenData['user_id'];

$query = "SELECT role FROM users WHERE id = ?";

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

$userData = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Authorize only admins
if ($userData['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

?>
