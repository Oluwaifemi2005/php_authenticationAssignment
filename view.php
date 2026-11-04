<?php

session_start();

include "connectdb.php";
include "is_admin.php";

// Check whether an ID was provided
if (isset($_GET['id'])) {

    $userID = (int) $_GET['id'];

    // Fetch the selected user's information
    $query = "SELECT id, full_name, email FROM users WHERE id = ?";

    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {

        mysqli_stmt_bind_param($stmt, "i", $userID);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {

            $user = mysqli_fetch_assoc($result);

        } else {
            echo "User not found.";
            exit;
        }

        mysqli_stmt_close($stmt);

    } else {
        die("Failed to prepare the SQL statement.");
    }

} else {
    echo "No ID provided in the URL.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        .profile-card {
            border: 1px solid #ccc;
            padding: 20px;
            max-width: 400px;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>

    <h1>User Dashboard</h1>
    <p><strong>Viewing Profile for User ID:</strong> <?php echo $userID; ?></p>

    <!-- Displays the fetched user profile data -->
    <div class="profile-card">
        <h2>User Information</h2>
        
        <!-- Replace 'full_name' and 'email' with your actual database column names -->
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
        <p><strong>Email Address:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    </div>

</body>
</html>
