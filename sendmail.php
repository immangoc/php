<?php
session_start(); // Bắt đầu session
require 'database.php';
require 'User.php';

$user = new User($pdo);

if (isset($_POST['OTPbtn'])) {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = "Email không hợp lệ.";
        header("Location: forgot_password.php");
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        $user->sendPasswordResetEmail($email);
        $_SESSION['status'] = "Liên kết đặt lại mật khẩu đã được gửi đến email của bạn.";
    } else {
        $_SESSION['status'] = "Email không tồn tại trong hệ thống.";
    }

    header("Location: forgot_password.php");
    exit;
} else {
    $_SESSION['status'] = "Yêu cầu không hợp lệ.";
    header("Location: forgot_password.php");
    exit;
}
