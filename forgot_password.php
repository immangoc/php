<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên Mật Khẩu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap & Custom CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="forgot-password-container">
    <h3 class="text-center mb-4">Quên Mật Khẩu</h3>
    <form method="POST" action="forgot_password_action.php">
        <div class="form-group">
            <label for="email">Nhập Email Đăng Ký</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="your@example.com" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Gửi Liên Kết Đặt Lại</button>
    </form>

    <div class="text-center mt-3">
        <a href="login.php" class="text-secondary">← Quay lại đăng nhập</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
