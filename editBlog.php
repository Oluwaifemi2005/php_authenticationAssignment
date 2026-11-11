<?php
include("connectdb.php");

$id = $_GET['id'];

$sql = "SELECT * FROM blog WHERE id = ?";

$stmt = mysqli_prepare($connection, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$blog = mysqli_fetch_assoc($result);
if (!$blog) {
    die("Blog not found.");
}

if (isset($_POST['update'])) {

    $author = trim($_POST['author']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $image = $blog['image'];

if ($_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {

    echo "No new image selected. Keeping the existing image.";

} else {

    $image_name = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_error = $_FILES['image']['error'];

    if ($image_error !== UPLOAD_ERR_OK) {

        die("Image upload failed. Error code: " . $image_error);

    } elseif (empty($image_tmp) || !is_uploaded_file($image_tmp)) {

        die("No valid uploaded image was received.");

    } else {

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $imageInfo = getimagesize($image_tmp);

        if ($image_size > 2000000) {
            die("Image is too large. Maximum size is 2MB.");

        } elseif (!in_array($ext, $allowedExtensions)) {
            die("Invalid image extension.");

        } elseif ($imageInfo === false) {
            die("The uploaded file is not a valid image.");

        } else {
            $path = "images/";

            $newFileName = bin2hex(random_bytes(16)) . "." . $ext;

            $fileDestination = $path . $newFileName;

            if (move_uploaded_file($image_tmp, $fileDestination)) {

                $image = $fileDestination;

                echo "New image uploaded successfully!";

            } else {

                die("Failed to upload new image.");

            }
        }
    }

    }
    $sql = "UPDATE blog SET author = ?, title = ?, description = ?, image = ? WHERE id = ?";

    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $author, $title, $description, $image, $id);
    if (mysqli_stmt_execute($stmt)) {

        header("Location: blogs.php");
            exit;

    } else {

        echo "Error updating blog: " . mysqli_stmt_error($stmt);

    }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
</head>
<body>

    <main>
        <h1>Edit Blog</h1>

        <form action="editBlog.php?id=<?php echo $blog['id']; ?>"
              method="POST"
              enctype="multipart/form-data">

            <div>
                <label for="author">Author</label>
                <input
                    type="text"
                    id="author"
                    name="author"
                    value="<?php echo htmlspecialchars($blog['author']); ?>"
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
                    value="<?php echo htmlspecialchars($blog['title']); ?>"
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
                    required
                ><?php echo htmlspecialchars($blog['description']); ?></textarea>
            </div>

            <br>

            <div>
                <p>Current Image:</p>

                <img
                    src="<?php echo htmlspecialchars($blog['image']); ?>"
                    width="200"
                    alt="Current blog image"
                >
            </div>

            <br>

            <div>
                <label for="image">Choose a New Image (Optional)</label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                >
            </div>

            <br>

            <button type="submit" name="update">Update Blog</button>

        </form>

    </main>

</body>
</html>