
$(document).ready(function () {
    $('.update-form').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        var currentStatus = form.find('input[name="current_status"]').val();
        var newStatus = form.find('select[name="status"]').val();

        if (newStatus === 'failed') {
            if (confirm("Warning: Setting the status to 'failed' will remove this order from user purchases and update both orders and user_purchases tables. Are you sure you want to proceed?")) {
                submitForm(form);
            }
        } else if (currentStatus === 'completed' && newStatus !== 'completed') {
            if (confirm("Warning: You are changing the status from 'completed'. This will update both orders and user_purchases tables. Are you sure you want to proceed?")) {
                submitForm(form);
            }
        } else {
            submitForm(form);
        }
    });

    function submitForm(form) {
        $.ajax({
            url: 'admin.php',
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error("An error occurred: " + error);
                alert("An error occurred while updating the status. Please try again.");
            }
        });
    }

    // Optional: Add search functionality
    $('#searchForm').on('submit', function (e) {
        e.preventDefault();
        var searchTerm = $('input[name="search"]').val();
        window.location.href = 'admin.php?search=' + encodeURIComponent(searchTerm);
    });
});
