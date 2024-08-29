<?php
session_start();
include 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ./auth/login.php');
    exit;
}

// Fetch user data
$username = $_SESSION['username'];
$user_query = "SELECT user_id, name, username, college, email, phone, created_at FROM users WHERE username = ?";
$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param("s", $username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_data = $user_result->fetch_assoc();

if (!$user_data) {
    die("User not found");
}

$user_id = $user_data['user_id'];

// Fetch purchased events with descriptions for completed orders only
$events_query = "SELECT e.title, e.description FROM events e
                 JOIN order_items oi ON e.id = oi.event_id
                 JOIN orders o ON oi.order_id = o.id
                 WHERE o.user_id = ? AND o.status = 'completed'";
$events_stmt = $conn->prepare($events_query);
$events_stmt->bind_param("i", $user_id);
$events_stmt->execute();
$events_result = $events_stmt->get_result();

$purchased_events = [];
while ($event = $events_result->fetch_assoc()) {
    $purchased_events[] = $event;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user_data['name']); ?> - Profile</title>
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="./styles/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-sidebar">
            <img src="./assets/logo.webp" alt="Profile Picture" class="profile-picture">
            <h1 class="profile-name"><?php echo htmlspecialchars($user_data['name']); ?></h1>
            <p class="profile-username"><?php echo htmlspecialchars($user_data['username']); ?></p>
            <div class="profile-info">
                <p><i class="fas fa-university"></i> <?php echo htmlspecialchars($user_data['college']); ?></p>
                <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($user_data['email']); ?></p>
                <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($user_data['phone']); ?></p>
                <p><i class="fas fa-calendar-alt"></i> Joined <?php echo date('F j, Y', strtotime($user_data['created_at'])); ?></p>
            </div>
        </div>
        <div class="profile-main">
            <div class="events-list">
                <h2>Purchased Events (<?php echo count($purchased_events); ?>)</h2>
                <div class="events-grid">
                    <?php foreach ($purchased_events as $event): ?>
                        <div class="event-card">
                            <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                            <p><?php echo htmlspecialchars($event['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
