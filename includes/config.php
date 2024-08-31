<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "college_fest";




// Gmail credentials
define('GMAIL_USERNAME', 'yur@gmail.com');
define('GMAIL_PASSWORD', 'scbv dsgq tuai xaos');
define('GMAIL_SENDER_EMAIL', 'yur@gmail.com');


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
