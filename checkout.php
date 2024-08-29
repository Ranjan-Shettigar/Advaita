<?php
session_start();
include 'includes/config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to log errors
function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, 'error.log');
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ./auth/login.php');
    exit;
}

// Initialize total and items arrays
$total = 0;
$items = array();

// Fetch the user ID
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $user_id = $row['user_id'];
} else {
    logError("User not found: $username");
    header('Location: error.php?message=User not found');
    exit;
}

// Generate a unique order ID
$order_id = 'ADV' . date('YmdHis') . rand(1000, 9999);

// Single event purchase
if (isset($_GET['event_id']) && isset($_GET['price'])) {
    $event_id = $_GET['event_id'];
    $price = $_GET['price'];

    // Check if the event is already purchased by the user
    $stmt = $conn->prepare("SELECT * FROM user_purchases WHERE user_id = ? AND event_id = ?");
    $stmt->bind_param("ii", $user_id, $event_id);
    $stmt->execute();
    $purchased = $stmt->get_result()->num_rows > 0;

    if ($purchased) {
        header('Location: events.php?message=Event already purchased');
        exit;
    }

    $total = $price;
    $items[] = array('id' => $event_id, 'price' => $price);
} elseif (!empty($_SESSION['cart'])) {
    // Cart checkout
    foreach ($_SESSION['cart'] as $item) {
        $event_id = $item['id'];

        // Check if the event is already purchased by the user
        $stmt = $conn->prepare("SELECT * FROM user_purchases WHERE user_id = ? AND event_id = ?");
        $stmt->bind_param("ii", $user_id, $event_id);
        $stmt->execute();
        $purchased = $stmt->get_result()->num_rows > 0;

        if ($purchased) {
            continue;
        }

        $total += $item['price'];
        $items[] = array('id' => $item['id'], 'price' => $item['price']);
    }

    if (empty($items)) {
        header('Location: events.php?message=No items to checkout');
        exit;
    }
} else {
    header('Location: events.php');
    exit;
}

// Start transaction
$conn->begin_transaction();

try {
    // Insert the order into the database
    $stmt = $conn->prepare("INSERT INTO orders (user_id, order_id, amount, status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("isd", $user_id, $order_id, $total);
    $stmt->execute();
    
    if ($stmt->affected_rows == 0) {
        throw new Exception("Failed to insert order");
    }
    
    $order_db_id = $stmt->insert_id;

    // Insert order items
    foreach ($items as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, event_id, price) VALUES (?, ?, ?)");
        $stmt->bind_param("iid", $order_db_id, $item['id'], $item['price']);
        $stmt->execute();
        
        if ($stmt->affected_rows == 0) {
            throw new Exception("Failed to insert order item");
        }
    }

    // If we've made it this far, commit the transaction
    $conn->commit();
} catch (Exception $e) {
    // An error occurred, rollback the transaction
    $conn->rollback();
    logError("Error in checkout.php: " . $e->getMessage());
    header('Location: error.php?message=Checkout failed. Please try again.');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Advaita 2024</title>
    <link rel="stylesheet" href="./styles/checkout.css">
</head>
<body>
    <div class="checkout-container">
        <h1>Checkout</h1>
        <p>Order ID: <?php echo $order_id; ?></p>
        <p>Total Amount: ₹<?php echo number_format($total, 2); ?></p>
        <form action="process_payment.php" method="post">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            <input type="hidden" name="amount" value="<?php echo $total; ?>">
            <?php foreach ($items as $index => $item): ?>
                <input type="hidden" name="items[<?php echo $index; ?>][id]" value="<?php echo $item['id']; ?>">
                <input type="hidden" name="items[<?php echo $index; ?>][price]" value="<?php echo $item['price']; ?>">
            <?php endforeach; ?>
            <button type="submit">Proceed to Payment</button>
        </form>
        <a href="cart.php" class="back-button">Back to Cart</a>
        <br>
        <a href="./" class="back-button">home</a>
    </div>
</body>
</html>