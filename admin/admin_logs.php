<?php
// admin_logs.php - Admin Log Panel
session_start();
include '../db.php'; // Ensure correct path to db.php

// Ensure admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Logs</title>
    <link rel="stylesheet" href="./admin.css">
</head>
<body>
<?php include 'admin_header.php'; ?>
    <header>
        <h2>Admin Log Panel</h2>
    </header>
    <main>
        <section>
            <h3>User Logs</h3>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Timestamp</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT u.email, l.action, l.timestamp, l.ip_address 
                              FROM user_logs l 
                              JOIN users u ON l.user_id = u.user_id 
                              ORDER BY l.timestamp DESC";

                    $result = $conn->query($query);
                    if (!$result) {
                        die("Query failed: " . $conn->error);
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['email']}</td>
                                    <td>{$row['action']}</td>
                                    <td>{$row['timestamp']}</td>
                                    <td>{$row['ip_address']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No logs available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
