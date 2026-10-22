
<?php
$pageTitle = "Create Account";

//SUPER GLOBALS
//$_GET
//$_POST
//$_REQUEST
//$_SERVER
//$_FILES
//$_ENV
//$_COOKIE
//$_SESSION

$errMessage = "";
if (isset($_GET['error'])) {
    $errMessage = $_GET['error'];
}




// if (isset($_POST['signupBtn'])) {
//     $fn = $_POST['fullname'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     if (empty($fn)) {
//         echo "<p style='color: red'>First name is required</p>";
//         return;
//     }
    
//     echo "<br>";
//     echo "My name is $fn";
//     echo "<br>";
//     echo "Email: $email";
//     echo "<br>";
//     echo "Password: $password";
    
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
        <h1>Create Account</h1>
        <p>Sign up to get started.</p>

        <form action="processForm.php" method="post">
            <?php 
                if (!empty($errMessage)) {
                    echo "<div>$errMessage</div>";
                    
                }else{
                    
                }
            ?>

            <label for="fullname">Full Name</label>
            <input
                type="text"
                id="fullname"
                name="fullname"
                placeholder="Enter your full name"
            >

            <label for="email">Email Address</label>
            <input
                type="text"
                id="email"
                name="email"
                placeholder="Enter your email"
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Create a password"
            >

            <label for="confirm_password">Confirm Password</label>
            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                placeholder="Confirm your password"
            >

            <button name="signupBtn" type="submit">Create Account</button>

        </form>

        <p>Already have an account?
            <a href="login.php">Login</a>
        </p>
    </div>

</body>
</html>
