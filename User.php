<?php
require 'database.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($username, $password, $email) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $hashedPassword, $email]);
    }

    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function isAdmin($user) {
        return $user['role'] === 'admin';
    }

    public function sendPasswordResetEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            $token = bin2hex(random_bytes(50));
            date_default_timezone_set('Asia/Ho_Chi_Minh'); 
            $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));


            $stmt = $this->db->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
            $result = $stmt->execute([$token, $expiry, $email]);
    

            if ($result) {
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'immangoc@gmail.com';
                    $mail->Password = 'ausq swxr vfcl kkua'; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
    
                    $mail->setFrom('immangoc@gmail.com', 'SYSTEM');
                    $mail->addAddress($email);
    
                    $resetLink = "http://localhost/php/reset_password.php?token=$token";
    
                    $mail->isHTML(true);
                    $mail->Subject = 'RESET PASSWORD';
                    $mail->Body = "
                        <h3>Xin chào!</h3>
                        <p>Bạn đã yêu cầu khôi phục mật khẩu.</p>
                        <p>Nhấp vào liên kết sau để đặt lại mật khẩu:</p>
                        <a href='$resetLink'>$resetLink</a>
                        <p><small>Liên kết có hiệu lực trong vòng 1 giờ.</small></p>
                    ";
    
                    $mail->send();
                } catch (Exception $e) {
                    error_log("Mail error: " . $mail->ErrorInfo);
                }
            } else {
                error_log("Error: Token không thể lưu vào cơ sở dữ liệu.");
            }
        } else {

            error_log("Error: Không tìm thấy email trong hệ thống.");
        }
    }
    
    public function resetPassword($token, $newPassword) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    
            $stmt = $this->db->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
            $success = $stmt->execute([$hashedPassword, $user['id']]);
    
            if ($success) {
                return true;
            } else {
                return false;
            }
        } else {
            $stmt = $this->db->prepare("UPDATE users SET reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
            $stmt->execute([$token]);
    
            return false; 
        }
    }    
}
?>
