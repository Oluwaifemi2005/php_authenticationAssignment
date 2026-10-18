
<?php
$pageTitle = "Login";
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
