<?php
session_start();
require 'User.php';

$user = new User($pdo);

if (!isset($_SESSION['user']) || !$user->isAdmin($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? 'user';

        // Kiểm tra xem username đã tồn tại chưa
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "Username đã tồn tại, vui lòng chọn username khác!";
            exit; // Dừng lại nếu đã có username
        }
    
        // Kiểm tra xem email đã tồn tại chưa
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "Email đã tồn tại, vui lòng chọn email khác!";
            exit; // Dừng lại nếu đã có email
        }
    
        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        // Thêm người dùng vào cơ sở dữ liệu
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)");
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $hashedPassword);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':role', $role);
    
        if ($stmt->execute()) {
            header('Location: admin.php'); // Chuyển hướng về trang admin sau khi thêm thành công
            exit;
        } else {
            echo "Lỗi khi thêm người dùng!";
        }
    }
?>
