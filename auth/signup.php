<?php
require_once '../includes/config.php';
require_once 'smtp/PHPMailerAutoload.php';

// Set secure session parameters
session_set_cookie_params([
    'lifetime' => 7 * 24 * 60 * 60,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();
session_regenerate_id(true);

if (isset($_SESSION['username'])) {
    header("Location: ../");
    exit();
}

function smtp_mailer($email, $subject, $msg) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Username = GMAIL_USERNAME;
    $mail->Password = GMAIL_PASSWORD;
    $mail->setFrom(GMAIL_SENDER_EMAIL, "Advaita");
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->addAddress($email);
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => false
        ]
    ];
    return $mail->send() ? 'Sent' : $mail->ErrorInfo;
}

function sendOTPEmail($email, $otp) {
    $subject = "OTP Verification for Sign Up";
    $logo = 'https://linksync.free.nf/icons/advaita.png';
    $message = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>OTP Verification</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 40px auto; background-color: #FFF; padding: 40px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
                .logo { text-align: center; margin-bottom: 30px; }
                .logo img { max-width: 80px; max-height: 80px; }
                h2 { text-align: center; color: #333; }
                p { line-height: 1.5; color: #555; }
                .otp { font-size: 24px; font-weight: bold; color: #e6a120; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="logo"><img src="' . $logo . '" alt="advaita"></div>
                <h2>OTP Verification for Sign Up</h2>
                <p>Your OTP (One-Time Password) for sign up is:</p>
                <p class="otp">' . $otp . '</p>
                <p>This OTP is valid for 5 minutes.</p>
                <p>Thank you for your understanding.</p>
                <p>Best regards,<br>Advaita</p>
            </div>
        </body>
        </html>
    ';
    return smtp_mailer($email, $subject, $message);
}

function validateAndRegisterUser($conn, $username, $email, $hashedPassword, $name, $college, $phone) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        return "Username already taken. Please choose a different username.";
    }
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, name, college, phone) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $email, $hashedPassword, $name, $college, $phone);
    
    if ($stmt->execute()) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
    return "Something went wrong. Please try again.";
}

$error = $success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['change_email'])) {
        unset($_SESSION['otp'], $_SESSION['email'], $_SESSION['otp_time']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['email'])) {
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } else {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                $error = "You already have an account. Please log in.";
            } else {
                if (!isset($_SESSION['otp']) || time() - $_SESSION['otp_time'] > 300) {
                    $otp = mt_rand(100000, 999999);
                    $sendOTPStatus = sendOTPEmail($email, $otp);
                    if ($sendOTPStatus == 'Sent') {
                        $_SESSION['otp'] = password_hash($otp, PASSWORD_DEFAULT);
                        $_SESSION['email'] = $email;
                        $_SESSION['otp_time'] = time();
                        $success = "OTP sent successfully. Please check your email.";
                    } else {
                        $error = "Error sending OTP: " . $sendOTPStatus;
                    }
                } else {
                    $success = "OTP already sent. Please check your email.";
                }
            }
        }
    } elseif (isset($_POST['otp'])) {
        $enteredOTP = trim($_POST['otp']);
        $name = trim($_POST['name']);
        $college = trim($_POST['college']);
        $phone = trim($_POST['phone']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        if (empty($enteredOTP) || empty($name) || empty($college) || empty($phone) || empty($username) || empty($password)) {
            $error = "All fields are required.";
        } elseif (!password_verify($enteredOTP, $_SESSION['otp'])) {
            $error = "Invalid OTP. Please try again.";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $error = "Name should only contain letters and spaces.";
        } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
            $error = "Invalid phone number. Please enter a 10-digit number.";
        } elseif (!preg_match("/^[a-zA-Z0-9_]{3,20}$/", $username)) {
            $error = "Username should be 3-20 characters long and can only contain letters, numbers, and underscores.";
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*\d).{6,}$/', $password)) {
            $error = "Password must be at least 6 characters long and contain at least one lowercase letter and one number.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $email = $_SESSION['email'];
            $error = validateAndRegisterUser($conn, $username, $email, $hashedPassword, $name, $college, $phone);
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="icon" href="../icons/advaita.png" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/newsignup.css">
</head>
<body>
<div class="home">
    <div class="blur-overlay"></div>
    <div class="container">
        <div class="form-container">
            <h1>Registration</h1>
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            
            <?php if (!isset($_SESSION['email'])): ?>
                <form id="email-form" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                    <div class="form-group">
                        <input type="email" name="email" id="email" placeholder="Email" required>
                    </div>
                    <button type="submit" class="btn">Get OTP</button>
                </form>
            <?php else: ?>
                <form id="registration-form" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                    <div class="form-group">
                        <input type="text" name="otp" id="otp" placeholder="Enter OTP" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="name" id="name" placeholder="Full Name" required pattern="[a-zA-Z ]*">
                    </div>
                    <div class="form-group">
                        <input type="text" name="college" id="college" placeholder="College Name" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" id="phone" placeholder="Phone Number" required pattern="[0-9]{10}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="username" id="username" placeholder="Username" required pattern="[a-zA-Z0-9_]{3,20}">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" placeholder="Password" required pattern="(?=.*[a-z])(?=.*\d).{6,}">
                    </div>
                    <button type="submit" class="btn">Register</button>
                </form>
                <form id="change-email-form" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                    <button type="submit" name="change_email" class="btn btn-secondary">Change Email</button>
                </form>
            <?php endif; ?>
            
            <p class="login-link">
                <a href="login.php">Already have an account? Log in</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>