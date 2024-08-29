<?php
session_start();
include 'includes/config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, 'error.log');
}

if (!isset($_SESSION['username']) || !isset($_GET['order_id'])) {
    logError("Missing required session or GET data");
    header('Location: events.php');
    exit;
}

$order_id = $_GET['order_id'];
$message = "";

try {
    $conn->begin_transaction();

    // Fetch order details
    $stmt = $conn->prepare("
        SELECT o.id AS order_db_id, o.status, o.user_id
        FROM orders o
        JOIN users u ON o.user_id = u.user_id
        WHERE o.order_id = ? AND u.username = ?
    ");
    $stmt->bind_param("ss", $order_id, $_SESSION['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    $order_data = $result->fetch_assoc();

    if (!$order_data) {
        throw new Exception("Order not found or does not belong to the current user");
    }

    if ($order_data['status'] === 'completed') {
        $message = "This order has already been completed and cannot be cancelled.";
    } elseif ($order_data['status'] === 'failed') {
        $message = "This order has already been cancelled or failed.";
    } else {
        // Update the order status to 'failed' (cancelled)
        $status = 'failed';
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $order_data['order_db_id']);
        $stmt->execute();

        if ($stmt->affected_rows == 0) {
            throw new Exception("Failed to update order status");
        }

        // Delete related entries in order_items and user_purchases
        $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->bind_param("i", $order_data['order_db_id']);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM user_purchases WHERE order_id = ?");
        $stmt->bind_param("s", $order_id);
        $stmt->execute();

        $conn->commit();
        $message = "Your transaction has been successfully cancelled.";
    }
} catch (Exception $e) {
    $conn->rollback();
    logError("Error in cancel_transaction.php: " . $e->getMessage());
    $message = "Failed to cancel the transaction. Please contact support. Error: " . $e->getMessage();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Cancellation - Advaita 2024</title>
    <link rel="stylesheet" href="./styles/cancellation.css">
</head>
<body>
    <div class="cancellation-container">
        <h1>Transaction Cancellation</h1>
        <p><?php echo $message; ?></p>
        <a href="./" class="back-button">Back to Events</a>
    </div>
</body>
</html>
