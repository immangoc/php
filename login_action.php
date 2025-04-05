<?php
session_start();
require 'User.php';

$user = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra đăng nhập
    $loggedInUser = $user->login($username, $password);
    if ($loggedInUser) {
        $_SESSION['user'] = $loggedInUser;

        // Nếu người dùng chọn "Nhớ mật khẩu"
        if (isset($_POST['remember'])) {
            // Thiết lập cookie cho username và password (mật khẩu nên được mã hóa)
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            setcookie('username', $username, time() + (86400 * 30), "/"); // Cookie tồn tại trong 30 ngày
            setcookie('password', $password, time() + (86400 * 30), "/"); // Cookie tồn tại trong 30 ngày
        } else {
            // Nếu không chọn "Nhớ mật khẩu", xóa cookie
            setcookie('username', '', time() - 3600, "/");
            setcookie('password', '', time() - 3600, "/");
        }

        header('Location: index.php'); // Chuyển hướng đến trang chính
        exit;
    } else {
        $error_message = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <?php
    // Hiển thị thông báo lỗi nếu có
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
        header('Location: login.php?error=' . urlencode($error_message));
    }
    ?>
</body>
</html>
