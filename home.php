<?php
session_start();
include 'includes/config.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advaita - The Unity of Excellence</title>
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="home">
        <div class="blur-overlay"></div>
        <div class="main-content">
            <div class="logo"></div>
            <div class="title_logo"></div>
            <div class="content-wrapper">
                <h2>The Unity of Excellence</h2>
                <p>Advaita is a vibrant celebration of student creativity, unity, and diversity, showcasing talent,
                    innovation, and collaborative energy.</p>
                <div class="date">August | 28 | 2024</div>
                <?php if (!$isLoggedIn) : ?>
                    <button class="get-started" onclick="window.location.href='./auth/signup.php'">Get Started</button>
                <?php else : ?>
                    <h3>Welcome, <?php echo htmlspecialchars($username); ?>!</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
