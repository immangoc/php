<?php
require 'User.php';
session_start();

// Kiểm tra xem token có tồn tại trong URL không
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Khởi tạo đối tượng User và kiểm tra token hợp lệ
    $user = new User($pdo);

    // Kiểm tra nếu token hợp lệ và chưa hết hạn
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->execute([$token]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        // Nếu token hợp lệ, tiếp tục với việc xử lý form reset mật khẩu
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['new_password'];

            // Thực hiện reset mật khẩu
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
