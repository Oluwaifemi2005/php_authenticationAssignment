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
