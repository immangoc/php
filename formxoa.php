<?php
session_start();
require 'User.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Kiểm tra xem có ID người dùng để xóa không
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Lấy thông tin người dùng cần xóa
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

     // Kiểm tra xem người dùng có tồn tại hay không
     if ($user) {
        ?>
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Xác Nhận Xóa Người Dùng</title>
            <!-- Liên kết đến Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
        <div class="container mt-5">
            <div class="card shadow-lg">
                <div class="card-header bg-danger text-white text-center">
                    <h3>Xác Nhận Xóa Người Dùng</h3>
                </div>
                <div class="card-body">
                    <p class="text-center">
                        Bạn chắc chắn muốn xóa người dùng <strong><?php echo htmlspecialchars($user['username']); ?></strong> - id: <strong><?php echo htmlspecialchars($user['id']); ?></strong>?
                    </p>
                    <form action="xlxoa.php" method="POST" class="text-center">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                        <button type="submit" class="btn btn-danger btn-lg">Xóa</button>
                        <a href="admin.php" class="btn btn-secondary btn-lg ml-3">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
        <!-- Liên kết đến Bootstrap JS và các thư viện cần thiết -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        echo "Người dùng không tồn tại.";
    }
} else {
    echo "Không có ID người dùng.";
}
?>

