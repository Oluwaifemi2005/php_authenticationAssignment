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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?></title>
</head>
<body>

    <main>
        <h1><?php echo htmlspecialchars($blog['title']); ?></h1>

        <p>
            Author: <?php echo htmlspecialchars($blog['author']); ?>
        </p>

        <img
            src="<?php echo htmlspecialchars($blog['image']); ?>"
            width="400"
            alt="Blog image"
        >

        <p>
            <?php echo nl2br(htmlspecialchars($blog['description'])); ?>
        </p>

        <p>
            Published: <?php echo htmlspecialchars($blog['created_at']); ?>
        </p>
        <p>
            Last Updated: <?php echo htmlspecialchars($blog['updated_at']); ?>
        </p>

        <a href="blogs.php">Back to Blogs</a>
    </main>

</body>
</html>