<?php
session_start();
include 'includes/config.php';

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php');
    exit;
}

// Handle payment verification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_payment'])) {
    $order_id = $_POST['order_id'];
    $verification_status = $_POST['verification_status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->bind_param("ss", $verification_status, $order_id);
    $stmt->execute();

    if ($verification_status === 'completed') {
        // Update user_purchases table
        $stmt = $conn->prepare("INSERT INTO user_purchases (user_id, event_id) SELECT o.user_id, oi.event_id FROM orders o JOIN order_items oi ON o.id = oi.order_id WHERE o.order_id = ?");
        $stmt->bind_param("s", $order_id);
        $stmt->execute();
    }

    $message = "Payment status updated successfully.";
}

// Fetch pending payments
$stmt = $conn->prepare("SELECT o.order_id, o.amount, o.transaction_id, o.status, u.username FROM orders o JOIN users u ON o.user_id = u.user_id WHERE o.status IN ('awaiting verification', 'pending') ORDER BY o.created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$pending_payments = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Verify Payments</title>
    <link rel="stylesheet" href="styles/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Admin - Verify Payments</h1>
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Amount</th>
                <th>Transaction ID</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($pending_payments as $payment): ?>
                <tr>
                    <td><?php echo $payment['order_id']; ?></td>
                    <td><?php echo $payment['username']; ?></td>
                    <td>₹<?php echo $payment['amount']; ?></td>
                    <td><?php echo $payment['transaction_id']; ?></td>
                    <td><?php echo $payment['status']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="order_id" value="<?php echo $payment['order_id']; ?>">
                            <select name="verification_status">
                                <option value="completed">Verify</option>
                                <option value="failed">Reject</option>
                            </select>
                            <button type="submit" name="verify_payment">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>