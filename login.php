
<?php
$pageTitle = "Login";
session_start();

$errMessage = "";

$connection = mysqli_connect("localhost", "root", "", "manny_bank");
if (!$connection) {
    die("Database connection failed");
}


if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($password === $user['password']) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];


            header("Location: dashboard.php");
            exit;
        }else{
            $errMessage = "Invalid credentials";
        }
    }else{
        $errMessage = "Invalid credentials";
    }
}
// if (isset($_SESSION['user_key'])) {
//     $user = $_SESSION['user_key'];
//     print_r($user);
// }

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
