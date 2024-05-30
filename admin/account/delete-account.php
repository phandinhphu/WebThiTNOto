<?php
require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $req = json_decode(file_get_contents('php://input'), true);
    $id = $req['id'];

    $rs = delete('users', ['id' => $id]);

    header('Content-Type: application/json');
    if ($rs) {
        echo json_encode(['message' => 'Delete user successfully', 'status' => 200]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Delete user failed', 'status' => 404]);
    }
}