<?php
require 'User.php';
session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $user = new User($pdo);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->execute([$token]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['new_password'];

            if ($user->resetPassword($token, $newPassword)) {
                echo "<div style='color: green; font-weight: bold;'>Mật khẩu đã được đặt lại thành công. Bạn có thể <a href='login.php'>đăng nhập</a> ngay bây giờ.</div>";
            } else {
                echo "Đã xảy ra lỗi. Vui lòng thử lại.";
            }
        }
    } else {
        echo "Token không hợp lệ hoặc đã hết hạn.";
    }
} else {
    die("Token không hợp lệ.");
}
?>
