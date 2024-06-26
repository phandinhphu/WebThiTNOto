<?php

require_once '../../config.php';
require_once '../../db/database.php';
require_once '../../includes/phpmailer/Exception.php';
require_once '../../includes/phpmailer/PHPMailer.php';
require_once '../../includes/phpmailer/SMTP.php';
require_once '../../includes/function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    $tmp = getRow('SELECT * FROM users WHERE email = :email', ['email' => $email]);

    if ($tmp) {
        $status = 404;
        $msg = 'Email đã tồn tại';
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'msg' => $msg
        ]);
        exit();
    }

    $activeToken = md5($email).time();

    $data = [
        'userName' => $userName,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'phone' => $phone,
        'activeToken' => $activeToken,
        'createAt' => date('Y-m-d H:i:s')
    ];

    $sendMail = sendMail($email, 'Kích hoạt tài khoản', 'Vui lòng click vào link sau để kích hoạt tài khoản: <a href="http://localhost/WebThiTN-Oto/?module=auth&action=active&token=' . $activeToken . '">Kích hoạt</a>');

    if ($sendMail) {
        $rs = insert('users', $data);
        if ($rs) {
            $status = 200;
            $msg = 'Đăng ký thành công. Vui lòng kiểm tra email để kích hoạt tài khoản';
        } else {
            $status = 404;
            $msg = 'Đăng ký thất bại';
        }
    } else {
        $status = 404;
        $msg = 'Gửi mail thất bại';
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