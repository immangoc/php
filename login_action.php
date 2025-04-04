<?php
session_start();
require 'User.php';

$user = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra đăng nhập
    $loggedInUser   = $user->login($username, $password);
    if ($loggedInUser ) {
        $_SESSION['user'] = $loggedInUser ;

        // Nếu người dùng chọn "Nhớ mật khẩu"
        if (isset($_POST['remember'])) {
            // Thiết lập cookie cho username và password (mật khẩu nên được mã hóa)
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
