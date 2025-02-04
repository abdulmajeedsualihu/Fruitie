<?php
// admin_list.php - List All Admins
include 'includes/../../db.php';
session_start();

// Ensure only superadmins can access this page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] != 'superadmin') {
    header("Location: admin_login.php");
    exit();
}

// Fetch all admins from the database
$query = "SELECT * FROM admins";
$result = $conn->query($query);

if ($result) {
    $admins = $result->fetch_all(MYSQLI_ASSOC);
} else {
    die("Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin List</title>
    <link rel="stylesheet" href="./main.css"> <!-- Include the stylesheet -->
</head>
<body>
<?php include 'admin_header.php'; ?>
    <header>
        <h2>Admin List</h2>
    </header>

    <main>
        <section>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($admin['username']); ?></td>
                            <td><?php echo htmlspecialchars($admin['email']); ?></td>
                            <td><?php echo htmlspecialchars($admin['role']); ?></td>
                            <td>
                            <a href="delete_admin.php?id=<?php echo $admin['id']; ?>" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
