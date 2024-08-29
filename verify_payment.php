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

if (!isset($_SESSION['username']) || !isset($_POST['order_id']) || !isset($_POST['transaction_id'])) {
    logError("Missing required session or POST data");
    header('Location: events.php');
    exit;
}

$order_id = $_POST['order_id'];
$transaction_id = $_POST['transaction_id'];

try {
    // Fetch user details
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT user_id, email, phone, name FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();

    if (!$user) {
        throw new Exception("User not found");
    }

    // Fetch order details
    $stmt = $conn->prepare("SELECT o.id AS order_db_id, o.amount, o.status, oi.event_id, e.name AS event_name 
                            FROM orders o 
                            JOIN order_items oi ON o.id = oi.order_id 
                            JOIN events e ON oi.event_id = e.id 
                            WHERE o.order_id = ? AND o.user_id = ?");
    $stmt->bind_param("si", $order_id, $user['user_id']);
    $stmt->execute();
    $order_result = $stmt->get_result();
    $order_items = $order_result->fetch_all(MYSQLI_ASSOC);

    if (empty($order_items)) {
        throw new Exception("Order not found");
    }

    $order_db_id = $order_items[0]['order_db_id'];
    $current_status = $order_items[0]['status'];

    if ($current_status === 'completed') {
        $message = "This order has already been processed and completed.";
    } else {
        // Start transaction
        $conn->begin_transaction();

        try {
            // Update the order status in the database
            $status = 'pending';
            $stmt = $conn->prepare("UPDATE orders SET status = ?, transaction_id = ? WHERE id = ?");
            $stmt->bind_param("ssi", $status, $transaction_id, $order_db_id);
            $stmt->execute();

            if ($stmt->affected_rows == 0) {
                throw new Exception("Failed to update order status");
            }

            // Generate receipt with INR instead of ₹
            $receipt = "Receipt for Order: $order_id\n\n";
            $receipt .= "Name: " . $user['name'] . "\n";
            $receipt .= "Email: " . $user['email'] . "\n";
            $receipt .= "Phone: " . $user['phone'] . "\n\n";
            $receipt .= "Items Purchased:\n";
            foreach ($order_items as $item) {
                $receipt .= $item['event_name'] . " - INR " . number_format($item['amount'], 2) . "\n";
            }
            $receipt .= "\nTotal Amount: INR " . number_format($order_items[0]['amount'], 2) . "\n";
            $receipt .= "Transaction ID: $transaction_id\n";

            // Save receipt to database
            $stmt = $conn->prepare("UPDATE orders SET receipt = ? WHERE id = ?");
            $stmt->bind_param("si", $receipt, $order_db_id);
            $stmt->execute();

            if ($stmt->affected_rows == 0) {
                throw new Exception("Failed to save receipt");
            }

            // Add to user_purchases
            foreach ($order_items as $item) {
                $stmt = $conn->prepare("INSERT INTO user_purchases (user_id, event_id, order_id) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $user['user_id'], $item['event_id'], $order_id);
                $stmt->execute();

                if ($stmt->affected_rows == 0) {
                    throw new Exception("Failed to add to user purchases");
                }
            }

            // If we've made it this far, commit the transaction
            $conn->commit();
            $message = "Payment recorded successfully! Your order is pending admin verification. Once the payment is confirmed, your order will be displayed on your profile.";

            // Clear the cart if it was a cart purchase
            if (isset($_SESSION['cart'])) {
                unset($_SESSION['cart']);
            }
        } catch (Exception $e) {
            // An error occurred, rollback the transaction
            $conn->rollback();
            throw $e;
        }
    }
} catch (Exception $e) {
    logError("Error in verify_payment.php: " . $e->getMessage());
    $message = "Failed to verify payment. Please contact support. Error: " . $e->getMessage();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Verification - Advaita 2024</title>
    
    <link rel="stylesheet" href="./styles/verification.css">
</head>
<body>
    <div class="verification-container">
        <h1>Payment Verification</h1>
        <p><?php echo $message; ?></p>
        <?php if (isset($receipt)): ?>
            <h2>Receipt</h2>
            <pre><?php echo $receipt; ?></pre>
            <a href="download_receipt.php?order_id=<?php echo $order_id; ?>" class="download-button">Download Receipt</a>
        <?php endif; ?>
        <a href="./" class="back-button">Back to Events</a>
    </div>
</body>
</html>