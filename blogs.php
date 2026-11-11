<?php
include("connectdb.php");


$sql = "SELECT * FROM blog ORDER BY created_at DESC";

$result = mysqli_query($connection, $sql);

if ($result) {
    echo "Total blogs: " . mysqli_num_rows($result);
} else {
    echo "Error fetching blogs: " . mysqli_error($connection);
}

while ($blog = mysqli_fetch_assoc($result)) {
    echo "Author: " . htmlspecialchars($blog['author']);
    echo "<br>";

    echo "Title: " . htmlspecialchars($blog['title']);
    echo "<br>";

    echo "Description: " . htmlspecialchars($blog['description']);
    echo "<br>";

    echo "Published: " . $blog['created_at'];
    echo "<br>";

    echo '<a href="viewBlog.php?id=' . $blog['id'] . '">View Blog</a>';
    echo "<hr>";

    echo '<a href="editBlog.php?id=' . $blog['id'] . '">Edit Blog</a>';
    echo "<br>";

    echo '<img src="' . htmlspecialchars($blog['image']) . '" width="200" alt="Blog image">';
    echo "<hr>";
}
?>