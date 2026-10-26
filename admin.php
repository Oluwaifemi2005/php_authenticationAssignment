<?php  
$pageTitle = "Admin Dashboard";
$connection = mysqli_connect("localhost", "root", "", "manny_bank");

if (!$connection) {
    die("Database connection failed");
}
$query = "SELECT id, full_name, email FROM users";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Could not fetch users");
}
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
        <h1>Admin Dashboard</h1>
        <p>Registered users</p>

        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($user = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']) ?></td>
                        <td><?php echo htmlspecialchars($user['full_name']) ?></td>
                        <td><?php echo htmlspecialchars($user['email']) ?></td>


                        <td>
                            <a href="view.php?id=<?php echo (int) $user['id']; ?>">view</a>
                            <a href="edit.php?id=<?php echo (int) $user['id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo (int) $user['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>

<?php 
    mysqli_close($connection)
?>