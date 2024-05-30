<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $req = json_decode(file_get_contents('php://input'), true);
    $name = $req['userName'];
    $email = $req['email'];
    $password = $req['password'];
    $phone = $req['phone'];
    $status = $req['status'];

    $data = [
        'userName' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'phone' => $phone,
        'createAt' => date('Y-m-d H:i:s'),
        'status' => $status
    ];

    $rs = insert('users', $data);

    header('Content-Type: application/json');
    if ($rs) {
        echo json_encode(['message' => 'Add user successfully', 'status' => 200]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Add user failed', 'status' => 404]);
    }
}