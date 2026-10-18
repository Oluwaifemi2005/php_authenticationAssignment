
<?php
$pageTitle = "Create Account";
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
        <h1>Create Account</h1>
        <p>Sign up to get started.</p>

        <form action="" method="post">

            <label for="fullname">Full Name</label>
            <input
                type="text"
                id="fullname"
                name="fullname"
                placeholder="Enter your full name"
                required
            >

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
                placeholder="Create a password"
                required
            >

            <label for="confirm_password">Confirm Password</label>
            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                placeholder="Confirm your password"
                required
            >

            <button type="submit">Create Account</button>

        </form>

        <p>Already have an account?
            <a href="login.php">Login</a>
        </p>
    </div>

</body>
</html>
