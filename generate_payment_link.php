<?php
session_start();
header('Content-Type: application/json');
include 'includes/config.php';

// Get the total amount from the session or cart
$totalAmount = $_SESSION['cart_total']; // You should set this when adding items to the cart

// Example UPI payment details (you should replace these with actual details)
$upiPayeeAddress = 'yourupiid123@okhdfcbank'; // Replace with actual UPI ID
$upiPayeeName = 'Receiver Name'; // Replace with actual name
$currency = 'INR';

// Check if the total amount is set and valid
if (!isset($totalAmount) || !is_numeric($totalAmount) || $totalAmount <= 0) {
    http_response_code(400);
    echo json_encode(array('error' => 'Invalid total amount.'));
    exit;
}

// Generate UPI payment link
$upiLink = "upi://pay?pa={$upiPayeeAddress}&pn={$upiPayeeName}&am={$totalAmount}&cu={$currency}";

$response = array('upi_link' => $upiLink);

echo json_encode($response);
