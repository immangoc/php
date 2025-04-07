<?php
require 'User.php'; // Kết nối cơ sở dữ liệu

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Lấy dữ liệu từ form gửi đến
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        
        // Kiểm tra xem username đã tồn tại chưa, nhưng bỏ qua người dùng hiện tại
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND id != :id");
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "Username đã tồn tại, vui lòng chọn username khác!";
            exit; // Dừng lại nếu đã có username
        }

        // Kiểm tra xem email đã tồn tại chưa, nhưng bỏ qua người dùng hiện tại
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND id != :id");
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "Email đã tồn tại, vui lòng chọn email khác!";
            exit; // Dừng lại nếu đã có email
        }

        // Cập nhật thông tin người dùng trong cơ sở dữ liệu
        $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id");
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':role', $role);
        $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header('Location: admin.php'); // Chuyển hướng lại trang quản lý người dùng sau khi sửa thành công
            exit;
        } else {
            echo "Lỗi khi cập nhật thông tin người dùng!";
        }
    }
} else {
    echo "Không có ID người dùng.";
    exit;
}
?>
