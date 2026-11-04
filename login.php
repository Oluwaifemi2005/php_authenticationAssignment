
<?php
$pageTitle = "Login";

session_start();
include "connectdb.php";

$errMessage = "";

if (isset($_POST['email'], $_POST['password'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Find the user
    $query = "SELECT id, email, password FROM users WHERE email = ?";

    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {

        $user = mysqli_fetch_assoc($result);

        // Check password
        if ($password === $user['password']) {

            // Generate token
            $token = bin2hex(random_bytes(32));

            // Set expiration to 3 minutes
            $tokenExpiration = time() + 180;

            // Save token in database
            $tokenQuery = "INSERT INTO tokens
                (user_id, token, token_expiration)
                VALUES (?, ?, ?)";

            $tokenStmt = mysqli_prepare($connection, $tokenQuery);

            mysqli_stmt_bind_param(
                $tokenStmt,
                "isi",
                $user['id'],
                $token,
                $tokenExpiration
            );

            if (mysqli_stmt_execute($tokenStmt)) {

                // Store token in session
                session_regenerate_id(true);

                $_SESSION['user_key'] = [
                    "user_id" => $user['id'],
                    "email" => $user['email'],
                    "token" => $token
                ];
                // echo "Login successful. Token saved: " . $_SESSION['user_key']['token'];
                header("Location: dashboard.php");
                exit;

            } else {
                $errMessage = "Could not create login session.";
            }

            mysqli_stmt_close($tokenStmt);

        } else {
            $errMessage = "Invalid credentials";
        }

    } else {
        $errMessage = "Invalid credentials";
    }

    mysqli_stmt_close($stmt);
}
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

    <div class="container">
        <h1>Welcome Back</h1>
        <p>Login to access your account.</p>


        <?php if (!empty($errMessage)) { ?>
            <p style="color: red"><?php echo htmlspecialchars($errMessage) ?></p>
        <?php } ?>

        <form action="" method="post">

            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >

            <button type="submit">Login</button>

        </form>

        <p>Don't have an account?
            <a href="signup.php">Create an account</a>
        </p>
    </div>

</body>
</html>





<!-- echo "<br>";
echo random_bytes(16);
echo bin2hex("My name is Emmanuel");
echo "<br>";
echo hex2bin("4d79206e616d6520697320456d6d616e75656c");
echo "<br>";
// echo time();

$token = bin2hex(random_bytes(16));
echo "$token";
$token_exp = time() + 180;

// in database create a token table with columns: user_id token and token_expiration
$token_query = "INSERT INTO tokens (user_id, token, token_expiration) VALUES"
?>


// bin2hex random_bytes time() -->





