<?php
$host = 'localhost';
$dbname = 'user_management';
$user = 'root';             
$pass = '';                  

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db = $pdo;
} catch (PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
    die(); 
}
?>
