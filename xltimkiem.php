<?php
session_start();
require 'User.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Kiểm tra nếu có từ khóa tìm kiếm
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    // Chuẩn bị câu truy vấn tìm kiếm chính xác
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :keyword OR email = :keyword");
    $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Nếu không có kết quả tìm kiếm, thêm thông báo lỗi vào session
    if (empty($users)) {
        $_SESSION['search_message'] = "Không tìm thấy người dùng với từ khóa '$keyword'.";
        header('Location: formtimkiem.php');  // Chuyển hướng về trang formtimkiem.php để hiển thị thông báo
        exit;
    } else {
        $_SESSION['search_results'] = $users;  // Lưu kết quả tìm kiếm vào session
        header('Location: formtimkiem.php');  // Chuyển hướng về trang formtimkiem.php để hiển thị kết quả tìm kiếm
        exit;
    }
}
