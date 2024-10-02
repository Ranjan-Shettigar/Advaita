<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "college_fest";

// UPI Payment Configuration
$upi_id = "yourupiid123@okhdfcbank";
$payee_name = "Receivername";
$currency = "INR";
$aid = "uGICAgMDM4aL2Ng";

// Gmail credentials
// Gmail credentials
define('GMAIL_USERNAME', 'reqres.team@gmail.com');
define('GMAIL_PASSWORD', 'ecel xxwi dprr bhjd');
define('GMAIL_SENDER_EMAIL', 'reqres.team@gmail.com');


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
