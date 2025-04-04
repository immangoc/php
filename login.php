<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h3 class="text-center mb-4">Đăng Nhập</h3>
    <form method="POST" action="login_action.php">
        <div class="form-group">
            <label for="username">Tên Đăng Nhập</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
        </div>
        <div class="form-group">
            <label for="password">Mật Khẩu</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="remember">Nhớ Mật Khẩu</label>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
    </form>
    
    <div class="mt-3 d-flex justify-content-between">
        <a href="forgot_password.php" class="text-secondary">Quên Mật Khẩu?</a>
        <a href="register.php" class="text-primary font-weight-bold">Đăng Ký</a>
    </div>
</div>

<!-- Bootstrap JS & jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
session_start();
require 'User .php';

// Kết nối đến cơ sở dữ liệu
$pdo = new PDO('mysql:host=localhost;dbname=user_management', 'your_username', 'your_password'); // Thay thế bằng thông tin của bạn
$user = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra đăng nhập
    $loggedInUser  = $user->login($username, $password);
    if ($loggedInUser ) {
        $_SESSION['user'] = $loggedInUser ;
        header('Location: index.php'); // Chuyển hướng đến trang chính
        exit;
    } else {
        $error_message = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}
?>
