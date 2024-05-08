<?php
session_start();
require_once '../../db/database.php';
require_once '../../includes/phpmailer/Exception.php';
require_once '../../includes/phpmailer/PHPMailer.php';
require_once '../../includes/phpmailer/SMTP.php';
require_once '../../includes/function.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $rs = getRow('SELECT * FROM users WHERE forgotToken = :forgotToken', ['forgotToken' => $token]);

    if ($rs) {
        $data = [
            'forgotToken' => ''
        ];

        try {
            $_SESSION['id'] = $rs['id'];
            $rs = update('users', $data, ['id' => $rs['id']]);
            header('Location: http://localhost/WebThiTN-Oto/?module=pages&action=changepassword');
            exit();
        } catch (Exception $e) {
            echo 'Đã xảy ra lỗi';
        }
    } else {
        echo 'Token không hợp lệ hoặc đã hết hạn';
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $data = [
        'email' => $email
    ];

    $rs = getRow('SELECT * FROM users WHERE email = :email', $data);

    if ($rs) {
        $forgotToken = md5($email).time();
        $sendMail = sendMail($email, 'Quên mật khẩu', 'Vui lòng click vào link sau để đổi mật khẩu: <a href="http://localhost/WebThiTN-Oto/client/auth/forgotpassword.php/?token=' . $forgotToken . '">Đổi mật khẩu</a>');
        
        if ($sendMail) {
            try {
                $rs = update('users', ['forgotToken' => $forgotToken], ['email' => $email]);
                $status = 200;
                $msg = 'Vui lòng kiểm tra email để đổi mật khẩu';
            } catch (Exception $e) {
                $status = 404;
                $msg = 'Đã xảy ra lỗi';
            }
        } else {
            $status = 404;
            $msg = 'Gửi email thất bại';
        }
    } else {
        $status = 404;
        $msg = 'Email không tồn tại';
    }

    header('Content-Type: application/json');
    echo json_encode([
        'status' => $status,
        'msg' => $msg
    ]);
} else {
    http_response_code(404);
    die();
}