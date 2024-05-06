<?php
session_start();
require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['user']['id'];
    $password = $_POST['password'];
    $newpassword = $_POST['newpassword'];

    $rs = getRow('SELECT * FROM users WHERE id = :id', ['id' => $id]);
    if (password_verify($password, $rs['password'])) {
        $data = [
            'password' => password_hash($newpassword, PASSWORD_DEFAULT),
            'updateAt' => date('Y-m-d H:i:s'),
        ];
        try {
            update('users', $data, ['id' => $id]);
            $status = 200;
            $message = 'Đổi mật khẩu thành công';
        } catch (Exception $e) {
            $status = 500;
            $message = 'Lỗi hệ thống';
        }
    } else {
        $status = 404;
        $message = 'Mật khẩu không đúng';
    }
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
} else {
    http_response_code(403);
    die();
}