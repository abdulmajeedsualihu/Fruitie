<?php
session_start();
include 'includes/../../db.php';

include '../includes/../user/function.php';
// Example: Log an admin login
logUserAction($_SESSION['user_id'], "Logged in");

// Handle the "Add to Cart" action
if (isset($_GET['add'])) {
    $product_id = $_GET['add']; // Get the product ID
    $user_id = $_SESSION['user_id']; // Get the user ID
    $quantity = 1; // Default quantity is 1

    // Check if the product already exists in the user's cart
    $sql = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // If the product already exists in the cart, update the quantity
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity; // Increase the quantity
        $update_sql = "UPDATE cart SET quantity = '$new_quantity' WHERE user_id = '$user_id' AND product_id = '$product_id'";
        $conn->query($update_sql);
    } else {
        // If the product does not exist, insert it into the cart
        $insert_sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";
        $conn->query($insert_sql);
    }

    // Redirect to the cart page after adding the item
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Fruit & Veg Delivery</title>
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="../main.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div>
        <h2>🍏 Fruit & Veg Delivery</h2>
        <?php include 'includes/../header.php'; ?>
        <div>
            
            <!-- <a href="home.php" class="btn">🏠 Home</a>
            <a href="cart.php" class="btn">🛒 Cart</a>
            <a href="tracker.php" class="btn">📦 Order Tracker</a>
            <a href="profile.php" class="btn">Profile</a>
            <a href="logout.php" class="btn logout">🚪 Logout</a> -->
        </div>
        
    </div>
    
    <section>
    <div class="container-md mt-5">
        <div class="col-lg-6 col-12 pt-3 mt-5">
            <div class="pt-3">
                <h1 class="display-5">Taste The Difference</h1>
                <h2 class="h3 text-primary mb-4" style="font-family: courgete;">Delivered To Your Door!</h2>
                <p>We're dedicated to bringing exceptional flavors straight to your door. Our handpicked menu, crafted by
                passionate chefs, promises a culinary adventure with every order. Enjoy restaurant-quality meals,
                conveniently delivered for your pleasure. Explore the taste of convenience today!</p>
                </div>
</div>
    </section>

    <section>
    <div class="container-fluid">
        <div class="row">
        <h1>Fresh Fruits & Vegetables</h1>
        <div class="products">
        <div class="row justify-content-center">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "
              <div class='col'>
                <div class='card' style='width: 24rem;'>
                <img src='../images/" . $row['image'] . "' alt='" . $row['name'] . "' class='card-img-top'>
                  <div class='card-body'>
                    <h5 class='card-title'>" . $row['name'] . "</h5>
                    <h4 class='card-title'>$" . $row['price'] . "</h4>
                    <a href='home.php?add=" . $row['id'] . "' class='btn btn-primary'>Add to Cart</a>
                  </div>
                </div>
              </div>
              ";
            }
            ?>
        </div>
    </section>

  <section class="mt-5 mx-3 pt-5" id="sec-about">
    <div class="container-fluid mt-5">
      <h1 class="h2 text-center mb-5">About Us</h1>
      <div class="row justify-content-center align-items-center mb-5 flex-md-row flex-column">
      <div class="col-md-6 col-12">
          <img src="../Images/about-us.png" alt="" class="rounded-5 img-fluid mb-4">
        </div>
        <div class="col-md-6 col-12">
          <p>From a humble beginning to your favorite food delivery service, our journey has been filled with passion
            and
            flavor. We started with a vision to connect you with the culinary delights of your city, and today, we're
            proud
            to serve you with a wide variety of cuisines and dishes.<br><br>Our team is a blend of food enthusiasts,
            tech
            wizards, and delivery heroes. We're united by our love for great food and a commitment to making your dining
            moments special. We work tirelessly to ensure every meal you order is a delightful
            experience.<br><br>Quality is
            our secret ingredient. From hand-picking the freshest ingredients to partnering with the finest restaurants,
            we're obsessed with bringing you the best. Your satisfaction is our recipe for success.</p>
        </div>
      </div>

    </div>
  </section>
    
    <section class="mt-5 pt-5">
    <div class="container-fluid mt-5">
      <h1 class="h2 text-center mb-5">About Us</h1>
      <div class="row justify-content-center align-items-center mb-5">
        <div class="col-md-10 col-12">
          <p>From a humble beginning to your favorite food delivery service, our journey has been filled with passion
            and
            flavor. We started with a vision to connect you with the culinary delights of your city, and today, we're
            proud
            to serve you with a wide variety of cuisines and dishes.<br><br>Our team is a blend of food enthusiasts,
            tech
            wizards, and delivery heroes. We're united by our love for great food and a commitment to making your dining
            moments special. We work tirelessly to ensure every meal you order is a delightful
            experience.<br><br>Quality is
            our secret ingredient. From hand-picking the freshest ingredients to partnering with the finest restaurants,
            we're obsessed with bringing you the best. Your satisfaction is our recipe for success.</p>
            <?php include 'includes/../feedback.php'; ?>
        </div>
      </div>

    </div>
  </section>


    <?php include 'includes/../footer.php'; ?>
</body>
</html>
