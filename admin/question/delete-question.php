<?php

require_once '../../db/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $rs = delete('questions', ['id' => $id]);
    if ($rs) {
        $status = 1;
        $message = 'Xóa câu hỏi thành công';
    } else {
        $status = 0;
        $message = 'Xóa câu hỏi thất bại';
    }
    header('Content-Type: application/json');
    echo json_encode([
        'status' => $status,
        'message' => $message
    ]);
} else {
    header("HTTP/1.0 405 Method Not Allowed");
}