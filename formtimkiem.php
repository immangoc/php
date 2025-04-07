<?php
session_start();
require 'User.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm Kiếm Người Dùng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Tìm Kiếm Người Dùng</h2>

    <form action="xltimkiem.php" method="GET" class="mb-4">
        <input type="text" name="keyword" placeholder="Nhập từ khóa (username, email)..." required class="form-control">
        <button type="submit" class="btn btn-primary mt-2">Tìm Kiếm</button>
    </form>

    <!-- Hiển thị kết quả tìm kiếm -->
    <?php if (isset($_SESSION['search_results']) && !empty($_SESSION['search_results'])): ?>
        <h4>Kết quả tìm kiếm:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Đăng Nhập</th>
                    <th>Email</th>
                    <th>Vai Trò</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['search_results'] as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php unset($_SESSION['search_results']); ?>
    <?php elseif (isset($_SESSION['search_message'])): ?>
        <!-- Hiển thị thông báo nếu không có kết quả -->
        <div class="alert alert-danger">
            <?php echo $_SESSION['search_message']; ?>
        </div>
        <?php unset($_SESSION['search_message']); ?>
    <?php endif; ?>

    <div class="text-center">
        <a href="admin.php" class="btn btn-secondary">Quay Lại</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
