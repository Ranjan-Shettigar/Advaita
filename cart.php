<?php
session_start();
include 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ./auth/login.php');
    exit;
}

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle remove from cart action
if (isset($_POST['action']) && $_POST['action'] == 'remove_from_cart') {
    $index = $_POST['index'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
    }
    header('Location: cart.php');
    exit;
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Advaita 2024</title>
    <link rel="stylesheet" href="./styles/cart.css">
</head>
<body>
    <div class="cart-container">
        <h1>Shopping Cart</h1>
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($_SESSION['cart'] as $index => $item): 
                    ?>
                        <tr>
                            <td data-label="Event Name"><?php echo htmlspecialchars($item['name']); ?></td>
                            <td data-label="Price">₹<?php echo number_format($item['price'], 2); ?></td>
                            <td data-label="Action">
                                <form method="post">
                                    <input type="hidden" name="action" value="remove_from_cart">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php $total += $item['price']; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Total: ₹<?php echo number_format($total, 2); ?></p>
            <div class="button-container">
                <a href="./" class="back-button">Back to Events</a>
                <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
        <a href="./" class="back-button">home</a>
    </div>
</body>
</html>