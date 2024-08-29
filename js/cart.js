document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('event-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('buy-now')) {
            const eventId = e.target.dataset.id;
            const eventName = e.target.dataset.name;
            const eventPrice = e.target.dataset.price;

            fetch('generate_payment_link.php')
                .then(response => response.json())
                .then(data => {
                    if (data.upi_link) {
                        // Redirect to the UPI payment link
                        window.location.href = data.upi_link;
                    } else {
                        console.error('Error generating payment link:', data.error);
                        alert('Failed to generate payment link');
                    }
                })
                .catch(error => console.error('Error generating payment link:', error));
        }
    });
});
