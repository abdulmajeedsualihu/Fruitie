<?php
// Check if session is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'includes/../../db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $name = $_SESSION['user_name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    try {
        // Use `?` placeholders for MySQLi
        $stmt = $conn->prepare("INSERT INTO feedback (user_id, name, email, message) VALUES (?, ?, ?, ?)");

        // Bind parameters (s = string, i = integer)
        $stmt->bind_param("isss", $user_id, $name, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Feedback submitted successfully!'); window.location='home.php';</script>";
        } else {
            echo "<script>alert('Error submitting feedback!');</script>";
        }
        
        // Close statement
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>
    <link rel="stylesheet" href="./feedback.css">
</head>
<body>

    <div class="container-fluid">
        <h1>Customers Comment</h1>
        <form action="./feedback.php" method="POST">
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Write your comment..." required></textarea>
            <div class="container">
                <button type="submit">Submit Comment</button>
            </div>
        </form>
    </div>

    <div class="container-fluid">
        <h1 class="h2 text-center mb-5">Our Testimonials</h1>
        <?php
// Fetch feedback from the database
$sql = "SELECT * FROM feedback ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Check for errors after execution
$errorInfo = $stmt->error;

if ($errorInfo) {
    echo "<script>alert('Error fetching feedback: " . $errorInfo . "');</script>";
} else {
    $result = $stmt->get_result(); // This fetches the result set

    while ($row = $result->fetch_assoc()) {
        echo "<div class='container-fluid'>
                <div class='card-header'>
                  <i class='bi bi-star-fill'></i>
                  <i class='bi bi-star-fill'></i>
                  <i class='bi bi-star-fill'></i>
                  <i class='bi bi-star-fill'></i>
                  <i class='bi bi-star-half'></i>
                </div>
                <div class='card-body'>
                  <blockquote class='blockquote mb-0'>
                    <p class='d-flex align-items-center flex-md-row flex-column'>" . htmlspecialchars($row['message']) . "</p>
                    <footer class='blockquote-footer' style='background-color:rgb(255, 255, 255)'>" . htmlspecialchars($row['name']) . "</footer>
                    <footer class='blockquote-footer' style='background-color:rgb(255, 255, 255)'><small>Posted on: " . $row['created_at'] . "</small></footer>
                  </blockquote>
                </div>
              </div>";
    }
}
?>


    </div>

</body>
</html>
