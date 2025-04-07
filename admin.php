<?php
session_start();
require 'User.php';

$user = new User($pdo);

// Kiểm tra xem người dùng đã đăng nhập và có vai trò admin chưa
if (!isset($_SESSION['user']) || !$user->isAdmin($_SESSION['user'])) {
    header('Location: login.php'); // Chuyển hướng đến trang đăng nhập nếu không phải admin
    exit;
}

// Số lượng người dùng trên mỗi trang
$users_per_page = 5;

// Lấy trang hiện tại từ URL (nếu không có trang mặc định là 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Tính toán OFFSET
$offset = ($page - 1) * $users_per_page;

// Lấy danh sách người dùng với phân trang
$stmt = $pdo->prepare("SELECT * FROM users LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $users_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Lấy tổng số người dùng để tính số trang
$total_users_stmt = $pdo->query("SELECT COUNT(*) FROM users");
$total_users = $total_users_stmt->fetchColumn();
$total_pages = ceil($total_users / $users_per_page);

// Xóa thông báo tìm kiếm sau khi hiển thị
unset($_SESSION['search_message']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Người Dùng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Link đến CSS riêng -->
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Quản Lý Người Dùng</h2>
   
    <!-- Form tìm kiếm -->
<form action="xltimkiem.php" method="GET" class="mb-4">
    <input type="text" name="keyword" placeholder="Nhập từ khóa (username, email)..." required class="form-control">
    <button type="submit" class="btn btn-primary mt-2">Tìm Kiếm</button>
</form>
    <!-- Bảng người dùng -->
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Tên Đăng Nhập</th>
                <th>Email</th>
                <th>Vai Trò</th>
                <th>Tùy chọn</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?php echo htmlspecialchars($u['id']); ?></td>
                    <td><?php echo htmlspecialchars($u['username']); ?></td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td><?php echo htmlspecialchars($u['role']); ?></td>
                    <td>
                        <a href="formsua.php?id=<?php echo $u['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="formxoa.php?id=<?php echo $u['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>" tabindex="-1">Trước</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo ($page == $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Tiếp</a>
            </li>
        </ul>
    </nav>
    <div class="row mb-4">
        <div class="col-md-6 text-left">
            <a href="formthem.php" class="btn btn-success">Thêm Người Dùng</a>
            <!-- <a href="formtimkiem.php" class="btn btn-success">Tìm Kiếm</a> -->
        </div>
        <div class="col-md-6 text-right">
            <a href="index.php" class="btn btn-secondary">Trở lại</a>
            
        </div>
    </div>

    <!-- <a href="index.php" class="btn btn-primary btn-logout">Trở lại</a> -->
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
