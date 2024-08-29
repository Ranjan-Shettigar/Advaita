document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('transaction-form').addEventListener('submit', function (event) {
        event.preventDefault();
        const transactionId = document.getElementById('transaction-id').value;

        fetch('checkout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                transaction_id: transactionId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Checkout successful!');
                window.location.href = 'cart.html';  // Redirect to cart or home
            } else {
                alert('Failed to complete checkout. Please try again.');
            }
        })
        .catch(error => console.error('Error during checkout:', error));
    });
});
