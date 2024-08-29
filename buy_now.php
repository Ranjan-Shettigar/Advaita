<?php
session_start();
include 'includes/config.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'An error occurred'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['eventId'], $data['eventName'], $data['eventPrice'])) {
        $eventPrice = $data['eventPrice'];

        // Generate UPI payment link
        $upiId = "yourupiid123@okhdfcbank";
        $payeeName = "Receiver Name";
        $currency = "INR";
        $amount = number_format($eventPrice, 2, '.', '');

        $paymentLink = "upi://pay?pa={$upiId}&pn={$payeeName}&am={$amount}&cu={$currency}";

        $response['success'] = true;
        $response['paymentLink'] = $paymentLink;
    } else {
        $response['message'] = 'Invalid data received';
    }
}

echo json_encode($response);

$conn->close();
?>
