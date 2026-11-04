<?php

session_start();

include "connectdb.php";
include "is_admin.php";

$errMessage = "";

// Get user ID from URL or submitted form
if (isset($_GET['id'])) {
    $userID = (int) $_GET['id'];
} elseif (isset($_POST['userID'])) {
    $userID = (int) $_POST['userID'];
} else {
    die("No user ID provided");
}

// Update user when form is submitted
if (isset($_POST['editUser'])) {

    $fn = trim($_POST['fullname']);
    $email = trim($_POST['email']);

    $query = "UPDATE users SET full_name = ?, email = ? WHERE id = ?";

    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {

        mysqli_stmt_bind_param($stmt, "ssi", $fn, $email, $userID);

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_close($stmt);

            header("Location: admin.php");
            exit;

        } else {
            $errMessage = "Error updating user.";
        }

        mysqli_stmt_close($stmt);

    } else {
        $errMessage = "Could not prepare the update query.";
    }
}

// Fetch the user's current details
$query = "SELECT id, full_name, email FROM users WHERE id = ?";

$stmt = mysqli_prepare($connection, $query);

if (!$stmt) {
    die("Could not prepare the user query.");
}

mysqli_stmt_bind_param($stmt, "i", $userID);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {

    $user = mysqli_fetch_assoc($result);

} else {
    die("User not found.");
}

mysqli_stmt_close($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>

    <h1>Edit User</h1>

    <?php if (!empty($errMessage)) { ?>
        <p style="color: red;">
            <?php echo htmlspecialchars($errMessage); ?>
        </p>
    <?php } ?>

    <form action="edit.php" method="post">

        <input type="hidden" name="userID"
            value="<?php echo (int) $user['id']; ?>">

        <label for="fullname">Full Name</label>
        <input
            type="text"
            id="fullname"
            name="fullname"
            value="<?php echo htmlspecialchars($user['full_name']); ?>"
            required
        >

        <br><br>

        <label for="email">Email Address</label>
        <input
            type="email"
            id="email"
            name="email"
            value="<?php echo htmlspecialchars($user['email']); ?>"
            required
        >

        <br><br>

        <button name="editUser" type="submit">Update Account</button>

    </form>

    <br>
    <a href="admin.php">Back to Admin Dashboard</a>

</body>
</html>
