<?php
require 'User.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    die("Token không hợp lệ.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt Lại Mật Khẩu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<div class="reset-password-container">
    <h3 class="text-center mb-4">Đặt Lại Mật Khẩu</h3>

    <form method="POST" action="reset_password_action.php?token=<?php echo htmlspecialchars($token); ?>">
        <div class="form-group">
            <label for="new_password">Mật Khẩu Mới</label>
            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới" required>
        </div>
        <button type="submit" class="btn btn-success btn-block">Xác Nhận</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
