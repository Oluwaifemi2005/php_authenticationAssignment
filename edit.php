<?php 
if (isset($_GET['id'])) {
    $userID = (int)$_GET['id'];
    include "connectdb.php";

    $query = "SELECT * FROM users WHERE id = ?";

    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $userID);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $fullname = $user['full_name'];
            $email = $user['email'];
        } else {
            echo "User not found.";
            exit;
        }
        mysqli_stmt_close($stmt);

    } else {
        // FIXED: This now sits in a proper 'else' block
        echo "Failed to prepare the SQL statement: " . mysqli_error($connection);
        exit; // Stop execution if database error happens
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
    <title>Document</title>
</head>
<body>

        <form action="processForm.php" method="post">
            <?php 
                if (!empty($errMessage)) {
                    echo "<div>$errMessage</div>";
                }
            ?>

            <label for="fullname">Full Name</label>
            <input
                type="text"
                id="fullname"
                name="fullname"
                placeholder="Enter your full name"
                value="<?php echo htmlspecialchars($fullname); ?>"
            >

            <label for="email">Email Address</label>
            <input
                type="text"
                id="email"
                name="email"
                placeholder="Enter your email"
                value="<?php echo htmlspecialchars($email); ?>"
            >

            <button name="signupBtn" type="submit">Update Account</button>
        </form>
</body>
</html>
