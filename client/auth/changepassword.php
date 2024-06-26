<?php
session_start();
require_once '../../db/database.php';

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    $data = [
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'updateAt' => date('Y-m-d H:i:s')
    ];

    header('Content-Type: application/json');
    try {
        $rs = update('users', $data, ['id' => $_SESSION['id']]);
        unset($_SESSION['id']);
        echo json_encode(['status' => 200, 'msg' => 'Đổi mật khẩu thành công']);
    } catch (Exception $e) {
        echo json_encode(['status' => 404, 'msg' => 'Đã xảy ra lỗi']);
    }
} else {
    http_response_code(404);
    exit();
}