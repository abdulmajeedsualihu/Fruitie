<?php
function logUserAction($user_id, $action) {
    $user_id = $_SESSION['user_id'];
    global $conn;
    
    if (!isset($user_id) || empty($action)) {
        return; // Ensure valid input before proceeding
    }
    
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    $stmt = $conn->prepare("INSERT INTO user_logs (user_id, action, ip_address) VALUES (?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("iss", $user_id, $action, $ip);
        $stmt->execute();
        $stmt->close();
    } else {
        error_log("Failed to prepare user log statement: " . $conn->error);
    }
}
?>
