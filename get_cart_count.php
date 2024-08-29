<?php
session_start();

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Get cart count
$cart_count = count($_SESSION['cart']);

// Return cart count as JSON
header('Content-Type: application/json');
echo json_encode(array('cart_count' => $cart_count));
?>
