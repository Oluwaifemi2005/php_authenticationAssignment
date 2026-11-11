<?php
include("connectdb.php");

if (isset($_POST['submit'])) {

    $author = trim($_POST['author']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    echo "Author: " . htmlspecialchars($author);
    echo "<br>";

    echo "Title: " . htmlspecialchars($title);
    echo "<br>";

    echo "Description: " . htmlspecialchars($description);

    $image_name = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_error = $_FILES['image']['error'];

    echo "<br>";
    echo "Image Name: " . htmlspecialchars($image_name);
    echo "<br>";
    echo "Image Size: " . $image_size . " bytes";
    echo "<br>";
    echo "Temporary Location: " . htmlspecialchars($image_tmp);
    echo "<br>";
    echo "Upload Error: " . $image_error;


    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    if ($image_error !== UPLOAD_ERR_OK) {

        echo "Image upload failed.";

    } elseif ($image_size > 2000000) {

        echo "Image is too large. Maximum size is 2MB.";

    } elseif (!in_array($ext, $allowedExtensions)) {

        echo "Invalid image extension.";

    } 
    $imageInfo = getimagesize($image_tmp);
    if ($imageInfo === false) {
    echo "The uploaded file is not a valid image.";
    } else {
        echo "<br>";
        $path = "images/";

        $newFileName = bin2hex(random_bytes(16)) . "." . $ext;

        $fileDestination = $path . $newFileName;

        if (move_uploaded_file($image_tmp, $fileDestination)) {
            echo "Image uploaded successfully!";
            $sql = "INSERT INTO blog (author, title, description, image) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param( $stmt, "ssss", $author, $title, $description, $fileDestination);
            if (mysqli_stmt_execute($stmt)) {
                echo "Blog published successfully!";
            } else {
                echo "Error publishing blog: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
            echo "<br>";
            echo "Saved as: " . htmlspecialchars($fileDestination);
        } else {
            echo "Failed to save image.";
        }
    }   
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog</title>
</head>
<body>

    <main>
        <h1>Create a Blog</h1>

        <form action="createBlog.php" method="POST" enctype="multipart/form-data">

            <div>
                <label for="author">Author</label>
                <input
                    type="text"
                    id="author"
                    name="author"
                    placeholder="Enter author's name"
                    required
                >
            </div>

            <br>

            <div>
                <label for="title">Blog Title</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    placeholder="Enter blog title"
                    required
                >
            </div>

            <br>

            <div>
                <label for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    placeholder="Write your blog here..."
                    required
                ></textarea>
            </div>

            <br>

            <div>
                <label for="image">Blog Image</label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                    required
                >
            </div>

            <br>

            <button type="submit" name="submit">Publish Blog</button>

        </form>
    </main>

</body>
</html>