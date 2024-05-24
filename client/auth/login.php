<?php
session_start();
require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $data = [
        'email' => $email
    ];

    $rs = getRow('SELECT * FROM users WHERE email = :email', $data);

    if ($rs) {
        if (!password_verify($password, $rs['password'])) {
            $status = 404;
            $msg = 'Tài khoản hoặc mật khẩu không đúng';
        } else {
            $isLogin  = getRow('SELECT * FROM login WHERE userId = :userId', ['userId' => $rs['id']]);
            if ($isLogin) {
                $status = 404;
                $msg = 'Tài khoản đã đăng nhập ở một nơi khác';
            } else {
                $data = [
                    'userId' => $rs['id'],
                    'loginAt' => date('Y-m-d H:i:s')
                ];
                insert('login', $data);
                $_SESSION['user'] = $rs;
                $status = 200;
                $msg = 'Đăng nhập thành công';
            }
        }
    } else {
        $status = 404;
        $msg = 'Tài khoản hoặc mật khẩu không đúng';
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