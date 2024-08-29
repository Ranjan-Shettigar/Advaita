<?php
include 'includes/config.php';  // Include the database connection file

// Fetch event data including id and readMoreLink
$sql = "SELECT id, imageSrc, iconSrc, title, name, price, mode, description, boxShadow, highlightColor, readMoreLink FROM events";
$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($events);

$conn->close();
?>
