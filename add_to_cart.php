<?php
session_start();
header('Content-Type: application/json');
include 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(array('error' => 'User not logged in.'));
    exit;
}

$username = $_SESSION['username'];
$event_id = $_POST['event_id'];
$event_name = $_POST['event_name'];
$event_price = $_POST['event_price'];

// Get user ID from the username
$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo json_encode(array('error' => 'User not found.'));
    exit;
}

$user_id = $user['id'];

// Add event to cart
$sql = "INSERT INTO cart (user_id, event_id, event_name, event_price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisd", $user_id, $event_id, $event_name, $event_price);

if ($stmt->execute()) {
    // Update cart total
    $_SESSION['cart_total'] = getCartTotal($user_id, $conn);
    echo json_encode(array('success' => 'Event added to cart.'));
} else {
    echo json_encode(array('error' => 'Failed to add event to cart.'));
}

function getCartTotal($user_id, $conn) {
    $sql = "SELECT SUM(event_price) AS total FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return number_format($row['total'], 2);
}
