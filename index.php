<?php
session_start();
require 'User.php';

$user = new User($pdo);

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Lấy thông tin người dùng từ session
$currentUser = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Chính</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="dashboard-container">
    <h2 class="text-center mb-4">Chào mừng, <span class="text-primary"><?php echo htmlspecialchars($currentUser['username']); ?></span>!</h2>
    
    <p class="text-center">Vai trò của bạn: <strong><?php echo htmlspecialchars($currentUser['role']); ?></strong></p>

    <hr>

    <?php if ($user->isAdmin($currentUser)): ?>
        <div class="text-center mb-4">
            <h4>Khu vực quản trị viên</h4>
            <p>Bạn có thể quản lý người dùng tại đây:</p>
            <a href="admin.php" class="btn btn-primary btn-custom">Quản Lý Người Dùng</a>
        </div>
    <?php else: ?>
        <div class="text-center mb-4">
            <h4>Thông tin người dùng</h4>
            <p>Đây là khu vực dành cho người dùng thông thường.</p>
        </div>
    <?php endif; ?>

    <div class="text-center">
        <a href="logout.php" class="btn btn-outline-danger btn-custom">Đăng Xuất</a>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
