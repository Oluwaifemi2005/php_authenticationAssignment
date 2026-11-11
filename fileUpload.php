<?php 
    session_start();

    if (!isset($_SESSION['user_key'])) {
        header("Location: login.php");
        exit;
    }
    $user = $_SESSION['user_key'];
    $id = $user['user_id'];

    include ("connectdb.php");
    $path = "images/";
    $is_uploaded = false;
    if (isset($_POST['submit']) && isset($_FILES['img'])) {
        $image_name = $_FILES['img']['name'];
        $image_size = $_FILES['img']['size'];

        echo "Image Name: $image_name";
        echo "<br>";
        echo "Image Size: $image_size";

        if ($image_size > 2000000) {
            echo "<br>";
            echo "Image is too large, upload a smaller image";
        }
        $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $new_name = time() . "_" . uniqid() . "." . $ext;
        // $image_name = strtolower($image_name). time();  this will not work because it turns the photo into photo.jpg1731340000 and removes the .jpg tag
        echo "<br>";

        $file = $path . $new_name;  // this is what is saved in the database
        if (move_uploaded_file($_FILES['img']['tmp_name'], $file)) {

            // write a query that put the path in the database
             // 4. Execute the query safely using a prepared statement
            $query = "UPDATE users SET profile_picture = ? WHERE id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "si", $file, $id);

            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    echo "<br>";
                    echo "Profile picture updated successfully.";
                    $is_uploaded = true;
                    
                }else{
                    echo "No changes made (user not found or picture is identical).";
                }
                
            } else {
                echo "Database error: " . $stmt->error;
            }
            mysqli_stmt_close($stmt);
            }
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
    <main>
        <form action="fileUpload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="img">
            <button name="submit" type="submit">Upload</button>
        </form>

        

        <img src="<?php echo $is_uploaded ? $file : '' ?>" alt="the image i uploaded">
    </main>
</body>
</html>