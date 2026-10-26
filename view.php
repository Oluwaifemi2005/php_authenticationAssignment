<?php
if (isset($_GET['id'])) {
    
    // 1. Force the ID to be an integer for an extra layer of safety
    $userID = (int)$_GET['id'];

    include "connectdb.php";
    
    // 2. Use placeholders (?) instead of variables directly in the query
    $query = "SELECT * FROM users WHERE id = ?";
    
    // 3. Prepare the statement
    if ($stmt = mysqli_prepare($connection, $query)) {
        
        // Bind the integer ID to the placeholder
        mysqli_stmt_bind_param($stmt, "i", $userID);
        
        // Execute the query
        mysqli_stmt_execute($stmt);
        
        // Get the result set
        $result = mysqli_stmt_get_result($stmt);

        // 4. Check if a user was actually found
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
        } else {
            echo "User not found.";
            exit;
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
        
    } else {
        echo "Failed to prepare the SQL statement: " . mysqli_error($connection);
        exit;
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
