<?php
session_start();
include 'includes/config.php';

// Check if user is logged in
$is_logged_in = isset($_SESSION['username']);

// Get user ID if logged in
if ($is_logged_in) {
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];
    } else {
        header('Location: error.php?message=User not found');
        exit;
    }
}

// SQL query to fetch event data
$sql = "SELECT id,eid, imageSrc, iconSrc, title, name, price, mode, description, boxShadow, highlightColor FROM events";
$result = $conn->query($sql);

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle Add to Cart action
if ($is_logged_in && isset($_POST['action']) && $_POST['action'] == 'add_to_cart') {
    $event_id = $_POST['event_id'];
    $event_name = $_POST['event_name'];
    $event_price = $_POST['event_price'];

    // Check if the event is already purchased
    $stmt = $conn->prepare("SELECT * FROM user_purchases WHERE user_id = ? AND event_id = ?");
    $stmt->bind_param("ii", $user_id, $event_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(array('success' => false, 'message' => 'You have already purchased this event.'));
        exit;
    }

    // Check if the event is already in the cart
    $event_in_cart = false;
    foreach ($_SESSION['cart'] as $item) {
        if ($item['id'] == $event_id) {
            $event_in_cart = true;
            break;
        }
    }

    if (!$event_in_cart) {
        $_SESSION['cart'][] = array(
            'id' => $event_id,
            'name' => $event_name,
            'price' => $event_price
        );
        // Update cart count
        $cart_count = count($_SESSION['cart']);
        echo json_encode(array('success' => true, 'message' => 'Added to cart', 'cart_count' => $cart_count));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Event already in cart'));
    }
    exit;
}

// Get cart count
$cart_count = count($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details - Advaita 2024</title>
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="./styles/nav.css">
    <link rel="stylesheet" href="./styles/event.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="event-container">
        
        <div class="cards-container">
            <div id="event-container" class="container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="event-card" data-id="' . $row['id'] . '">';
                        echo '  <div class="event-title">';
                        echo '    <div class="icon-wrapper" style="box-shadow: ' . $row['boxShadow'] . ';">';
                        echo '      <img src="' . $row['iconSrc'] . '" alt="Icon" class="icon">';
                        echo '    </div>';
                        echo '    <div class="title-text">';
                        echo '      <h3>' . $row['title'] . '</h3>';
                        echo '      <h1 style="color: ' . $row['highlightColor'] . ';">' . $row['name'] . '</h1>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '  <div class="event-image">';
                        echo '    <img src="' . $row['imageSrc'] . '" alt="Event Image">';
                        echo '  </div>';
                        echo '  <div class="event-info">';
                        echo '    <div class="price-mode-container">';
                        echo '      <p class="price">₹' . $row['price'] . '</p>';
                        echo '      <p class="mode">' . $row['mode'] . '</p>';
                        echo '    </div>';
                        echo '    <div class="pdiv">';
                        echo '      <p class="description">' . $row['description'] . '</p>';
                        echo '    </div>';
                        
                        echo '    <a href="events/readmore' . $row['eid'] . '.html" class="read-more" data-page="readmore' . $row['eid'] . '.html">Read more</a>';
                        echo '    <div class="buttons">';
                        
                        if ($is_logged_in) {
                            // Check if the event is already purchased or pending
                            $stmt = $conn->prepare("SELECT status FROM user_purchases WHERE user_id = ? AND event_id = ?");
                            $stmt->bind_param("ii", $user_id, $row['id']);
                            $stmt->execute();
                            $purchase_result = $stmt->get_result();
                            
                            if ($purchase_result->num_rows > 0) {
                                $purchase_status = $purchase_result->fetch_assoc()['status'];
                                
                                switch ($purchase_status) {
                                    case 'completed':
                                        echo '<button class="already-purchased" disabled>Already Purchased</button>';
                                        break;
                                    case 'pending':
                                        echo '<button class="pending-payment" disabled>Pending Verification</button>';
                                        break;
                                    case 'failed':
                                        echo '<button class="add-to-cart" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-price="' . $row['price'] . '">Add to Cart</button>';
                                        echo '<button class="buy-now" data-id="' . $row['id'] . '" data-price="' . $row['price'] . '">Buy Now</button>';
                                        break;
                                }
                            } else {
                                // No purchase record found, display normal buttons
                                echo '<button class="add-to-cart" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-price="' . $row['price'] . '">Add to Cart</button>';
                                echo '<button class="buy-now" data-id="' . $row['id'] . '" data-price="' . $row['price'] . '">Buy Now</button>';
                            }
                        } else {
                            echo '<button class="add-to-cart login-required">Add to Cart</button>';
                            echo '<button class="buy-now login-required">Buy Now</button>';
                        }
                        
                        
                        echo '    </div>';
                        echo '  </div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No events found.</p>";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <div id="load"></div> <!-- Placeholder for dynamic content -->

    <script>
// Global flag to track initialization
window.eventHandlersInitialized = false;

function initializeEventHandlers() {
    // Check if handlers have already been initialized
    if (window.eventHandlersInitialized) {
        console.log('Event handlers already initialized. Skipping...');
        return;
    }

    console.log('Initializing event handlers...');

    $('.add-to-cart').click(function() {
        var button = $(this);
        
        // If user is not logged in, redirect to login page
        if (button.hasClass('login-required')) {
            window.location.href = 'auth/login.php';
            return;
        }

        var eventId = button.data('id');
        var eventName = button.data('name');
        var eventPrice = button.data('price');
        
        $.ajax({
            url: 'events.php',
            method: 'POST',
            data: {
                action: 'add_to_cart',
                event_id: eventId,
                event_name: eventName,
                event_price: eventPrice
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    alert('Event added to cart!');
                    // Update cart count
                    var currentCount = parseInt($('#cart-count').text());
                    $('#cart-count').text(currentCount + 1);
                    // Disable the button
                    button.prop('disabled', true).text('In Cart');
                } else {
                    alert(result.message);
                }
            },
            error: function() {
                alert('Failed to add event to cart. Please try again.');
            }
        });
    });

    $('.buy-now').click(function() {
        var button = $(this);

        // If user is not logged in, redirect to login page
        if (button.hasClass('login-required')) {
            window.location.href = 'auth/login.php';
            return;
        }

        var eventId = button.data('id');
        var eventPrice = button.data('price');
        window.location.href = 'checkout.php?event_id=' + eventId + '&price=' + eventPrice;
    });

    // Set the flag to true after initialization
    window.eventHandlersInitialized = true;
    console.log('Event handlers initialized successfully.');
}

// This ensures the function is available globally
window.initializeEventHandlers = initializeEventHandlers;

// Call the initialization function when the document is ready
if (typeof jQuery !== 'undefined') {
    $(document).ready(initializeEventHandlers);
} else {
    document.addEventListener('DOMContentLoaded', initializeEventHandlers);
}
</script>
</body>
</html>

