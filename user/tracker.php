<?php
session_start();
include 'includes/../../db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all orders for the logged-in user
$sql = "SELECT * FROM orders WHERE user_id = " . $_SESSION['user_id'];
$result = $conn->query($sql);
$orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}



// cancel order button
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_order'])) {
    $order_number = $_POST['order_number'];

    // Fetch the current status of the order
    $sql = "SELECT status FROM orders WHERE order_number = '$order_number' AND user_id = " . $_SESSION['user_id'];
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        
        // Check if the order status is 'Pending'
        if ($order['status'] === 'Pending') {
            // Cancel the order by updating its status to 'Cancelled'
            $update_sql = "UPDATE orders SET status = 'Cancelled' WHERE order_number = '$order_number' AND user_id = " . $_SESSION['user_id'];
            
            if ($conn->query($update_sql) === TRUE) {
                $success_message = "Your order has been successfully cancelled.";
            } else {
                $error_message = "There was an error cancelling your order.";
            }
        } else {
            $error_message = "You can only cancel an order if its status is 'Pending'.";
        }
    } else {
        $error_message = "No order found with this Order ID.";
    }
}


$order = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_number = $_POST['order_number'];
    $sql = "SELECT * FROM orders WHERE order_number = '$order_number' AND user_id = " . $_SESSION['user_id'];
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        $error = "No order found with this Order ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order</title>
    <link rel="stylesheet" href="../user/tracker.css">
    <link rel="stylesheet" href="../user/home.css">

</head>
<body>
<div>
        <h2>🍏 Fruit & Veg Delivery</h2>
        <?php include 'includes/../header.php'; ?>
        <!-- <div>
            <span>Welcome, <?php echo $_SESSION['user_name']; ?>!</span>
            <a href="home.php" class="btn">🏠 Home</a>
            <a href="cart.php" class="btn">🛒 Cart</a>
            <a href="tracker.php" class="btn">📦 Order Tracker</a>
            <a href="profile.php" class="btn">Profile</a>
            <a href="logout.php" class="btn logout">🚪 Logout</a>
        </div> -->
    </div>

    <div class="container">
        <h1>Track Your Order</h1>
        <form action="tracker.php" method="POST">
            <input type="text" name="order_number" placeholder="Enter Order ID" required>
            <button class="btn-primary" type="submit">Track Order</button>
        </form>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (isset($success_message)): ?>
    <p class="text-success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <p class="text-danger"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if ($order): ?>
    <div class="order-details">
        <h2>Order Details</h2>
        <p><strong>Order ID:</strong> <?php echo $order['order_number']; ?></p>
        <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
        <p><strong>Total Price:</strong> $<?php echo $order['total_price']; ?></p>
        <p><strong>Ordered On:</strong> <?php echo $order['created_at']; ?></p>
        <p><strong>Expected Delivery:</strong> <?php echo $order['expected_delivery']; ?></p>

        <!-- Cancel Order Button (only show if the order status is not 'Cancelled' yet) -->
        <?php if ($order['status'] !== 'Cancelled'): ?>
            <form action="tracker.php" method="POST">
                <input type="hidden" name="order_number" value="<?php echo $order['order_number']; ?>">
                <button type="submit" name="cancel_order" class="btn btn-danger">Cancel Order</button>
            </form>
        <?php else: ?>
            <p class="text text-danger">This order has already been cancelled.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>


        <!-- Display all orders -->
        <h2>Your Previous Orders</h2>
        <?php if (count($orders) > 0): ?>
            <table class="order-list">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Status</th>
                        <th>Total Price</th>
                        <th>Ordered On</th>
                        <th>Expected Delivery</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td><?php echo $o['order_number']; ?></td>
                            <td><?php echo $o['status']; ?></td>
                            <td>$<?php echo $o['total_price']; ?></td>
                            <td><?php echo $o['created_at']; ?></td>
                            <td><?php echo $o['expected_delivery']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No previous orders found.</p>
        <?php endif; ?>
    </div>

    <?php include 'includes/../footer.php'; ?>
</body>
</html>
