<?php
session_start();
require 'User.php';

$user = new User($pdo);

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || !$user->isAdmin($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
// Kiểm tra nếu có thông báo lỗi từ xlsua.php
if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Người Dùng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">Thêm Người Dùng Mới</h3>

    <form action="xlthem.php" method="POST">
        <div class="form-group">
            <label>Tên đăng nhập</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Vai trò</label>
            <select name="role" class="form-control">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Thêm Người Dùng</button>
        <a href="admin.php" class="btn btn-secondary">Quay Lại</a>
    </form>
</div>
</body>
</html>
