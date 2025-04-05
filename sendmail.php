<?php
session_start(); // Bắt đầu phiên làm việc
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions

if (isset($_POST['OTPbtn'])) {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $mail = new PHPMailer(true);
    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'phamthang25102004@gmail.com';                     //SMTP username
        $mail->Password   = 'fdjj jiax prvd poey';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('phamthang25102004@gmail.com', 'Test User');
        $mail->addAddress('phamthang25102004@gmail.com', 'Test User');     //Add a recipient
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Mã OTP';
        $mail->Body    = '<h2>Xin chào!</h2>
        <h3>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản '.$email.'của bạn.</h3>
        <h3>Mã OTP của bạn là: 1234</h3>
        <h4>Vui lòng không chia sẻ mã này với bất kỳ ai.</h4>';
    
        if($mail->send()) {
            $_SESSION['status'] = "Thanks for signing up! We've sent you a confirmation email. Please check your inbox."; // Lưu email vào session để sử dụng sau này
            header("Location: {$_SERVER['HTTP_REFERER']}"); // Chuyển hướng về trang quên mật khẩu với email và otp
            exit;
        }
        else {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
        
    } catch (Exception $e) {
        echo "Lỗi gửi mail: {$mail->ErrorInfo}";
        exit;
    }
}
else {
    // Nếu không có POST request, chuyển hướng về trang quên mật khẩu
    header('Location: forgot_password.php');
    exit;
}
?>