<?php
session_start();
require 'User.php';

$user = new User($pdo);


if (!isset($_SESSION['user']) || !$user->isAdmin($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Người Dùng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <div class="form-box mx-auto shadow-sm p-4 bg-white rounded">
        <h3 class="text-center text-primary mb-4">Thêm Người Dùng Mới</h3>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger text-center">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="xlthem.php" method="POST">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Nhập tên đăng nhập" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="example@domain.com" required>
            </div>

            <div class="form-group">
                <label for="role">Vai trò</label>
                <select name="role" id="role" class="form-control">
                    <option value="user">Người Dùng</option>
                    <option value="admin">Quản Trị</option>
                </select>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success px-4">Thêm Người Dùng</button>
                <a href="admin.php" class="btn btn-secondary ml-2 px-4">Quay Lại</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
