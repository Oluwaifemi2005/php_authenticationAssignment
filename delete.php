<?php

session_start();

include "connectdb.php";
include "is_admin.php";

// Check that the delete form was submitted
if (isset($_POST['deleteUser'], $_POST['userID'])) {

    $userID = (int) $_POST['userID'];

    // Get the currently logged-in user's ID
    $currentUserID = (int) $_SESSION['user_key']['user_id'];

    // Prevent an admin from deleting their own account
    if ($userID === $currentUserID) {
        die("You cannot delete your own admin account.");
    }

    $query = "DELETE FROM users WHERE id = ?";

    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die("Could not prepare delete query.");
    }

    mysqli_stmt_bind_param($stmt, "i", $userID);

    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        header("Location: admin.php");
        exit;

    } else {

        mysqli_stmt_close($stmt);

        die("Unable to delete user.");
    }

} else {
    die("Invalid delete request.");
}

?>