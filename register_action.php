<?php
require 'User.php';

$user = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if ($user->register($username, $password, $email)) {
        echo "Đăng ký thành công!";
    } else {
        echo "Tên đăng nhập hoặc email đã tồn tại.";
    }
}
?>