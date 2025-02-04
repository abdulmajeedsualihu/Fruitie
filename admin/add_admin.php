<?php
// Include database connection
include 'includes/../../db.php';
session_start();

// Ensure only logged-in superadmins can access this page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] != 'superadmin') {
    header("Location: admin_login.php");
    exit();
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    // Ensure password is not empty before hashing
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        die("Error: Password cannot be empty.");
    }

    // Check if the MySQLi connection is established
    if ($conn) {
        try {
            // Prepare the SQL query using MySQLi-style placeholders (?)
            $stmt = $conn->prepare("INSERT INTO admins (username, password, email, role) VALUES (?, ?, ?, ?)");

            // Bind parameters
            $stmt->bind_param("ssss", $username, $hashed_password, $email, $role);

            // Execute the query
            $stmt->execute();

            // Redirect to the admin list page after successful insertion
            header("Location: admin_list.php");
            exit();
        } catch (mysqli_sql_exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "Error: Unable to connect to the database.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Admin</title>
    <link rel="stylesheet" href="./main.css"> <!-- Include the stylesheet -->
</head>
<?php include 'admin_header.php'; ?>
<body>
    <header>
        <h2>Add New Admin</h2>
    </header>
    <main>
        <section>
            <form method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Admin Username" required>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Password" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Admin Email" required>

                <label for="role">Role:</label>
                <select name="role" id="role" required>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Superadmin</option>
                </select>

                <button type="submit">Add Admin</button>
            </form>
        </section>
    </main>
</body>
</html>
