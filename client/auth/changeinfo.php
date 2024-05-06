<?php
session_start();

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['user']['id'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $data = [
        'email' => $email,
        'phone' => $phone,
        'updateAt' => date('Y-m-d H:i:s'),
    ];
    try {
        update('users', $data, ['id' => $id]);
        $status = 200;
        $message = 'Cập nhật thông tin thành công';
    } catch (Exception $e) {
        $status = 500;
        $message = 'Lỗi hệ thống';
    }

    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
} else {
    http_response_code(403);
    die();
}