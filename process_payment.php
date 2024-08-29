<?php
session_start();
include 'includes/config.php';
require_once 'phpqrcode/qrlib.php';

if (!isset($_SESSION['username']) || !isset($_POST['order_id']) || !isset($_POST['amount']) || !isset($_POST['items'])) {
    header('Location: events.php');
    exit;
}

$order_id = $_POST['order_id'];
$amount = $_POST['amount'];
$items = $_POST['items'];

// UPI details
$upi_id = "yourupiid123@okhdfcbank";
$payee_name = "Receiver Name";
$currency = "INR";
$aid = "uGICAgMDM4aL2Ng";
$upi_link = "upi://pay?pa=$upi_id&pn=" . urlencode($payee_name) . "&am=$amount&cu=$currency&aid=$aid";

// Generate QR code
$tempDir = 'temp/';
$fileName = 'qr_code.png';
$filePath = $tempDir . $fileName;

QRcode::png($upi_link, $filePath, QR_ECLEVEL_L, 10);

// Get user ID from username
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $user_id = $row['user_id'];
} else {
    header('Location: error.php?message=User not found');
    exit;
}

// Fetch the order from the database
$stmt = $conn->prepare("SELECT id FROM orders WHERE order_id = ? AND user_id = ?");
$stmt->bind_param("si", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header('Location: error.php?message=Order not found');
    exit;
}
$order = $result->fetch_assoc();
$order_db_id = $order['id'];

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Processing - Advaita 2024</title>
    
    <link rel="stylesheet" href="./styles/payment.css">
</head>
<body>
    <div class="payment-container">
        <h1>Payment Processing</h1>
        <p>Order ID: <?php echo $order_id; ?></p>
        <p>Please use the following UPI link to complete your payment:</p>
        <button id="payNowBtn" class="upi-link">Pay Now</button>
        
        <p>Alternatively, you can scan the following QR code with your UPI app:</p>
        <img src="<?php echo $filePath; ?>" alt="UPI QR Code" style="max-width: 100%; height: auto;">
        
        <p>After completing the payment, please enter the transaction ID below:</p>
        <form action="verify_payment.php" method="post" id="transactionForm">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            <input type="text" name="transaction_id" required placeholder="Enter Transaction ID">
            <button type="submit">Submit Transaction ID</button>
        </form>

        <p>If you don't want to proceed with the payment, you can cancel the transaction:</p>
        <button id="terminateBtn" class="terminate-link">Cancel Transaction</button>
    </div>

    <script>
        // UPI link
        const upiLink = "<?php echo $upi_link; ?>";
        
        // Function to open UPI link
        function openUPILink() {
            if (/Android|iPhone|iPad/i.test(navigator.userAgent)) {
                window.open(upiLink, '_blank');
            } else {
                alert("Please complete the payment using the QR code provided.");
            }
        }

        // Attach click event to the "Pay Now" button
        document.getElementById('payNowBtn').addEventListener('click', function() {
            openUPILink();
        });

        // Attach click event to the "Cancel Transaction" button
        document.getElementById('terminateBtn').addEventListener('click', function() {
            if (confirm("Are you sure you want to cancel this transaction?")) {
                window.location.href = 'cancel_transaction.php?order_id=<?php echo $order_id; ?>';
            }
        });
    </script>
</body>
</html>