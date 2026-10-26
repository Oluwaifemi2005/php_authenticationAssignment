<?php  
if (isset($_POST['signupBtn'])) {
    $fn = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($fn)) {
        header("Location: signup.php?error=First name is required");
        exit;
        echo "<p style='color: red'>First name is required</p>";
        // return;
        // exit;
    }elseif(empty($email)){
        header("Location: signup.php?error=Email is required");
        exit;
        echo "<p style='color: red'>Email is required</p>";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: signup.php?error=Email is not valid");
        exit;
    }
    elseif(empty($password)){
        header("Location: signup.php?error=Password is required");
        exit;
        echo "<p style='color: red'>Password is required</p>";
    }elseif(strlen($password) < 3){
        header("Location: signup.php?error=Password must be at least 3 characters");
        exit;
    }elseif($password !== $confirm_password){
        header("Location: signup.php?error=Password and confirm password must match");
        exit;
    }
    elseif(strlen($fn) < 3){
        header("Location: signup.php?error=Name must be at least 3 Characters");
        exit;
        echo "<p style='color: red' >Name must be at least 3 Characters</p>";
    }
    // elseif(!preg_match("/a-z/", $password)){
    //     header("Location: signup.php?error=Password muct contain at least pne lowercase");
    //     exit;
    // }
    
    
    else{
        // echo "<br>";
        // echo "My name is $fn";
        // echo "<br>";
        // echo "Email: $email";
        // echo "<br>";
        // echo "Password: $password";

        // session_start();
        // // $_SESSION['fn'] = $fn;
        // // $_SESSION['email'] = $email;
        // // $_SESSION['password'] = $password;
    
        // $user = ["fn" => $fn, "email" => $email, "password" => $password];
    
        // $_SESSION['user_key'] = $user;
        // header("Location: login.php");




        // $connection = mysqli_connect("localhost", "root", "", "manny_bank");
        // if (!$connection) {
        //     echo "Database could not connect" . mysqli_error($connection);
        // }else{
        //     echo "Database connected";
        // }

        include "connectdb.php";

        $query = "INSERT INTO users (full_name, email, password) VALUES ('$fn', '$email', '$password')";
        $response = mysqli_query($connection, $query);
        if (!$response) {
            echo "Something went wrong". mysqli_error($connection);

        }else{
            echo "User created successfully";
            header("Location: login.php");
        }
    }

    


    //AUTHENTICATE THE INPUT FIELDS
    //FILTERVAR for email
    
}

?>