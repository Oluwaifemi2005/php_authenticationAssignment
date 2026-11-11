<?php 
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
        $image_name = strtolower($image_name). time();
        echo "<br>";
        echo $image_name;

        $file = $path . $image_name;  // this is what is saved in the database
        if (move_uploaded_file($_FILES['img']['tmp_name'], $file)) {
            echo "<br>";
            echo "Image uploaded successfully";
            $is_uploaded = true;

            // write a query that put the path in the database
             // 4. Execute the query safely using a prepared statement
            $query = $query = "UPDATE users SET profile_picture = ? WHERE id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "s", $file);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                echo "Image path saved to database!";
                $is_uploaded = true;
            } else {
                echo "Database error: " . $stmt->error;
            }
            $stmt->close();
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