<?php
session_start();
$is_logged_in = isset($_SESSION['username']); // Determine if user is logged in
$cart_count = 0; // Initialize cart count

// Function to get cart count from the session or database
function getCartCount()
{
    // Example code to get cart count from session or database
    return isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;
}

// Update cart count
$cart_count = getCartCount();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advaita - The Unity of Excellence</title>
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/nav.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <div class="container">
        <div class="load" id="load"> </div>
        <!-- <div class="blur-overlay"></div> -->
        <header>
            <div class="a-text">Advaita<span>2024</span></div>
            <div class="nav-menu-container">
                <nav class="top-nav">
                    <a id="home-page" class="nav-item">Home</a>
                    <a id="event-page" class="nav-item">Events</a>
                    <a id="gallery-page" class="nav-item">Gallery</a>
                    <?php
                    if (isset($_SESSION['username'])) {
                        // User is logged in, display the profile link
                        echo '<a id="profile-page" class="nav-item">' . htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') . '</a>';
                    } else {
                        // User is not logged in, display the login link
                        echo '<a id="profile-page" class="nav-item">User</a>';
                    }
                    ?>
                </nav>
                <div class="menu-icon">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="menu-dropdown" id="menu-dropdown">
                    <a id="sponsors" class="dropdown-item" >Sponsors</a>
                    <?php if (!$is_logged_in) : ?>
                        <a href="./auth/signup.php" class="dropdown-item">Register</a>
                    <?php endif; ?>
                    <a id="about" class="dropdown-item" >About Us</a>

                    <a id="contact" class="dropdown-item" >Contact Us</a>
                    <!-- Dynamic Login/Logout and Cart -->

                    <?php if ($is_logged_in) : ?>
                        <a href="cart.php" class="dropdown-item">Cart (<span id="cart-count"><?php echo htmlspecialchars($cart_count); ?></span>)</a>
                        <a href="auth/logout.php" class="dropdown-item">Logout</a>
                    <?php else : ?>
                        <a href="auth/login.php" class="dropdown-item">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <nav class="bottom-nav">
            <a id="nav-home-page" class="nav-item"><i class="fas fa-house-chimney"></i></a>
            <a id="nav-event-page" class="nav-item"><i class="fas fa-layer-group"></i></a>
            <a id="nav-gallery-page" class="nav-item"><i class="fas fa-camera-retro"></i></a>
            <a id="nav-profile-page" class="nav-item"><i class="fas fa-user-astronaut"></i></a>
        </nav>
    </div>

    <script>
        // document.addEventListener('contextmenu', function(e) {
        //     e.preventDefault();
        // });



        document.querySelector('.menu-icon').addEventListener('click', function() {
            const dropdown = document.querySelector('.menu-dropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });

        window.addEventListener('click', function(e) {
            const menuIcon = document.querySelector('.menu-icon');
            const dropdown = document.querySelector('.menu-dropdown');

            // Close the dropdown if the click is outside the menu icon and dropdown
            if (!menuIcon.contains(e.target) && !dropdown.contains(e.target) && dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            }
        });

        // Check login status using AJAX
        function checkLoginStatus() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', './auth/check_login.php', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    var authLink = document.getElementById('auth-link');
                    if (response.loggedIn) {
                        authLink.href = './auth/logout.php';
                        authLink.textContent = 'Logout';
                    } else {
                        authLink.href = './auth/login.php';
                        authLink.textContent = 'Login';
                    }
                }
            };
            xhr.send();
        }

        // Call the function to check login status on page load
        checkLoginStatus();

        // Function to update cart count
        function updateCartCount() {
            $.ajax({
                url: 'get_cart_count.php',
                method: 'GET',
                success: function(response) {
                    var cartCount = parseInt(response.cart_count);
                    $('#cart-count').text(cartCount);
                },
                error: function() {
                    console.error('Failed to fetch cart count.');
                }
            });
        }

        // Call the function to update cart count on page load
        $(document).ready(function() {
            updateCartCount();
        });
    </script>

    <script id="dynamic-script" src="./js/nav.js"></script>


</body>

</html>