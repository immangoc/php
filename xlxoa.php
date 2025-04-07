<?php
session_start();
require 'User.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Kiểm tra nếu có ID người dùng cần xóa
if (isset($_POST['id'])) {
    $user_id = $_POST['id'];

    // Kiểm tra xem người dùng có tồn tại hay không
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Xóa người dùng
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Chuyển hướng về trang quản lý người dùng sau khi xóa thành công
        header('Location: admin.php');
        exit;
    } else {
        echo "Người dùng không tồn tại.";
    }
} else {
    echo "Không có ID người dùng để xóa.";
}
?>
