<?php
require 'User.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra nếu có ID người dùng được gửi qua GET
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Lấy thông tin người dùng từ cơ sở dữ liệu
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "<div class='alert alert-warning text-center mt-4'>Không tìm thấy người dùng.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-warning text-center mt-4'>ID người dùng không hợp lệ.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Người Dùng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap + CSS riêng -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- File CSS bạn đã có -->
</head>
<body>

<div class="register-container">
    <h3 class="text-center mb-4 text-primary">Sửa Thông Tin Người Dùng</h3>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <form action="xlsua.php?id=<?php echo $user['id']; ?>" method="POST">
        <div class="form-group">
            <label for="username">Tên Đăng Nhập</label>
            <input type="text" class="form-control" id="username" name="username"
                   value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="role">Vai Trò</label>
            <select class="form-control" id="role" name="role">
                <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
            </select>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-block">Cập Nhật</button>
            <a href="admin.php" class="btn btn-secondary btn-block mt-2">Hủy Bỏ</a>
        </div>
    </form>
</div>

</body>
</html>
