<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $req = json_decode(file_get_contents('php://input'), true);
    $id = $req['id'];
    $username = $req['userName'];
    $email = $req['email'];
    $phone = $req['phone'];
    $status = $req['status'];

    $data = [
        'userName' => $username,
        'email' => $email,
        'phone' => $phone,
        'updateAt' => date('Y-m-d H:i:s'),
        'status' => $status
    ];

    $rs = update('users', $data, ['id' => $id]);

    header('Content-Type: application/json');
    if ($rs) {
        echo json_encode(['message' => 'Update user successfully', 'status' => 200]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Update user failed', 'status' => 404]);
    }
} else {
    http_response_code(404);
}