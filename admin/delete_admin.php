<?php
// Include database connection
include 'includes/../../db.php';
session_start();

// Ensure only superadmins can delete admins
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_role'] != 'superadmin') {
    header("Location: admin_login.php");
    exit();
}

// Check if an admin ID is provided in the URL
if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    if ($conn) { // If using MySQLi
        $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $stmt->close();
    } else { // If using PDO
        $stmt = $pdo->prepare("DELETE FROM admins WHERE id = :id");
        $stmt->execute(['id' => $admin_id]);
    }

    // Redirect to admin list after deletion
    header("Location: admin_list.php");
    exit();
} else {
    echo "Error: Admin ID not provided.";
}
?>
