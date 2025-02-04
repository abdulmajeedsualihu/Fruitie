<link rel="stylesheet" href="login.css">
<?php
// Include the db.php file
include 'includes/../../db.php'; // Make sure this path is correct

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query with a question mark placeholder for MySQLi
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");

    // Bind the parameter to the query
    $stmt->bind_param("s", $username); // "s" denotes that the username is a string

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id']; // Store the admin's ID if needed
            $_SESSION['admin_role'] = $admin['role']; // Optional: Store the role

            header("Location: admin.php");
            exit();
        } else {
            $error = "Invalid credentials!";
        }
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<form method="POST">
    <h2>🔑 Admin Login</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <input type="text" name="username" placeholder="Admin Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
