<?php
session_start();
include 'includes/config.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'An error occurred'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['transactionId'])) {
        $userId = $_SESSION['user_id'];
        $transactionId = $data['transactionId'];

        // Update the database to mark the purchase as completed
        $updateQuery = "UPDATE cart SET transaction_id = ?, status = 'completed' WHERE user_id = ? AND status = 'pending'";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("si", $transactionId, $userId);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Purchase completed successfully!';
        } else {
            $response['message'] = 'Failed to complete purchase';
        }

        $stmt->close();
    } else {
        $response['message'] = 'Invalid data received';
    }
}

echo json_encode($response);

$conn->close();
?>
