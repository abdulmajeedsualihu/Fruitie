<?php
function logAdminAction($admin_id, $action) {
    global $conn;

    // Ensure valid input before proceeding
    if (!isset($admin_id) || empty($action)) {
        return;
    }

    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    // Prepare the SQL query with question mark placeholders
    $stmt = $conn->prepare("INSERT INTO admin_logs (admin_id, action, ip_address) VALUES (?, ?, ?)");

    // Check if the query was prepared successfully
    if ($stmt) {
        // Bind the parameters to the query
        $stmt->bind_param("iss", $admin_id, $action, $ip); // "i" for integer, "s" for string

        // Execute the query
        if ($stmt->execute()) {
            $stmt->close();
        } else {
            error_log("Failed to execute admin log statement: " . $stmt->error);
        }
    } else {
        error_log("Failed to prepare admin log statement: " . $conn->error);
    }
}
?>
