<?php
session_start();
require 'User.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

if (isset($_POST['id'])) {
    $user_id = $_POST['id'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: admin.php');
        exit;
    } else {
        echo "Người dùng không tồn tại.";
    }
} else {
    echo "Không có ID người dùng để xóa.";
}
?>
