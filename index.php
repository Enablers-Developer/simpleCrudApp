<?php

include 'connection.php';

// Creating an add operation
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    $conn->query($sql);
}

// Creating an update operation
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id";
    $conn->query($sql);
}

// Deleting a user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";
    $conn->query($sql);
}

// Fetching all users
$result = $conn->query("SELECT * FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple CRUD Application</title>
</head>
<body>
    <h2>Add User</h2>
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Enter your name:" required>
        <input type="email" name="email" placeholder="Enter your email:" required>
        <button type="submit" name="add">Add User</button>
    </form>

    <h2>User List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <a href="index.php?edit=<?php echo $row['id']; ?>">Edit</a>
                <a href="index.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Edit form for updating user -->
    <?php 
    $row = null; // Initialize $row to avoid undefined variable warnings
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $result = $conn->query("SELECT * FROM users WHERE id=$id");
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
    }
    ?>

    <h2>Edit User</h2>
    <?php if ($row): ?>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
            <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
            <button type="submit" name="update">Update User</button>
        </form>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</body>
</html>

<?php $conn->close(); ?>
