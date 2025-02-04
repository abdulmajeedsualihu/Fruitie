<?php
session_start();
include 'includes/../../db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all products
$products = $conn->query("SELECT * FROM products");

// Handle product update
if (isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $new_price = $_POST['new_price'];
    
    $sql = "UPDATE products SET price = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $new_price, $product_id);
    $stmt->execute();
    header("Location: manage_products.php");
    exit();
}

// Handle product addition
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "../images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO products (name, price, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sds", $name, $price, $image);
        $stmt->execute();
        header("Location: manage_products.php");
        exit();
    }
}

// Handle product deletion
if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="manage_products.css">
    <link rel="stylesheet" href="../main.css">
</head>
<body>
    <?php include 'admin_header.php'; ?>

    <div class="container">
        <h1>🍏 Manage Products</h1>

        <!-- Add Product Form -->
        <h2>Add a New Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <input style="width: 30%" type="text" name="name" placeholder="Product Name" required>
            <input style="width: 30%" type="number" step="0.01" name="price" placeholder="Price" required>
            <input style="width: 30%" type="file" name="image" required>
            <button type="submit" name="add_product" style="width: 30%">Add Product</button>
        </form>

        <!-- Display Products -->
        <h2>Existing Products</h2>
        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php while ($product = $products->fetch_assoc()): ?>
            <tr>
                <td><img src="../images/<?php echo $product['image']; ?>" width="50"></td>
                <td><?php echo $product['name']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="number" step="0.01" name="new_price" value="<?php echo $product['price']; ?>">
                        <button type="submit" name="update_product" style="width: 30%">Update</button>
                    </form>
                </td>
                <td>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" name="delete_product">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php include '../user/footer.php'; ?>
</body>
</html>
