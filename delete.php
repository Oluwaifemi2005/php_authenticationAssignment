<?php
session_start();

// Check admin access
if (
    !isset($_SESSION['logged_in']) ||
    $_SESSION['logged_in'] !== true ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] !== 'admin'
) {
    header("Location: dashboard.php");
    exit;
}

include "connectdb.php";

// Check that the delete form was submitted
if (isset($_POST['deleteUser'], $_POST['userID'])) {

    $userID = (int) $_POST['userID'];

    // Prevent an admin from deleting their own account
    if ($userID === (int) $_SESSION['user_id']) {
        die("You cannot delete your own admin account.");
    }

    $query = "DELETE FROM users WHERE id = ?";

    $stmt = mysqli_prepare($connection, $query);

    mysqli_stmt_bind_param($stmt, "i", $userID);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);

        header("Location: admin.php");
        exit;
    } else {
        die("Unable to delete user.");
    }

} else {
    die("Invalid delete request.");
}
?>