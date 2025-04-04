<?php
session_start();
require 'User.php';
require 'Database.php'; 
$user = new User($pdo);

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra đăng nhập
    $loggedInUser = $user->login($username, $password);
    if ($loggedInUser) {
        $_SESSION['user'] = $loggedInUser;

        // Nếu người dùng chọn "Nhớ mật khẩu"
        if (isset($_POST['remember'])) {
            // Thiết lập cookie cho username, chỉ lưu username vì mật khẩu không nên lưu trong cookie
            setcookie('username', $username, time() + (86400 * 30), "/"); // Cookie tồn tại trong 30 ngày
        } else {
            // Nếu không chọn "Nhớ mật khẩu", xóa cookie
            setcookie('username', '', time() - 3600, "/");
        }

        header('Location: index.php'); // Chuyển hướng đến trang chính
        exit;
    } else {
        // Thông báo lỗi khi sai tên đăng nhập hoặc mật khẩu
        $error_message = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h3 class="text-center mb-4">Đăng Nhập</h3>
    <?php
    if (isset($error_message)) {
        echo "<div class='alert-danger'>$error_message</div>";
    }
    ?>
    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="username">Tên Đăng Nhập</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập" value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>" required>
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
