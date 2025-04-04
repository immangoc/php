<?php
require 'User.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $user = new User($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newPassword = $_POST['new_password'];

        // Kiểm tra và cập nhật mật khẩu nếu token hợp lệ
        if ($user->resetPassword($token, $newPassword)) {
            echo "Mật khẩu đã được đặt lại thành công.";
        } else {
            echo "Đã xảy ra lỗi. Vui lòng thử lại.";
        }
    }
} else {
    die("Token không hợp lệ.");
}
?>
