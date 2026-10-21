
<?php
$pageTitle = "Login";
session_start();

$errMessage = "";
if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($_SESSION['user_key']) && $email === $_SESSION['user_key']['email'] && $password === $_SESSION['user_key']['password']) {
        $_SESSION['logged_in'] = true;
        header("Location: dashboard.php");
        exit;
        }
        else{
            $errMessage = "Invalid Credientials";
        }
}
// if (isset($_SESSION['user_key'])) {
//     $user = $_SESSION['user_key'];
//     print_r($user);
// }
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
