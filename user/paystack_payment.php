<?php
session_start();

// Ensure session variables exist
if (!isset($_SESSION['order_number']) || !isset($_SESSION['total_price'])) {
    die("Invalid payment session! Order number or price is missing.");
}

// Set email if missing
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    $_SESSION['email'] = "support@cantell.com"; // Use a default email if not available
}

$order_number = $_SESSION['order_number'];
$total_price = $_SESSION['total_price'];
$email = $_SESSION['email']; 

// Paystack API Key
$paystack_secret_key = "sk_test_a22fa2ccfa0f34573fe6fd535d1de4df080a4912";
$callback_url = "https://b449-102-176-65-171.ngrok-free.app/Fruitie/user/paystack_callback.php?reference=" . $order_number;

$data = [
    "email" => $email,
    "amount" => $total_price,
    "currency" => "GHS",
    "reference" => $order_number,
    "callback_url" => $callback_url
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/initialize");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $paystack_secret_key",
    "Content-Type: application/json"
]);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);
$curl_error = curl_error($ch);
curl_close($ch);

if ($curl_error) {
    die("cURL error: " . $curl_error);
}

$result = json_decode($response, true);

if (!$result) {
    die("Invalid Paystack response. Raw response: " . $response);
}

if (!isset($result['data']['authorization_url'])) {
    die("Paystack error: " . json_encode($result));
}

header("Location: " . $result['data']['authorization_url']);
exit();
?>