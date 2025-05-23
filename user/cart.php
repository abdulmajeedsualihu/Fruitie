<?php
session_start();
include 'includes/../../db.php';




// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$sql = "SELECT c.product_id, p.name, p.price, p.image, c.quantity 
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = '$user_id'";
$result = $conn->query($sql);

$cart_items = [];
$total_price = 0;

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total_price += $row['price'] * $row['quantity'];
}

// Handle order submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    $address = $conn->real_escape_string($_POST['address']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);

    if (empty($cart_items)) {
        echo "<script>alert('Your cart is empty!'); window.location='home.php';</script>";
        exit();
    }

    // Generate a unique order number
    $order_number = 'ORD-' . strtoupper(uniqid());
    $expected_delivery = date('Y-m-d', strtotime("+7 days")); // 7 days from today

    // Store session variables for Paystack
    $_SESSION['order_number'] = $order_number;
    $_SESSION['total_price'] = $total_price * 100; // Convert to pesewas (Paystack uses kobo/pesewas)
    // Ensure email is set, use default if missing

if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = "default@example.com"; // Set a default email if missing
}

if ($payment_method === "Paystack") {
    echo "<script>alert('Redirecting to Paystack...');</script>";
    header("Location: paystack_payment.php");
    exit();
}


    // If Cash on Delivery, proceed normally
    $sql = "INSERT INTO orders (user_id, total_price, address, payment_method, status, order_number, created_at, expected_delivery) 
            VALUES ('$user_id', '$total_price', '$address', '$payment_method', 'Pending', '$order_number', NOW(), '$expected_delivery')";
    
    if ($conn->query($sql)) {
        $order_id = $conn->insert_id;

        foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $conn->query("INSERT INTO order_items (order_id, product_id, quantity) 
                          VALUES ('$order_id', '$product_id', '$quantity')");
        }

        $conn->query("DELETE FROM cart WHERE user_id = '$user_id'");
        echo "<script>alert('Order placed successfully! Your Order ID: $order_number'); window.location='tracker.php';</script>";
        exit();
    } else {
        echo "<script>alert('Order failed. Please try again!');</script>";
    }

}

// Handle removing an item from the cart
if (isset($_GET['remove'])) {
    $product_id = intval($_GET['remove']); // Ensure it's a valid number

    // Debugging Output
    echo "<script>console.log('Removing product ID: " . $product_id . "');</script>";

    // Execute deletion query
    $deleteQuery = $conn->query("DELETE FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'");

    if ($deleteQuery) {
        echo "<script>alert('Item removed successfully!'); window.location='cart.php';</script>";
    } else {
        echo "<script>alert('Failed to remove item. Please try again.');</script>";
    }
    exit();
}



// Handle updating the quantity
if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['quantity'];

    if ($new_quantity > 0) {
        $conn->query("UPDATE cart SET quantity = '$new_quantity' WHERE user_id = '$user_id' AND product_id = '$product_id'");
    } else {
        $conn->query("DELETE FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'");
    }

    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="./cart.css">
    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" href="./home.css">
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
    <h2>Cart</h2>
    
    <div class="checkout-container">
        <h3>Cart Summary</h3>
        <ul>
            <?php if (empty($cart_items)): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <?php foreach ($cart_items as $item) : ?>
                    <li>
                        <img src="../Images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" width="50">
                        <?php echo $item['name']; ?> - GHS<?php echo number_format($item['price'], 2); ?> x 
                        <form method="POST" style="display:inline;">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" required>
                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                            <button type="submit" name="update_quantity">Update</button>
                        </form>
                        <strong>Total: GHS<?php echo number_format($item['price'] * $item['quantity'], 2); ?></strong>
                        <a href="cart.php?remove=<?php echo $item['product_id']; ?>" class="btn-remove" onclick="return confirm('Are you sure you want to remove this item?');">❌ Remove</a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <p><strong>Total Price: GHS<?php echo number_format($total_price, 2); ?></strong></p>

        <form method="POST">
            <label>Delivery Address:</label>
            <textarea name="address" required></textarea>

            <label>Payment Method:</label>
            <select name="payment_method" required>
                <option name="Cash" value="Cash on Delivery">Cash on Delivery</option>
                <option name="Paystack" value="Paystack">Paystack</option>
            </select>

            <button type="submit" name="place_order">Place Order</button>
        </form>
    </div>

    <?php include 'includes/../footer.php'; ?>
</body>
</html>
