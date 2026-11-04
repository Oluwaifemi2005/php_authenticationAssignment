<?php 
$userID = "";
if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    //write the query that fetches the user from the database

    include "connectdb.php";
    $query = "SELECT * from users WHERE id = $userID";
    $result = mysqli_query($connection, $query);
    if ($result) {
        $user = mysqli_fetch_assoc($result);
        $fullname = $user['full_name'];
        $email = $user['email'];
        mysqli_close($connection);
    }
    else{
        echo "Query failed: " . mysqli_error($connection);
    }
}

?>














//former login
<?php
$pageTitle = "Login";
session_start();
include "connectdb.php";

$errMessage = "";

$connection = mysqli_connect("localhost", "root", "", "manny_bank");
if (!$connection) {
    die("Database connection failed");
}


if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $new_user = ["email" => $user['email'], "role" => $user['role'], "token" => $token];
        $_SESSION['user_key'] = $new_user;
        if ($user['role'] == 'admin') {
            header("Location: dashboard.php");
            exit;
        }

        if ($password === $user['password']) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];


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


echo "<br>";
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





//former dashboard

<?php
session_start();
include "connectdb.php";

if (!isset($_SESSION['user_key'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user_key'];
$user_token = $user['token'];

$token_check_query = "SELECT * FROM tokens WHERE token = '$user_token'";
$resp = mysqli_query($connection, $token_check_query);
if (mysqli_num_rows($resp) == 0) {
    header("Location: login.php");
    exit;
}else{
    $token_data = mysqli_fetch_assoc($resp);
    $token_expiration = $token_data['token_expiration'];
    if (time() > $token_expiration) {
        session_destroy();
        header("Location: login.php?error=session expired, please log in again");
    }
}



echo $_SESSION['role'];

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$pageTitle = "Dashboard";

// $connection = mysqli_connect("localhost", "root", "", "manny_bank");

// if (!$connection) {
//     die("Database connection failed");
// }


$userId = (int) $_SESSION['user_id'];

$query = "SELECT full_name, email FROM users WHERE id = $userId";
$result = mysqli_query($connection, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    die("User not found");
}

$user = mysqli_fetch_assoc($result);

$fullname = $user['full_name'];
$email = $user['email'];

mysqli_close($connection);
?>
