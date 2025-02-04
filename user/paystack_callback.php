<?php
session_start();
include 'includes/../../db.php';

if (!isset($_GET['reference'])) {
    die("Transaction reference is missing!");
}

$reference = $_GET['reference'];
$paystack_secret_key = "sk_test_a22fa2ccfa0f34573fe6fd535d1de4df080a4912";

// Verify transaction with Paystack
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/verify/" . $reference);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $paystack_secret_key",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
curl_close($ch);

// Log response for debugging purposes
file_put_contents("paystack_response.log", $response . PHP_EOL, FILE_APPEND); // Save to a log file

if (!$response) {
    die("Error: No response from Paystack.");
}

$result = json_decode($response, true);

// Check if the result contains the expected data
if (!isset($result['status']) || !$result['status']) {
    die("Error: Unable to verify payment.");
}

if (isset($result['data']) && isset($result['data']['status'])) {
    if ($result['data']['status'] == "success") {
        // Payment was successful
        $order_number = $result['data']['reference'];

        // Update the order status in the database
        $conn->query("UPDATE orders SET payment_status='Paid' WHERE order_number='$order_number'");

        echo "<script>alert('Payment successful!'); window.location='tracker.php';</script>";
    } elseif ($result['data']['status'] == "failed") {
        // Payment failed
        echo "<script>alert('Payment failed. Please check your payment details or try again.'); window.location='cart.php';</script>";
    } elseif ($result['data']['status'] == "pending") {
        // Payment is pending verification
        echo "<script>alert('Payment is pending. Please check your payment status.'); window.location='cart.php';</script>";
    }
} else {
    die("Error: Missing data in Paystack response.");
}
?>
