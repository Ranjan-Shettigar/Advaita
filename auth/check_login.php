<?php
// Disable error output
ini_set('display_errors', 0);

// Start output buffering
ob_start();

// Start the session
session_start();

// Include database connection
include 'includes/config.php';

// Function to return JSON response
function send_json_response($data) {
    ob_clean(); // Clear the output buffer
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}

// Check if this is an AJAX request
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

try {
    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        // User is logged in
        if ($isAjax) {
            send_json_response(['loggedIn' => true, 'username' => $_SESSION['username']]);
        } else {
            // If it's not an AJAX request, redirect to a default page for logged-in users
            header("Location: ./");
            exit();
        }
    } else {
        // User is not logged in
        if ($isAjax) {
            send_json_response(['loggedIn' => false, 'redirect' => 'auth/login.php']);
        } else {
            // Redirect to login page if it's not an AJAX request
            header("Location: login.php");
            exit();
        }
    }
} catch (Exception $e) {
    // Catch any exceptions and return them as part of the JSON response
    send_json_response(['error' => true, 'message' => $e->getMessage()]);
}

// If we get here, something unexpected happened
$error = error_get_last();
if ($error !== null) {
    send_json_response(['error' => true, 'message' => $error['message']]);
} else {
    send_json_response(['error' => true, 'message' => 'An unknown error occurred']);
}

// Close the database connection if it was opened in config.php
if (isset($conn)) {
    $conn->close();
}
?>