<?php
session_start();
require 'User.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}


if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];


    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :keyword OR email = :keyword");
    $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if (empty($users)) {
        $_SESSION['search_message'] = "Không tìm thấy người dùng với từ khóa '$keyword'.";
        header('Location: formtimkiem.php');  
        exit;
    } else {
        $_SESSION['search_results'] = $users;  
        header('Location: formtimkiem.php');  
        exit;
    }
}
