<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên Mật Khẩu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="forgot-password-container">
    <h3 class="text-center mb-4">Quên Mật Khẩu</h3>
    <form method="POST" action="sendmail.php">
        <div class="form-group">
            <label for="email">Nhập Email Đăng Ký</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="your@example.com" required>
        </div>
        <button type="submit" name="OTPbtn" class="btn btn-primary btn-block">Gửi Liên Kết Đặt Lại</button>
    </form>

    <div class="text-center mt-3">
        <a href="login.php" class="text-secondary">← Quay lại đăng nhập</a>
    </div>

    <?php
    if (isset($_SESSION['status'])) {
        echo "<div class='alert alert-info'>" . $_SESSION['status'] . "</div>";
        unset($_SESSION['status']); 
    }
    ?>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
